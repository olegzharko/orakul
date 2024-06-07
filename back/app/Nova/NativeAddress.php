<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;

class NativeAddress extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\NativeAddress::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public static $group = "Угода";

    public static function label()
    {
        return "Місце народження";
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
            BelongsTo::make('Клієнт', 'client', 'App\Nova\Client')->nullable(),
            BelongsTo::make('Населений пункту', 'city', 'App\Nova\City')->nullable(),
            BelongsTo::make('Тип вулиці', 'address_type', 'App\Nova\AddressType')->nullable(),
            Text::make('Назва вулиці', 'address'),
            BelongsTo::make('Тип будинку', 'building_type', 'App\Nova\BuildingType')->nullable(),
            Text::make('Номер будинку', 'building'),
            BelongsTo::make('Тип житлового приміщення', 'apartment_type', 'App\Nova\ApartmentType')->nullable(),
            Text::make('Номер житлового приміщення', 'apartment_num'),
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
