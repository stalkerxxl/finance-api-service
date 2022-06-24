<?php

namespace App\Nova\Metrics;

use App\Models\Exchange;
use Illuminate\Support\Str;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class CompaniesPerExchange extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  NovaRequest  $request
     * @return PartitionResult
     */
    public function calculate(NovaRequest $request): PartitionResult
    {
        return $this->result(
            Exchange::all()
                ->pluck('companies_count', 'name')
                ->toArray()
        );
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor(): \DateInterval|float|\DateTimeInterface|int|null
    {
        return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey(): string
    {
        return 'companies-per-exchange';
    }
}
