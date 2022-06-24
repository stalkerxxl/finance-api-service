<?php

namespace App\Console\Commands;

use App\ApiClients\FinhubClient;
use App\Jobs\CompanyProfile2Job;
use Illuminate\Console\Command;
use JetBrains\PhpStorm\NoReturn;

class JobManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:manager';

    public static int $delay = 10;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Job Manager';

    /**
     * Execute the console command.
     *
     * @param  FinhubClient  $client
     * @return int
     */
    public function handle(FinhubClient $client): int
    {
        $sp500List = $client->indexConstituents('^NDX')->json('constituents');
        //$sp500List = ['AAPL', 'PFG'];
        foreach ($sp500List as $key => $value) {

            //dump($key, $value);
            $job = CompanyProfile2Job::dispatch($value)->delay(self::$delay);
            self::$delay += 2;
            //dd(self::$delay);
        }
        return 0;
    }
}
