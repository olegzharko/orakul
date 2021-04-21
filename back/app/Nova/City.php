<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Http\Requests\NovaRequest;
use Naif\Toggle\Toggle;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;

class City extends Resource
{
    use HasSortableRows;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\City::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
//    public static $title = 'title';

    public function title()
    {
        $title = '';

        if ($this->city_type)
            $title .= $this->city_type->short . " ";
        $title .= $this->title;

        return $title;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $group = "Локації";

    // public static $group = "Забудоник";

    public static function label()
    {
        return "Населені пункти"; // TODO: Change the autogenerated stub
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
            BelongsTo::make('Область', 'region', 'App\Nova\Region')->nullable(),
            BelongsTo::make('Район', 'district', 'App\Nova\District')->nullable(),
            BelongsTo::make('Тип населеного пункту', 'city_type', 'App\Nova\CityType')->nullable(),
            Text::make('Назва у називному відмінку', 'title')->creationRules('unique:cities,title')->updateRules('unique:cities,title,{{resourceId}}'),
            Toggle::make('Місто областного значення', 'region'),
            Toggle::make('Місто районного значення', 'district'),
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
