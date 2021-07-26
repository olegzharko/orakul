<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Techouse\IntlDateTime\IntlDateTime as DateTime;

class InvestmentAgreement extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\InvestmentAgreement::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
//    public static $title = 'id';

    public function title()
    {
        $title = $this->dev_company->title
            . " №" . $this->number
            . " від " . $this->date->format('d.m.Y')
            . " ";

        return $title;
    }

    public static $group = "Забудовник";

    public static $searchRelations = [
        'dev_company' => ['title'],
        'investor' => ['surname_n', 'name_n', 'patronymic_n', 'tax_code'],
    ];

    public static function label()
    {
        return "Інвестиційний договір продавця";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'dev_company_id',
        'number',
        'date',
        'investor_id',
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
            Text::make('Номер договору', 'number'),
            DateTime::make('Дата підписання договору', 'date'),
            BelongsTo::make('Інвестори', 'investor', 'App\Nova\Client')->nullable(),
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
