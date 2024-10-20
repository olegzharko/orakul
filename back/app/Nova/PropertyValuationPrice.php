<?php

namespace App\Nova;

use App\Models\Immovable;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Techouse\IntlDateTime\IntlDateTime as DateTime;
use Vyuldashev\NovaMoneyField\Money;

class PropertyValuationPrice extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\PropertyValuationPrice::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
//    public static $title = 'id';

    public function title()
    {
        $title = '';
        if ($this->property_valuation) {
            $title .= $this->property_valuation->title;
        }
        if ($this->immovable) {
            $title .= '  Номер: ' .  $this->immovable->registration_number . '  Від:' . date_format($this->date, 'd-m-Y');
        }

        return $title;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    // public static $group = "Об'єкт";
    public static $group = "Перевірки";

    public static function label()
    {
        return "Оцінка";
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
            BelongsTo::make('Нерухомість', 'immovable', 'App\Nova\Immovable'),
            BelongsTo::make('Оцінка від', 'property_valuation', 'App\Nova\PropertyValuation'),
            DateTime::make('Дата оцінки', 'date'),
            Money::make('grn', 'UAH')->storedInMinorUnits(),
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
