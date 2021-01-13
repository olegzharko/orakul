<?php

namespace App\Nova;

use App\Models\ClientSpouseConsent;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;
use Techouse\IntlDateTime\IntlDateTime as DateTime;

class Contract extends Resource
{
    use HasSortableRows;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Contract::class;

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

    public static $group = "Угода";

    public static function label()
    {
        return "Договір";
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
            DateTime::make('Дата зустрічі', 'event_datetime')->timeFormat('HH:mm'),
            BelongsTo::make('Місце складання договору', 'event_city', 'App\Nova\City')->onlyOnForms()->nullable(),
            BelongsTo::make('Тип договору', 'template', 'App\Nova\Template')->onlyOnForms()->nullable(),
            BelongsTo::make('Об\'єкт нерухомості', 'immovable', 'App\Nova\Immovable')->onlyOnForms()->nullable(),
            BelongsTo::make('Забудовник', 'dev_company', 'App\Nova\DevCompany')->onlyOnForms()->nullable(),
            BelongsTo::make('Згода подружжя забудовника', 'developer_spouse_consent', 'App\Nova\ClientSpouseConsent')->onlyOnForms()->nullable(),
            BelongsTo::make('Пункт згоди: подружжя забудовника', 'developer_spouse_word', 'App\Nova\SpouseWord')->onlyOnForms()->nullable(),
            BelongsTo::make('Довіреність', 'proxy', 'App\Nova\Proxy')->onlyOnForms()->nullable(),
            BelongsTo::make('Підписант', 'assistant', 'App\Nova\Client')->onlyOnForms()->nullable(),
            BelongsTo::make('Менеджер', 'manager', 'App\Nova\Client')->onlyOnForms()->nullable(),
            BelongsTo::make('Клієнт', 'client', 'App\Nova\Client')->onlyOnForms()->nullable(),
            BelongsTo::make('Нотаріус', 'notary', 'App\Nova\Notary')->onlyOnForms()->nullable(),
            BelongsTo::make('Видавач', 'reader', 'App\Nova\Staff')->onlyOnForms()->nullable(),
            BelongsTo::make('Читач', 'delivery', 'App\Nova\Staff')->onlyOnForms()->nullable(),
            BelongsTo::make('Оцінка майна', 'pvprice', 'App\Nova\PVPrice')->onlyOnForms()->nullable(),
            BelongsTo::make('Анкета', 'questionnaire', 'App\Nova\Questionnaire')->onlyOnForms()->nullable(),
            BelongsTo::make('Запит до забудовника', 'developer_statement', 'App\Nova\DeveloperStatement')->onlyOnForms()->nullable(),
            BelongsTo::make('Згода подружжя клієнта', 'client_spouse_consent', 'App\Nova\ClientSpouseConsent')->onlyOnForms()->nullable(),
            BelongsTo::make('Пункт згоди: подружжя клієнта', 'client_spouse_word', 'App\Nova\SpouseWord')->onlyOnForms()->nullable(),
            DateTime::make('Дата підписання договору', 'sign_date'),
            Toggle::make('Оброблений', 'ready'),
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
