<?php

namespace App\Jobs;

use App\ApiClients\FinhubClient;
use App\DTO\EarningDTO;
use App\DTO\Response\EarningsCalendarDTO;
use App\Models\Company;
use App\Models\Earning;
use App\Models\Exchange;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EarningsCalendarJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 10;
    private ?string $ticker;

    public function uniqueId(): ?string
    {
        return $this->ticker;
    }

    public function __construct($ticker = null)
    {
        $this->ticker = $ticker;
    }


    public function handle(FinhubClient $client)
    {
        DB::beginTransaction();
        try {
            $response = $client->earningsCalendar($this->ticker)->collect('earningsCalendar');
            //2 delete non-exist in DB tickers
            // FIXME 1500 запросов..
            $response->each(callback: function ($item, $key) {

                $company = Company::query()->where(['ticker' => $item['symbol']])->first();
                if (!$company) {
                    return;
                }
                $responseDTO = EarningsCalendarDTO::make($item);
// TODO почему всегда обновляет данные????
                $earningDTO = EarningDTO::make()
                    ->fromEarningsCalendar($responseDTO)
                    ->validated();

                Earning::query()->updateOrCreate(
                    [
                        'company_id' => $company->id,
                        'date' => $earningDTO['date'],
                    ],
                    $earningDTO
                );

                DB::commit();
            });
// подумать как сделать массово и для тикера
        } catch (\Exception $e) {
            Log::error($this->ticker, (array)$e->getMessage());
            DB::rollBack();
            $this->fail($e->getMessage());
        }
    }
}
