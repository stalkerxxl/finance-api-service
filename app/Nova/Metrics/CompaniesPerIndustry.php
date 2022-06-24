<?php

namespace App\Nova\Metrics;

use App\Models\Industry;
use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class CompaniesPerIndustry extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return PartitionResult
     */
    public function calculate(NovaRequest $request): PartitionResult
    {
        return $this->result(
            Industry::query()->orderByDesc('companies_count')->limit(5)
                ->pluck('companies_count', 'name')->toArray());
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor(): \DateInterval|float|DateTimeInterface|int|null
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
        return 'companies-per-industry';
    }

    /**
     * Get the displayable name of the metric
     *
     * @return string
     */
    public function name(): string
    {
        return 'TOP 5 Industry (count Company)';
    }
}
