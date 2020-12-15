<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;
use Techouse\IntlDateTime\IntlDateTime as DateTime;

class Developer extends Resource
{
    use HasSortableRows;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Developer::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $group = "Забудоник";

    public static function label()
    {
        return "Забудовник";
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
            Text::make('Заголовок', 'title')->rules('required'),
            Text::make('Прізвище', 'surname')->rules('required'),
            Text::make('Ім\'я', 'name')->rules('required'),
            Text::make('По батькові', 'patronymic')->rules('required'),
            DateTime::make('Дата народження', 'birthday'),
            BelongsTo::make('Чоловік/Дружина', 'developer_spouses', 'App\Nova\DeveloperSpouse')->nullable(),
            Text::make('ІНН', 'tax_code'),
            BelongsTo::make('Тип паспорту', 'passport_type', 'App\Nova\PassportType'),
            Text::make('Номер паспорта', 'passport_code'),
            DateTime::make('Дата видачі', 'passport_date'),
            Text::make('Орган що видав паспорт', 'passport_department'),
            Text::make('Запису в ЄДДР', 'passport_demographic_code'),
            BelongsTo::make('Область', 'region', 'App\Nova\Region'),
            BelongsTo::make('Тип населеного пункту', 'city_type', 'App\Nova\CityType'),
            Text::make('Населений пункт', 'city'),
            BelongsTo::make('Тип вулиці', 'address_type', 'App\Nova\AddressType'),
            Text::make('Назва вулиці', 'address'),
            Text::make('Номер будинку', 'building'),
            Text::make('Номер квартири', 'apartment'),
            Toggle::make('Ативувати', 'active')->color('#165153'),
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
