<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Vyuldashev\NovaMoneyField\Money;

class NotaryService extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\NotaryService::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function title()
    {
        $result = null;

        $title = $this->title;

        $dev_group =  $this->dev_group ? $this->dev_group->title : null;

        return $title . " " . $dev_group;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];


    public static $group = "V2";

    public static function label()
    {
        return "Послуги";
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
            Text::make('Назва послуги', 'title'),
            BelongsTo::make('Тип договору', 'contract_type', 'App\Nova\ContractType')->required(),
            BelongsTo::make('Група забудовника', 'dev_group', 'App\Nova\DevGroup')->required(),
            Money::make('price', 'UAH')->storedInMinorUnits()->hideFromIndex(),
            Number::make('Кількість хвили на послугу', 'average_time'),
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
