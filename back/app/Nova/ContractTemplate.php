<?php

namespace App\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class ContractTemplate extends Resource
{
    use HasSortableRows;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\ContractTemplate::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
//    public static $title = 'id';

    public function title()
    {
        $title = '';

        if ($this->type)
            $title .= $this->type->title . ' ';

        if ($this->developer)
            $title .= $this->developer->title;


        return $title;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'developer_id', 'title'
    ];

    public static $searchRelations = [
        'developer' => ['title'],
    ];

    public static $group = "Шаблон документу";

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
            BelongsTo::make('Забудовник', 'developer', 'App\Nova\DevCompany')->sortable(),
            Text::make('Заголовок', 'title')->sortable(),
            BelongsTo::make('Тип шаблону', 'type', 'App\Nova\ContractType'),
//            Select::make('Тип договору', 'type')->options([
//                'main' => 'Основний договір',
//                'preliminary' => 'Попередній договір',
//            ])->displayUsingLabels(),
            Files::make('Шаблон', 'path')->customPropertiesFields([
                Markdown::make('Description'),
            ]),
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
