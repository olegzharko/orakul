<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;
use Techouse\IntlDateTime\IntlDateTime as DateTime;

class CalendarCards extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Card::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $group = "Календар";

    public static function label()
    {
        return "Картки";
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
            DateTime::make('Дата зустрічі', 'datetime')->timeFormat('HH:mm')->onlyOnForms(),
            BelongsTo::make('Кімната', 'room', 'App\Nova\Room'),
            BelongsTo::make('Нотаріус', 'notary', 'App\Nova\Notary')->nullable(),
            BelongsTo::make('Забудовник', 'dev_company', 'App\Nova\DevCompany')->nullable(),
            BelongsTo::make('Підписант', 'dev_representative', 'App\Nova\Client')->onlyOnForms()->nullable(),
            BelongsTo::make('Менеджер', 'manager', 'App\Nova\Client')->onlyOnForms()->nullable(),
            BelongsTo::make('Місце складання договору', 'city', 'App\Nova\City')->onlyOnForms()->nullable(),
            Toggle::make('Картка обробляється', 'generator'),
            Toggle::make('Картка готова', 'ready'),
            Toggle::make('Картка скасована', 'cancelled'),
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
