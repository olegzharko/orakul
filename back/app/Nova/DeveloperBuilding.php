<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;
use Techouse\IntlDateTime\IntlDateTime as DateTime;

class DeveloperBuilding extends Resource
{
    use HasSortableRows;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\DeveloperBuilding::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
//    public static $title = 'title';

    public function title()
    {
        return $this->city->city_type->short . " " . $this->city->title . ", " . $this->address_type->short . " " . $this->title . " " . $this->number;
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

    // public static $group = "Забудоник";

    public static function label()
    {
        return "Будинки"; // TODO: Change the autogenerated stub
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
            BelongsTo::make('Забудовник', 'dev_company', 'App\Nova\DevCompany')->nullable(),
            BelongsTo::make('Інвестиційний договір', 'investment_agreement', 'App\Nova\InvestmentAgreement')->nullable(),
            BelongsTo::make('Населений пункт', 'city', 'App\Nova\City')->nullable(),
            BelongsTo::make('Тип адреси', 'address_type', 'App\Nova\AddressType')->nullable(),
            Text::make('Назва вулиці', 'title'),
            Text::make('Номер будинку', 'number'),
            Heading::make('<p class="text-success">Після адреси, за маленької букви "у сладі комплесу..."</p>')->asHtml(),
            Markdown::make('Комплекс', 'complex'),
            DateTime::make('Введення в експлуатацію', 'exploitation_date'),
            DateTime::make('Підключення будинку до основних систем комунікацій', 'communal_date'),
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
