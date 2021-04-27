<?php

namespace App\Nova;

use App\Models\SpouseWord;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;
use Techouse\IntlDateTime\IntlDateTime as DateTime;

class ClientSpouseConsent extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ClientSpouseConsent::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
//    public static $title = 'id';

    public function title()
    {
        $title = '';

        if ($this->notary) {
            $title = $this->notary->surname_n . " " . $this->notary->short_name . " " . $this->notary->short_patronymic
        }
        return $title . " " . $this->reg_num;
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
        return "Заява-згода"; // TODO: Change the autogenerated stub
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
            BelongsTo::make('Клієнт', 'client', 'App\Nova\Client'),
            BelongsToMany::make('Угода', 'contracts', 'App\Nova\Contract')->nullable(),
            BelongsTo::make('Шаблон згоди', 'template', 'App\Nova\ConsentTemplate'),


            BelongsTo::make('Тип шлюбного свідоцтва', 'marriage_type', 'App\Nova\MarriageType')->nullable(),
            Text::make('Серія свідоцтва', 'mar_series'),
            Text::make('Номер свідоцтва', 'mar_series_num'),
            DateTime::make('Виданий', 'mar_date'),
            Text::make('Орган, що видав', 'mar_depart'),
            Text::make('Реєстраційний номер свідоцтва', 'mar_reg_num'),

            BelongsTo::make('Нотариус', 'notary', 'App\Nova\Notary'),
            DateTime::make('Нотаріус: дата підписання заяви-згоди', 'sign_date'),
            Text::make('Нотаріус: номер реєстрації у нотаріуса', 'reg_num'),
            BelongsTo::make('Пункт згоди у договорі', 'contract_spouse_word', 'App\Nova\SpouseWord'),
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
