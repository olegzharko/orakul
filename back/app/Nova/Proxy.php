<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Techouse\IntlDateTime\IntlDateTime as DateTime;
use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Laravel\Nova\Fields\Markdown;

class Proxy extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Proxy::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */

    public static $group = "Забудовник";

    public function title()
    {
//        return $this->dev_company->title . " " . $this->title . " " . $this->number;
        return $this->title;
    }

    public static function label()
    {
        return "Довіреності забудовників для представників";
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title', 'number', 'reg_num'
    ];

    public static $searchRelations = [
        'dev_company' => ['title'],
        'notary' => ['surname_n', 'name_n', 'short_name', 'patronymic_n', 'short_patronymic'],
//        'building' => ['title', 'number'],
//        'representative' => ['surname_n', 'name_n', 'patronymic_n', 'tax_code'],
//        'proxy' => ['title', 'number', 'reg_num'],
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
            Text::make('Заголовок', 'title'),
            Text::make('Номер доручення', 'number'),
            DateTime::make('Доручення від', 'date'),
//            HasMany::make('Люди', 'member', 'App\Nova\Client'),
//            HasMany::make('Будинки', 'building', 'App\Nova\DeveloperBuilding'),
//            BelongsTo::make('Представник', 'dev_representative', 'App\Nova\Client')->nullable(),
            BelongsTo::make('Нотаріус', 'notary', 'App\Nova\Notary'),
            Text::make('Номер реєстраціх у нотаріуса', 'reg_num'),
            DateTime::make('Дата реєстрації у нотаріуса', 'reg_date')->sortable(),
            DateTime::make('Дійсно до', 'final_date'),
            Files::make('Скан-сет довіреності', 'pdf')->customPropertiesFields([
                Markdown::make('Description'),
            ]),
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
