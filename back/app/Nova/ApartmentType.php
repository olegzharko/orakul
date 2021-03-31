<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Http\Requests\NovaRequest;

class ApartmentType extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ApartmentType::class;

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

    public static $group = "Типи";

    public static function label()
    {
        return "Житлове приміщення"; // TODO: Change the autogenerated stub
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
            Text::make('Назва скорочено', 'short')->creationRules('unique:apartment_types,short')->updateRules('unique:apartment_types,short,{{resourceId}}'),
            Text::make('Назва у називному відмінку', 'title_n')->creationRules('unique:apartment_types,title_n')->updateRules('unique:apartment_types,title_n,{{resourceId}}'),
            Text::make('Назва у родовому відмінку', 'title_r')->creationRules('unique:apartment_types,title_r')->updateRules('unique:apartment_types,title_r,{{resourceId}}'),
            Text::make('Назва у знахідному відмінку', 'title_z')->creationRules('unique:apartment_types,title_z')->updateRules('unique:apartment_types,title_z,{{resourceId}}'),
            Text::make('Назва у місцевому відмінку', 'title_m')->creationRules('unique:apartment_types,title_m')->updateRules('unique:apartment_types,title_m,{{resourceId}}'),
            Heading::make("Називний: хто? що? - ластівк-а"),
            Heading::make("Родовий: кого?чого? - ластівк-и"),
            Heading::make("Давальний: кому?чому? - ластівц-і"),
            Heading::make("Знахідний: кого?що? -	ластівк-у"),
            Heading::make("Орудний: ким?чим? - ластівк-ою"),
            Heading::make("Місцевий: на кому?на чому? - на ластівц-і"),
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
