<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;
use SimpleSquid\Nova\Fields\AdvancedNumber\AdvancedNumber;
use Vyuldashev\NovaMoneyField\Money;
use Techouse\IntlDateTime\IntlDateTime as DateTime;
use Laravel\Nova\Fields\Select;


class Installment extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Installment::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    public static $group = "Угода";

    public static function label()
    {
        return "Розстрочка";
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
            BelongsTo::make('Об\'єкт нерухомості', 'immovable', 'App\Nova\Immovable')->nullable(),
            Heading::make('<p class="text-success">Повна сума розстрочки в гривнях</p>')->asHtml(),
            Money::make('total_price', 'UAH')->storedInMinorUnits(),
            Text::make('Кількість місяців', 'total_month'),
            Heading::make('<p class="text-success">Повна сума розстрочки в гривнях</p>')->asHtml(),
            Select::make('Тип оплати', 'type')->options([
                'month' => 'Щомісячна',
                'quarter' => 'Поквартально',
            ])->displayUsingLabels(),
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
