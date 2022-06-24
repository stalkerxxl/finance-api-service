<?php

namespace App\Jobs;

use App\ApiClients\FinhubClient;
use App\DTO\InsiderDTO;
use App\DTO\Response\EarningsCalendarDTO;
use App\DTO\TransactionDTO;
use App\Models\Company;
use App\Models\Insider;
use App\Models\Transactions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

class InsiderTransactionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ?string $ticker;

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
    public function __construct($ticker = null)
    {
        $this->ticker = Str::upper($ticker);
    }

    /**
     * Execute the job.
     *
     * @param  FinhubClient  $client
     * @return array|null
     */
    public function handle(FinhubClient $client): void
    {
        DB::beginTransaction();
        try {
            // get api json
            $response = $client->insiderTransactions($this->ticker)->collect('data');

            //2 delete non-exist in DB tickers
            $response->each(callback: function ($item, $key) {
                /**
                 * @var Company $company
                 */
                $company = Company::query()->where(['ticker' => $item['symbol']])->first();
                if (!$company) {
                    return;
                }
                //3 make responseDTO
                $responseDTO = EarningsCalendarDTO::make($item);
                //4 make Insider
                /** @var Insider $insider */
                $insiderDTO = InsiderDTO::make()
                    ->fromInsiderTransactions($responseDTO)->validated();
                $insider = Insider::query()->firstOrNew(['name' => $insiderDTO['name']]);
                $insider->fill($insiderDTO);
                $insider->save();

                //4 make Transaction
                $transactionDTO = TransactionDTO::make()
                    ->fromInsiderTransactions($responseDTO)
                    ->validated();
                $transaction = Transactions::query()
                    ->firstOrNew(
                        array_merge(
                            $transactionDTO,
                            [
                                'company_id' => $company->id,
                                'insider_id' => $insider->id,
                            ]
                        )
                    );

                $transaction->save();
                DB::commit();
            });
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error(__CLASS__, (array)$e->getMessage());
            $this->fail($e->getMessage());
        }

    }
}
