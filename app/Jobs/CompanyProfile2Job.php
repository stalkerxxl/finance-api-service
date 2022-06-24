<?php

namespace App\Jobs;

use App\ApiClients\FinhubClient;
use App\DTO\CompanyDTO;
use App\DTO\ExchangeDTO;
use App\DTO\EarningDTO;
use App\DTO\Response\CompanyProfile2DTO;
use App\Models\Company;
use App\Models\Exchange;
use App\Models\Industry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

class CompanyProfile2Job implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $ticker;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public int $tries = 20;

    public function uniqueId(): string
    {
        return $this->ticker;
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */
    #[Pure]
    public function __construct($ticker)
    {
        $this->ticker = Str::upper($ticker);
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware(): array
    {
        return [(new RateLimited('companyProfile2Job'))];
    }

    /**
     * Execute the job.
     *
     * @param  FinhubClient  $client
     * @return void
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function handle(FinhubClient $client): void
    {
        DB::beginTransaction();
        //1 get json from api
        try {
            $response = $client->companyProfile2($this->ticker);
            $responseDTO = CompanyProfile2DTO::make($response->json());

            //2 make Exchange
            $exchangeDTO = ExchangeDTO::make()->fromCompanyProfile2($responseDTO)->validated();
            $exchange = Exchange::query()->firstOrNew(['name' => $exchangeDTO['name']]);
            $exchange->fill($exchangeDTO);
            $exchange->save();

            /*3 make Industry*/
            $industryDTO = EarningDTO::make()->fromCompanyProfile2($responseDTO)->validated();
            $industry = Industry::query()->firstOrNew(['name' => $industryDTO['name']]);
            $industry->fill($industryDTO);
            $industry->save();

            /*4 make Company*/
            $companyDTO = CompanyDTO::make()->fromCompanyProfile2($responseDTO)->validated();
            $company = Company::query()->firstOrNew(['ticker' => $companyDTO['ticker']]);
            $company->fill($companyDTO);
            // 5 relations
            $company->exchange()->associate($exchange);
            $company->industry()->associate($industry);
            $company->save();

            /*6 download logo */
            CompanyLogoDownload::dispatchIf(empty($company->logo), $company);
            DB::commit();
        } catch (\Exception $e) {
            Log::error($this->ticker, (array)$e->getMessage());
            DB::rollBack();
            $this->fail($e->getMessage());
        }
    }
}
