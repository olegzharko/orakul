<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class Notary extends Resource
{
    use HasSortableRows;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Notary::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
//    public static $title = 'surname';

    public function title()
    {
        return $this->surname_n . " " . $this->short_name . " " . $this->short_patronymic;
    }
    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $group = "Виконавча группа";

    public static function label()
    {
        return "Нотаріус"; // TODO: Change the autogenerated stub
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
            Heading::make('<p class="text-success">Називний відмінок та скорочення</p>')->asHtml(),
            Text::make('Прізвище', 'surname_n')->rules('required'),

            Text::make('Ім\'я', 'name_n')->rules('required'),
            Text::make('Ім\'я скорочено з крапкою', 'short_name')->rules('required'),

            Text::make('По батькові', 'patronymic_n')->rules('required'),
            Text::make('По батькові скорочено з крапкою', 'short_patronymic')->rules('required'),
            Text::make('Повна діяльнісь у називному відмінку', 'activity_n')->rules('required'),

            Heading::make('<p class="text-success">Родовий відмінок</p>')->asHtml(),
            Text::make('Прізвище ', 'surname_r')->rules('required'),
            Text::make('Ім\'я', 'name_r')->rules('required'),
            Text::make('По батькові', 'patronymic_r')->rules('required'),
            Text::make('Повна діяльнісь', 'activity_r')->rules('required'),

            Heading::make('<p class="text-success">Давальний відмінок</p>')->asHtml(),
            Text::make('Прізвище ', 'surname_d')->rules('required'),
            Text::make('Ім\'я', 'name_d')->rules('required'),
            Text::make('По батькові', 'patronymic_d')->rules('required'),
            Text::make('Повна діяльнісь у', 'activity_d')->rules('required'),

            Heading::make('<p class="text-success">Орудний відмінок</p>')->asHtml(),
            Text::make('Прізвище', 'surname_o')->rules('required'),
            Text::make('Ім\'я', 'name_o')->rules('required'),
            Text::make('По батькові', 'patronymic_o')->rules('required'),
            Text::make('Повна діяльність', 'activity_o')->rules('required'),





            Toggle::make('Ативувати', 'active')->color('#165153')
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
