<?php

namespace App\Nova;

use App\Models\RoominessType;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;
use SimpleSquid\Nova\Fields\AdvancedNumber\AdvancedNumber;
use Vyuldashev\NovaMoneyField\Money;
use Techouse\IntlDateTime\IntlDateTime as DateTime;

class Immovable extends Resource
{
    use HasSortableRows;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Immovable::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
     public static $title = 'id';

    public function title()
    {
        return $this->immovable_type->title_n
            . ": " . $this->developer_building->address_type->short
            . " " . $this->developer_building->title
            . " " . $this->developer_building->number
            . ", " . $this->immovable_type->short
            . " " . $this->immovable_number
            . ". Реєстраційний номер:" . $this->registration_number
            . " ";

    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $group = "Забудовник";

    public static function label()
    {
        return "Нерухомість"; // TODO: Change the autogenerated stub
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

            BelongsTo::make('Адреса', 'developer_building', 'App\Nova\DeveloperBuilding')->rules('required'),
//            BelongsTo::make('Довіреність', 'proxy', 'App\Nova\Proxy')->onlyOnForms()->nullable(),
//            Number::make('Номер будинку', 'building_number')->rules('required'),
            BelongsTo::make('Тип нерухомості', 'immovable_type', 'App\Nova\ImmovableType')->rules('required'),
            Number::make('Номер нерухомості', 'immovable_number')->rules('required'),
            Text::make('Реєстраційний номер', 'registration_number'),

            Heading::make('<p class="text-success">Повна вартість в гривнях</p>')->asHtml(),
            Money::make('grn', 'UAH')->storedInMinorUnits()->hideFromIndex(),

            Heading::make('<p class="text-success">Повна вартість в доларах</p>')->asHtml(),
            Money::make('dollar', 'USD')->storedInMinorUnits()->hideFromIndex(),

            Heading::make('<p class="text-success">Сума внеску згідно попереднього договору в гривнях</p>')->asHtml(),
            Money::make('reserve_grn', 'UAH')->storedInMinorUnits()->hideFromIndex(),

            Heading::make('<p class="text-success">Сума внеску згідно попереднього договору в доларах</p>')->asHtml(),
            Money::make('reserve_dollar', 'USD')->storedInMinorUnits()->hideFromIndex(),

            Heading::make('<p class="text-success">Вартість 1 кв. м. гривнях</p>')->asHtml(),
            Money::make('m2_grn', 'UAH')->storedInMinorUnits()->hideFromIndex(),

            Heading::make('<p class="text-success">Вартість 1 кв. м. доларах</p>')->asHtml(),
            Money::make('m2_dollar', 'USD')->storedInMinorUnits()->hideFromIndex(),

            Heading::make('<p class="text-success">Загальні данні</p>')->asHtml(),
            BelongsTo::make('Кількість кімнат', 'roominess', 'App\Nova\RoominessType')->nullable(),
            AdvancedNumber::make('Загальна площа', 'total_space')->thousandsSeparator(',')->decimals(1)->hideFromIndex(),
            AdvancedNumber::make('Житлова площа', 'living_space')->thousandsSeparator(',')->decimals(1)->hideFromIndex(),
            AdvancedNumber::make('Номер поверху цифрою', 'floor')->hideFromIndex(),
//            Text::make('Номер поверху словами', 'floor_str'),
            AdvancedNumber::make('Номер секції цифрою', 'section')->hideFromIndex(),

            HasOne::make('Забезпечувальний платіж', 'security_payment', 'App\Nova\SecurityPayment'),

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
