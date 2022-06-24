<?php

namespace App\Nova;

use App\Nova\Metrics\CompaniesPerExchange;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Exchange extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Exchange::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = ['name', 'slug', 'tw_slug'];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Name')
                ->creationRules(
                    'required',
                    'unique:exchanges,name',
                    'max:255',
                    'string'
                )
                ->updateRules(
                    'required',
                    'unique:exchanges,name,{{resourceId}}',
                    'max:255',
                    'string')
                ->placeholder('Name')
                ->showOnPreview(),

            Text::make('tw_slug')
                ->creationRules(
                    'nullable',
                    'unique:exchanges,tw_slug',
                    'max:255',
                    'string'
                )
                ->updateRules(
                    'nullable',
                    'unique:exchanges,tw_slug,{{resourceId}}',
                    'max:255',
                    'string')
                ->placeholder('TW_slug')
                ->showOnPreview(),

            Number::make('Companies', 'companies_count')
                ->sortable()->exceptOnForms()->showOnPreview(),

            //FIXME переделать, когда настрою авто-статус Exchange
            Badge::make('Status')
                ->map([
                '?' => 'info',
                'open' => 'success',
                'close' => 'danger',
                'ex_hours' => 'warning'
            ])->showOnPreview(),

            Slug::make('Slug')->from('Name')
                ->creationRules(
                    'required',
                    'unique:exchanges,slug',
                    'max:255',
                    'string'
                )
                ->updateRules(
                    'required',
                    'unique:exchanges,slug,{{resourceId}}',
                    'max:255',
                    'string'
                )->hideFromIndex()
                ->placeholder('Slug'),

            Boolean::make('is_active')->showOnPreview(),

            HasMany::make('Companies'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request): array
    {
        return [
            new CompaniesPerExchange()
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
