<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Citizenship extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Citizenship::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title_n';

    public static $group = "Типи";

    public static function label()
    {
        return "Громадянство";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

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
            Heading::make('<p class="text-success">Називний: хто? що? - ластівк-а</p>')->asHtml(),
            Text::make('Назва', 'title_n'),
            Heading::make('<p class="text-success">Родовий: кого?чого? - ластівк-и</p>')->asHtml(),
            Text::make('Назва', 'title_r'),
//            Heading::make('<p class="text-success">Давальний: кому?чому? - ластівц-і</p>')->asHtml(),
//            Text::make('Назва', 'title_d'),
//            Heading::make('<p class="text-success">Знахідний: кого?що? -	ластівк-у</p>')->asHtml(),
//            Text::make('Назва', 'title_z'),
            Heading::make('<p class="text-success">Орудний: ким?чим? - ластівк-ою</p>')->asHtml(),
            Text::make('Назва', 'title_o'),
//            Heading::make('<p class="text-success">Місцевий: на кому?на чому? - на ластівц-і</p>')->asHtml(),
//            Text::make('Назва', 'title_m'),
//            Heading::make('<p class="text-success">Кличний', 'title_k</p>')->asHtml(),
//            Text::make('Назва', 'title_k'),
//            Heading::make("Називний: хто? що? - ластівк-а"),
//            Heading::make("Родовий: кого?чого? - ластівк-и"),
//            Heading::make("Давальний: кому?чому? - ластівц-і"),
//            Heading::make("Знахідний: кого?що? -	ластівк-у"),
//            Heading::make("Орудний: ким?чим? - ластівк-ою"),
//            Heading::make("Місцевий: на кому?на чому? - на ластівц-і"),
//            Heading::make("Кличний: * * - ластівк-о"),
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
