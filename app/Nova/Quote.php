<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class Quote extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Quote::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'quote_time';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = ['quote_time'];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make('id')->sortable(),

            Number::make('Current Price')
                ->rules('required', 'numeric')
                ->placeholder('Current Price'),

            Number::make('Change Day')
                ->rules('required', 'numeric')
                ->placeholder('Change Day'),

            Number::make('Change Percent')
                ->rules('required', 'numeric')
                ->placeholder('Change Percent'),

            Number::make('High Day')
                ->rules('required', 'numeric')
                ->placeholder('High Day'),

            Number::make('Low Day')
                ->rules('required', 'numeric')
                ->placeholder('Low Day'),

            Number::make('Open Day')
                ->rules('required', 'numeric')
                ->placeholder('Open Day'),

            Number::make('Previous Close')
                ->rules('required', 'numeric')
                ->placeholder('Previous Close'),

            Date::make('Quote Time')
                ->rules('required', 'date')
                ->placeholder('Quote Time'),

            BelongsTo::make('Company'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
