<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Techouse\IntlDateTime\IntlDateTime as DateTime;
use Vyuldashev\NovaMoneyField\Money;

class SecurityPayment extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\SecurityPayment::class;

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

    public static $group = "Сторонні угоди";

    public static function label()
    {
        return "Забезпечувальний платіж";
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
            BelongsTo::make('Нерухомість', 'immovable', 'App\Nova\Immovable')->creationRules('unique:security_payments,immovable_id')->updateRules('unique:security_payments,immovable_id,{{resourceId}}'),
            DateTime::make('Дата підписання', 'sign_date'),
            DateTime::make('Дата закінчення', 'final_date'),
            Text::make('Реєстраційний номер', 'reg_num'),

            Heading::make('<p class="text-success">Перша частина забезпечувального платежу у гривнях</p>')->asHtml(),
            Money::make('first_part_grn', 'UAH')->storedInMinorUnits(),

            Heading::make('<p class="text-success">Перша частина забезпечувального платіж у доларах</p>')->asHtml(),
            Money::make('first_part_dollar', 'UAH')->storedInMinorUnits(),

            Heading::make('<p class="text-success">Друга частина забезпечувального платежу у гривнях</p>')->asHtml(),
            Money::make('last_part_grn', 'UAH')->storedInMinorUnits(),

            Heading::make('<p class="text-success">Друга частина забезпечувального платіж у доларах</p>')->asHtml(),
            Money::make('last_part_dollar', 'UAH')->storedInMinorUnits(),
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
