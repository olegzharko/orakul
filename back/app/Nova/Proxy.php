<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Techouse\IntlDateTime\IntlDateTime as DateTime;

class Proxy extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Proxy::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */

    public static $group = "Забудовник";

    public function title()
    {
        return $this->dev_company->title . " " . $this->title . " " . $this->number;
    }

    public static function label()
    {
        return "Довіренності забудовників для представників";
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
            BelongsTo::make('Забудовник', 'dev_company', 'App\Nova\DevCompany'),
            DateTime::make('Доручення від', 'date'),
//            BelongsTo::make('Представник', 'dev_representative', 'App\Nova\Client')->nullable(),
            Text::make('Номер реєстраціх у нотаріуса', 'reg_num'),
            BelongsTo::make('Нотаріус', 'notary', 'App\Nova\Notary'),
            DateTime::make('Дата реєстрації у нотаріуса', 'reg_date'),
            DateTime::make('Дійсно до', 'final_date'),
            Text::make('Заголовок', 'title'),
            Text::make('Номер', 'number'),
            HasMany::make('Люди', 'member', 'App\Nova\Client'),
            HasMany::make('Будинки', 'building', 'App\Nova\DeveloperBuilding'),
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
