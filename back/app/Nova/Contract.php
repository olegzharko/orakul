<?php

namespace App\Nova;

use App\Models\ClientSpouseConsent;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;
use Laravel\Nova\Fields\Heading;
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
        if ($this->card->notary)
            $str_notary = $this->card->notary->surname_n . " " . $this->card->notary->short_name . " " . $this->card->notary->short_patronymic;
        else
            $str_notary = null;

        $str_client = null;
        if ($this->clients) {
            foreach ($this->clients as $client) {
                $str_client .= $client->surname_n . " " . $client->name_n . " " . $client->patronymic_n . " ";
            }
        }
        $date = $this->event_datetime ? $this->event_datetime->format('d.m.y') : null;
        return $date . " Нотаріус: " . $str_notary . " - Клієнт: " . $str_client;
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
            BelongsTo::make('Тип договору', 'type', 'App\Nova\ContractType')->onlyOnForms()->nullable(),
            BelongsTo::make('Видавач', 'reader', 'App\Nova\User')->onlyOnForms()->nullable(),
            BelongsTo::make('Читач', 'accompanying', 'App\Nova\User')->onlyOnForms()->nullable(),
            BelongsTo::make('Шаблон договору', 'template', 'App\Nova\ContractTemplate')->nullable(),
            BelongsTo::make('Об\'єкт нерухомості', 'immovable', 'App\Nova\Immovable')->nullable(),
            Toggle::make('Банк', 'bank'),
            Toggle::make('Довіреність', 'proxy'),
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
            $full_name .= $client->surname . " " . $client->name . " " . $client->patronymic . " ";
        }
        return $full_name;
    }
}
