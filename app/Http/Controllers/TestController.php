<?php

namespace App\Http\Controllers;

use App\Jobs\EarningsCalendarJob;
use App\Jobs\EarningsSurprisesJob;
use App\Jobs\InsiderTransactionsJob;
use App\Models\Company;


class TestController extends Controller
{
    public function one()
    {
        $companies = Company::all('ticker')->pluck('ticker');

        foreach ($companies as $number => $ticker) {
            //dd($companies, $ticker);
            InsiderTransactionsJob::dispatch($ticker)->delay($number + 2);
        }
        /*CompanyProfile2Job::dispatchSync('aapl');*/
        //InsiderTransactionsJob::dispatchSync();
    }

    public function earningsSurprises(){
        EarningsSurprisesJob::dispatchSync('aapl');
        return view('welcome');
    }

    public function earningsCalendar(){
        EarningsCalendarJob::dispatchSync('amzn');
        return view('welcome');
    }
}
