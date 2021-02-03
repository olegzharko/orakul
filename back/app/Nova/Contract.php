<?php

namespace App\Nova;

use App\Models\ClientSpouseConsent;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
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
//    public static $title = 'id';

    public function title()
    {

        if ($this->notary)
            $str_notary = $this->notary->surname_n . " " . $this->notary->short_name . " " . $this->notary->short_patronymic;
        else
            $str_notary = null;

        $str_client = null;
        if ($this->clients) {
            foreach ($this->clients as $client) {
                $str_client .= $client->surname_n . " " . $client->name_n . " " . $client->patronymic_n . " ";
            }
        }

        return $this->event_datetime->format('d.m.y') . " Нотаріус: " . $str_notary . ". Клієнт: " . $str_client;
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
            DateTime::make('Дата зустрічі', 'event_datetime')->timeFormat('HH:mm')->onlyOnForms(),
            BelongsTo::make('Місце складання договору', 'event_city', 'App\Nova\City')->onlyOnForms()->nullable(),
            BelongsTo::make('Нотаріус', 'notary', 'App\Nova\Notary')->nullable(),
            BelongsTo::make('Видавач', 'reader', 'App\Nova\Staff')->onlyOnForms()->nullable(),
            BelongsTo::make('Читач', 'delivery', 'App\Nova\Staff')->onlyOnForms()->nullable(),
            BelongsTo::make('Шаблон договору', 'contract_template', 'App\Nova\ContractTemplate')->nullable(),
            BelongsTo::make('Об\'єкт нерухомості', 'immovable', 'App\Nova\Immovable')->nullable(),
            BelongsTo::make('Забудовник', 'dev_company', 'App\Nova\DevCompany')->nullable(),
            BelongsTo::make('Підписант', 'dev_representative', 'App\Nova\Client')->onlyOnForms()->nullable(),
            BelongsTo::make('Менеджер', 'manager', 'App\Nova\Client')->onlyOnForms()->nullable(),
            DateTime::make('Дата підписання договору', 'sign_date'),
            Toggle::make('Оброблений', 'ready'),
            BelongsToMany::make('Клієнти', 'clients', 'App\Nova\Client'),

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

    public function get_clients_full_name()
    {
        $full_name = null;

        $clients = $this->clients();

        foreach ($clients as $client) {
            dd($client);
            $full_name .= $client->surname . " " . $client->name . " " . $client->patronymic . " ";
        }
        return $full_name;
    }
}
