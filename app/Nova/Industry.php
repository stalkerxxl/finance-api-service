<?php

namespace App\Nova;

use App\Nova\Metrics\CompaniesPerExchange;
use App\Nova\Metrics\CompaniesPerIndustry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Industry extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Industry::class;

    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['companies'];

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
    public static $search = ['name'];

    public static function indexQuery(NovaRequest $request, $query): Builder
    {
        // adds a `companies_count` column to the query result based on
        // number of tags associated with this product
        return $query;
    }

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
                    'unique:industries,name',
                    'max:255',
                    'string'
                )
                ->updateRules(
                    'required',
                    'unique:industries,name,{{resourceId}}',
                    'max:255',
                    'string'
                )
                ->placeholder('Name')
                ->sortable()
                ->showOnPreview(),

            Slug::make('Slug')->from('Name')
                ->creationRules(
                    'required',
                    'unique:industries,slug',
                    'max:255',
                    'string'
                )
                ->updateRules(
                    'required',
                    'unique:industries,slug,{{resourceId}}',
                    'max:255',
                    'string'
                )
                ->hideFromIndex()
                ->placeholder('Slug')
                ->showOnPreview(),

            Number::make('Companies', 'companies_count')
                ->sortable()->exceptOnForms()->showOnPreview(),

            Boolean::make('is_active')->showOnPreview()->sortable(),

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
            (new CompaniesPerIndustry())->width('1/3')->dynamicHeight(),
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
