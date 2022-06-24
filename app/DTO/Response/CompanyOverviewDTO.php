<?php

namespace App\DTO\Responses;


/**
 * Type Casting JSON-response
 *
 * @returns CompanyOverviewDTO
 *
 * api-json: https://www.alphavantage.co/query?function=OVERVIEW&symbol=IBM&apikey=demo
 *
 * @property int|null $market_cap
 * @property string|null $ticker
 * @property string|null $name
 * @property string|null $description
 * @property string|null $address
 * @property string|null $fiscal_year_end
 * @property string|null $latest_quarter
 * @property int|null $cik
 * @property string|null $exchangeName
 * @property string|null $sectorName
 * @property int|null $shares_out
 * @property int|null $ebitda
 * @property float|null $pe_ratio
 * @property float|null $peg_ratio
 * @property string|null $industryName
 * @property float|null $book_value
 * @property float|null $div_per_share
 * @property float|null $div_yield
 * @property float|null $eps
 * @property float|null $profit_margin
 * @property float|null $target_price
 * @property float|null $year_low
 * @property float|null $year_high
 * @property float|null $ma50
 * @property float|null $ma200
 * @property float|null $beta
 * @property string|null $div_date
 * @property string|null $ex_div_date
 */
class CompanyOverviewDTO
{

    public static function make($json): CompanyOverviewDTO
    {
        $dto = new self();
        $dto->mappedData($json);
        return $dto;
    }

   /* public static function replaceNoneToNull($response)
    {
        $data = "None";
        $var = is_numeric($data) ? floatval($data) : null;
        var_dump($var);
        foreach ($response as $key => $value) {
            $response[$key] = $value === 'None' ? null : $value;
        }

        return $response;
    }*/

    private function mappedData($json): void
    {   //Company model
        //FIXME как быть, если в $json нет какого-то свойства?
        $this->ticker = is_string($json['Symbol']) ? $json['Symbol'] : null;
        $this->name = is_string($json['Name']) ? $json['Name'] : null;
        $this->description = is_string($json['Description']) ? $json['Description'] : null;
        $this->address = is_string($json['Address']) ? $json['Address'] : null;
        $this->fiscal_year_end = is_string($json['FiscalYearEnd']) ? $json['FiscalYearEnd'] : null;
        $this->latest_quarter = is_string($json['LatestQuarter']) ? $json['LatestQuarter'] : null;
        $this->cik = is_numeric($json['CIK']) ? intval($json['CIK']) : null;
        //Exchange model
        $this->exchangeName = is_string($json['Exchange']) ? $json['Exchange'] : null;
        //Sector model
        $this->sectorName = is_string($json['Sector']) ? $json['Sector'] : null;
        //Industry model
        $this->industryName = is_string($json['Industry']) ? $json['Industry'] : null;
        //Company model
        $this->market_cap = is_numeric($json['MarketCapitalization']) ? intval($json['MarketCapitalization']) : null;
        $this->shares_out = is_numeric($json['SharesOutstanding']) ? intval($json['SharesOutstanding']) : null;
        $this->ebitda = is_numeric($json['EBITDA']) ? intval($json['EBITDA']) : null;
        $this->pe_ratio = is_numeric($json['PERatio']) ? floatval($json['PERatio']) : null;
        $this->peg_ratio = is_numeric($json['PEGRatio']) ? floatval($json['PEGRatio']) : null;
        $this->book_value = is_numeric($json['BookValue']) ? floatval($json['BookValue']) : null;
        $this->div_per_share = is_numeric($json['DividendPerShare']) ? floatval($json['DividendPerShare']) : null;
        $this->div_yield = is_numeric($json['DividendYield']) ? floatval($json['DividendYield']) : null;
        $this->eps = is_numeric($json['EPS']) ? floatval($json['EPS']) : null;
        $this->profit_margin = is_numeric($json['ProfitMargin']) ? floatval($json['ProfitMargin']) : null;
        $this->target_price = is_numeric($json['AnalystTargetPrice']) ? floatval($json['AnalystTargetPrice']) : null;
        $this->year_low = is_numeric($json['52WeekLow']) ? floatval($json['52WeekLow']) : null;
        $this->year_high = is_numeric($json['52WeekHigh']) ? floatval($json['52WeekHigh']) : null;
        $this->ma50 = is_numeric($json['50DayMovingAverage']) ? floatval($json['50DayMovingAverage']) : null;
        $this->ma200 = is_numeric($json['200DayMovingAverage']) ? floatval($json['200DayMovingAverage']) : null;
        $this->beta = is_numeric($json['Beta']) ? floatval($json['Beta']) : null;
        //может прилелеть и '2022-12-31', и 'None'
        $this->div_date = $json['DividendDate'] != 'None' ? $json['DividendDate'] : null;
        $this->ex_div_date = $json['ExDividendDate'] != 'None' ? $json['ExDividendDate'] : null;
    }
}
