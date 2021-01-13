<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;
use Techouse\IntlDateTime\IntlDateTime as DateTime;

class Questionnaire extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Questionnaire::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
//    public static $title = 'id';
    public function title()
    {
        return $this->questionnaire_template->title
            . ", " . $this->notary->surname_n . " " . $this->notary->short_name . " " . $this->notary->short_patronymic
            . ", " . $this->developer->surname_n . " " . $this->developer->name_n . " " . $this->developer->patronymic_n
            . ", " . $this->client->surname_n . " " . $this->client->name_n . " " . $this->client->patronymic_n;;
    }

    public static $group = "Угода";

    public static function label()
    {
        return "Анкета";
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
            BelongsTo::make('Шаблон анктеи', 'questionnaire_template', 'App\Nova\QuestionnaireTemplate'),
            BelongsTo::make('Нотариус', 'notary', 'App\Nova\Notary'),
            BelongsTo::make('Забудовник', 'developer', 'App\Nova\Client'),
//            BelongsTo::make('Представник забудовник', 'developer_assistant', 'App\Nova\Developer'),
            BelongsTo::make('Клієнт', 'client', 'App\Nova\Client'),
//            BelongsTo::make('Представник клієнта', 'client_assistant', 'App\Nova\Client'),
            DateTime::make('Дата підписання згоди', 'date'),
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
