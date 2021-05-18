<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;

class ClientCheckList extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ClientCheckList::class;

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
        return "Перевірки клієнтів";
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
            BelongsTo::make('Клієнт', 'client', 'App\Nova\Client'),
            Toggle::make('Згода подружжя', 'spouse_consent'),
            Toggle::make('Актуальне місце проживання', 'current_place_of_residence'),
            Toggle::make('Фото в паспорті', 'photo_in_the_passport'),
            Toggle::make('Довідка переселенця', 'immigrant_help'),
            Toggle::make('Паспорт', 'passport'),
            Toggle::make('Код', 'tax_code'),
            Toggle::make('Оцінка в фонді', 'Evaluation in the fund'),
            Toggle::make('Перевірка на ФОП', 'check_fop'),
            Toggle::make('Скани документів', 'document_scans'),
            Toggle::make('Єдиний реєстр судових рішень', 'unified_register_of_court_decisions'),
            Toggle::make('Санкції', 'sanctions'),
            Toggle::make('Фінмоніторинг', 'financial_monitoring'),
            Toggle::make('Єдиний реєстр боржників', 'unified_register_of_debtors'),
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
