<?php

namespace App\Jobs;

use App\ApiClients\AlphaClient;
use App\DTO\CompanyDTO;
use App\DTO\ExchangeDTO;
use App\DTO\IndustryDTO;
use App\DTO\Responses\CompanyOverviewDTO;
use App\DTO\SectorDTO;
use App\Models\Company;
use App\Models\Exchange;
use App\Models\Industry;
use App\Models\Sector;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CompanyOverviewJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $ticker;

    /**
     * The unique ID of the job.
     *
     * @return string
     */
    public function uniqueId(): string
    {
        return $this->ticker;
    }

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ticker)
    {
        $this->onQueue('companyOverview');
        $this->ticker = Str::upper($ticker);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(AlphaClient $alphaClient)
    { //step_1: получаем данные с фин.API
        try {
            $response = $alphaClient->companyOverview($this->ticker);
            $responseDTO = CompanyOverviewDTO::make($response->json());
            DB::beginTransaction();
            /*2 делаем сущность Exchange */
            try {
                $exchangeDTO = ExchangeDTO::createFromAPI($responseDTO)->validated();
            } catch (ValidationException $e) {
                $this->fail($e->getMessage());
            }

            $exchange = Exchange::query()
                ->firstOrNew(['name' => $exchangeDTO['name']]);
            $exchange->fill($exchangeDTO);
            $exchange->save();

            /*3 делаем сущность Sector*/
            try {
                $sectorDTO = SectorDTO::createFromAPI($responseDTO)->validated();
            } catch (ValidationException $e) {
                $this->fail($e->getMessage());
            }

            /**
             * @var Sector $sector
             */
            $sector = Sector::query()
                ->firstOrNew(['name' => $sectorDTO['name']]);
            $sector->fill($sectorDTO);
            $sector->save();

            /*4 делаем сущность Industry*/
            try {
                $industryDTO = IndustryDTO::createFromAPI($responseDTO)->validated();
            } catch (ValidationException $e) {
                $this->fail($e->getMessage());
            }

            /**
             * @var Industry $industry
             */
            $industry = Industry::query()
                ->firstOrNew(['name' => $industryDTO['name']]);
            $industry->fill($industryDTO);
            $industry->sector()->associate($sector);
            $industry->save();

            /*5 делаем сущность Company*/
            try {
                $companyDTO = CompanyDTO::createFromAPI($responseDTO)->validated();
            } catch (ValidationException $e) {
                $this->fail($e->getMessage());
            }

            /** @var Company $company */
            $company = Company::query()
                ->firstOrNew(['ticker' => $companyDTO['ticker']]);
            $company->fill($companyDTO);
            $company->exchange()->associate($exchange);
            $company->sector()->associate($sector);
            $company->industry()->associate($industry);
            $company->save();

            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage(), (array)$this->ticker);
            DB::rollBack();
            $this->fail($e->getMessage());

            return;
        }
    }
}
