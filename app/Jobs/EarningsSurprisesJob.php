<?php

namespace App\Jobs;

use App\ApiClients\FinhubClient;
use App\DTO\Response\EarningsCalendarDTO;
use App\DTO\EarningDTO;
use App\DTO\Response\EarningsSurprisesDTO;
use App\DTO\SurpriseDTO;
use App\Models\Company;
use App\Models\Surprise;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EarningsSurprisesJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $ticker;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 10;

    public function uniqueId(): string
    {
        return $this->ticker;
    }


    public function __construct($ticker)
    {
        $this->ticker = Str::upper($ticker);
    }

    public function handle(FinhubClient $client)
    {
        DB::beginTransaction();
        try {
            $response = $client->earningsSurprises($this->ticker)->json();
            foreach ($response as $item) {
                $responseDTO = EarningsSurprisesDTO::make($item);

                /** @var Company $company */
                $company = Company::query()->where(['ticker' => $responseDTO->symbol])->first();
                // make SurpriseDTO
                $surpriseDTO = SurpriseDTO::make()->fromEarningsSurprises($responseDTO)
                    ->validated();

                Surprise::query()->updateOrCreate(
                    [
                        'company_id' => $company->id,
                        'period' => $surpriseDTO['period'],
                    ],
                    $surpriseDTO
                );
            };

            DB::commit();
        } catch (\Exception $e) {
            Log::error($this->ticker, (array)$e->getMessage());
            DB::rollBack();
            $this->fail($e->getMessage());
        }
    }
}
