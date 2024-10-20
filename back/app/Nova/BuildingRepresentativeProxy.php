<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

class BuildingRepresentativeProxy extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\BuildingRepresentativeProxy::class;

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
        'id', 'proxy_id'
    ];

    public static $group = "Забудовник";

    public static function label()
    {
        return "Будинок, представник, довіреність";
    }

    public static $searchRelations = [
        'building' => ['title', 'number'],
        'representative' => ['surname_n', 'name_n', 'patronymic_n', 'tax_code'],
        'proxy' => ['title', 'number', 'reg_num'],
//        'investor' => ['surname_n', 'name_n', 'patronymic_n', 'tax_code'],
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
            BelongsTo::make('Будівля', 'building', 'App\Nova\DeveloperBuilding')->sortable(),
            BelongsTo::make('Представник', 'representative', 'App\Nova\Client')->sortable(),
            BelongsTo::make('Довіреність', 'proxy', 'App\Nova\Proxy')->sortable(),
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
