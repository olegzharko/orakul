<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;
use Techouse\IntlDateTime\IntlDateTime as DateTime;

class DeveloperStatement extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\DeveloperStatement::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
//    public static $title = 'id';

    public function title()
    {
        $title = '';

        if ($this->notary)
            $title .= $this->notary->surname_n . " " . $this->notary->short_name . " " . $this->notary->short_patronymic;
        if ($this->developer)
            $title .= $this->developer->surname_n . " " . $this->developer->name_n . " " . $this->developer->patronymic_n;
        if ($this->client)
            $title .= $this->client->surname_n . " " . $this->client->name_n . " " . $this->client->patronymic_n;

        return  $title;
    }
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $group = "Угода";

    public static function label()
    {
        return "Запит"; // TODO: Change the autogenerated stub
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
            BelongsTo::make('Угода', 'contract', 'App\Nova\Contract')->creationRules('unique:developer_statements,contract_id')->updateRules('unique:developer_statements,contract_id,{{resourceId}}')->nullable(),
            BelongsTo::make('Шаблон запиту', 'template', 'App\Nova\StatementTemplate'),
            BelongsTo::make('Нотариус', 'notary', 'App\Nova\Notary'),
            BelongsTo::make('Забудовник', 'developer', 'App\Nova\Client'),
            BelongsTo::make('Клієнт', 'client', 'App\Nova\Client'),
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
