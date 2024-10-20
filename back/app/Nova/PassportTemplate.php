<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Http\Requests\NovaRequest;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class PassportTemplate extends Resource
{
    use HasSortableRows;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\PassportTemplate::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $group = "Шаблон пункту";

    public static function label()
    {
        return "Глобально - паспорт"; // TODO: Change the autogenerated stub
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
            Text::make('Тип паспорту', 'title'),
            Markdown::make('Короткий опис', 'short_info'),
            Markdown::make('Паспортні данні, називний відмінок', 'description_n'),
            Markdown::make('Паспортні данні, орудний відмінок', 'description_o'),
            Heading::make("Називний: хто? що? - ластівк-а"),
            Heading::make("Родовий: кого?чого? - ластівк-и"),
            Heading::make("Давальний: кому?чому? - ластівц-і"),
            Heading::make("Знахідний: кого?що? -	ластівк-у"),
            Heading::make("Орудний: ким?чим? - ластівк-ою"),
            Heading::make("Місцевий: на кому?на чому? - на ластівц-і"),
            Heading::make("Кличний: * * - ластівк-о"),
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
