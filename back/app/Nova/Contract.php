<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;
use Techouse\IntlDateTime\IntlDateTime as DateTime;

class Contract extends Resource
{
    use HasSortableRows;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Contract::class;

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

    public static $group = "Угода";

    public static function label()
    {
        return "Договір";
    }

    public static function canSort(NovaRequest $request)
    {
        return true;
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
            BelongsTo::make('Тип договору', 'template', 'App\Nova\TemplateType')->onlyOnForms()->nullable(),
            BelongsTo::make('Об\'єкт нерухомості', 'immovable', 'App\Nova\Immovable')->onlyOnForms()->nullable(),
            DateTime::make('Дата зустрічі', 'event_datetime')->timeFormat('HH:mm'),
            BelongsTo::make('Забудовник', 'developer', 'App\Nova\Developer')->onlyOnForms()->nullable(),
            BelongsTo::make('Підписант', 'assistant', 'App\Nova\Assistant')->onlyOnForms()->nullable(),
            BelongsTo::make('Менеджер', 'manager', 'App\Nova\Manager')->onlyOnForms()->nullable(),
            BelongsTo::make('Клієнт', 'client', 'App\Nova\Client')->onlyOnForms()->nullable(),
            BelongsTo::make('Нотаріус', 'notary', 'App\Nova\Notary')->onlyOnForms()->nullable(),
            BelongsTo::make('Видавач', 'reader', 'App\Nova\Staff')->onlyOnForms()->nullable(),
            BelongsTo::make('Читач', 'delivery', 'App\Nova\Staff')->onlyOnForms()->nullable(),
            BelongsTo::make('Оцінка майна', 'pvprice', 'App\Nova\PVPrice')->onlyOnForms()->nullable(),
            DateTime::make('Дата підписання угоди', 'sign_date'),
            Toggle::make('Активний', 'active'),
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
