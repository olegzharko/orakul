<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;
use Techouse\IntlDateTime\IntlDateTime as DateTime;

class DeliveryAcceptanceAct extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\DeliveryAcceptanceAct::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
//    public static $title = 'id';
    public function title()
    {
        $title = '';
        if ($this->template)
            $title = $this->template->title;

        return $title;
    }

    public static $group = "Угода";

    public static function label()
    {
        return "Акт пиймання передачі";
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
            BelongsTo::make('Угода', 'contract', 'App\Nova\Contract')->creationRules('unique:delivery_acceptance_acts,contract_id')->updateRules('unique:delivery_acceptance_acts,contract_id,{{resourceId}}')->nullable(),
            BelongsTo::make('Шаблон акту', 'template', 'App\Nova\DeliveryAcceptanceActTemplate'),
            BelongsTo::make('Нотариус', 'notary', 'App\Nova\Notary'),
            DateTime::make('Дата підписання згоди', 'sign_date'),
            Toggle::make('Активн згода', 'active'),
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
