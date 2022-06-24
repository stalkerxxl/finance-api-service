<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class News extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\News::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'category';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = ['category'];

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

            Text::make('Category')
                ->rules('nullable', 'max:255', 'string')
                ->placeholder('Category'),

            Date::make('Timestamp')
                ->rules('required', 'date')
                ->placeholder('Timestamp'),

            Text::make('Headline')
                ->rules('required', 'max:255', 'string')
                ->placeholder('Headline'),

            Image::make('Image Url')
                ->rules('nullable', 'image', 'max:1024')
                ->placeholder('Image Url'),

            Text::make('Source')
                ->rules('nullable', 'max:255', 'string')
                ->placeholder('Source'),

            Textarea::make('Summary')
                ->rules('nullable', 'max:255', 'string')
                ->placeholder('Summary'),

            Text::make('News Url')
                ->rules('nullable', 'max:255', 'string')
                ->placeholder('News Url'),

            BelongsTo::make('Company')->nullable(),
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
