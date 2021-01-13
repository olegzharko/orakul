<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class District extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\District::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title_n';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $group = "Локації";

    public static function label()
    {
        return "Район";
    }



    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Heading::make('<p class="text-success">Додано визначення обсласті для перевірки правильно обраного району для міста (city-region == city-district-region)</p>')->asHtml(),
            BelongsTo::make('Область', 'region', 'App\Nova\Region'),
            Text::make('Назва району у називному відмінку', 'title_n')->creationRules('unique:districts,title_n')->updateRules('unique:districts,title_n,{{resourceId}}'),
            Text::make('Назва району у родовому відмінку', 'title_r')->creationRules('unique:districts,title_r')->updateRules('unique:districts,title_r,{{resourceId}}'),
            Text::make('Назва району у знахідному відмінку', 'title_z')->creationRules('unique:districts,title_z')->updateRules('unique:districts,title_z,{{resourceId}}'),
            Text::make('Назва району у місцевому відмінку', 'title_m')->creationRules('unique:districts,title_m')->updateRules('unique:districts,title_m,{{resourceId}}'),
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
