<?php

namespace App\Nova;

use App\Nova\Lenses\MostMarketCapCompany;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Country;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * @property string $currency
 * @property string $ticker
 */
class Company extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static string $model = \App\Models\Company::class;

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
    public static $search = ['ticker', 'name'];

    public static $with = ['allTransactions'];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     * @noinspection PhpUndefinedFieldInspection
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Ticker')
                ->creationRules(
                    'required',
                    'unique:companies,ticker',
                    'max:10',
                    'string'
                )
                ->updateRules(
                    'required',
                    'unique:companies,ticker,{{resourceId}}',
                    'max:10',
                    'string'
                )
                ->placeholder('Ticker')
                ->sortable(),

            //FIXME вынести в метод
            Avatar::make('logo')
                ->textAlign('left')
                ->disableDownload()
                ->disk('company-logo')
                ->storeAs(storeAsCallback: function (NovaRequest $request) {
                    $file = pathinfo(path: $request->logo->getClientOriginalName());

                    return $this->ticker.'.'.$file['extension'];
                }),

            Text::make('Name')
                ->creationRules(
                    'required',
                    'unique:companies,name',
                    'max:255',
                    'string'
                )
                ->updateRules(
                    'required',
                    'unique:companies,name,{{resourceId}}',
                    'max:255',
                    'string'
                )
                ->placeholder('Name')
                ->sortable(),

            BelongsTo::make('Exchange')->hideFromIndex(),
            BelongsTo::make('Industry')->sortable()->textAlign('left'),

            Country::make('Country')
                ->rules('required', 'max:30', 'string')
                ->placeholder('Country')
                ->hideFromIndex()
                ->sortable(),

            Text::make('Currency')
                ->rules('required', 'max:3', 'string')
                ->placeholder('Currency')
                ->onlyOnDetail()
                ->sortable(),


            Currency::make('Fast Price')
                ->rules('nullable', 'numeric')
                ->placeholder('FastPrice')
                ->readonly()
                ->exceptOnForms()
                ->currency($this->currency)
                ->sortable(),

            Number::make('Market Cap')
                ->rules('nullable', 'numeric')
                ->placeholder('Market Cap')
                ->sortable(),

            Date::make('Ipo Date')
                ->rules('required', 'date')
                ->textAlign('right')
                ->displayUsing(fn($value) => $value->diffForHumans())
                ->sortable()
                ->filterable(),

            Text::make('Phone')
                ->rules('nullable', 'string')
                ->placeholder('Phone')
                ->hideFromIndex()
                ->sortable(),

            Number::make('Shares Out')
                ->rules('required', 'numeric')
                ->placeholder('Shares Out')
                ->hideFromIndex()
                ->sortable(),

            URL::make('Web Url')
                ->displayUsing(fn() => "{$this->ticker} URL")
                ->rules('nullable', 'max:255', 'string')
                ->placeholder('Web Url')
                ->hideFromIndex()
                ->sortable(),

            DateTime::make('updated', 'updated_at')
                ->sortable()
                ->displayUsing(fn($value) => $value->diffForHumans())
                ->textAlign('right'),

            KeyValue::make('metric')->rules('json'),

            HasMany::make('allTransactions', 'allTransactions', Transactions::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [
            new MostMarketCapCompany,
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
