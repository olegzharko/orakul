<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Naif\Toggle\Toggle;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function title()
    {
        return "$this->email - $this->surname $this->name $this->patronymic";
    }

    public static $group = "Nova";

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email',
    ];

    public static function label()
    {
        return "Користувачі";
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
            ID::make()->sortable(),

//            Gravatar::make()->maxWidth(50),
            Images::make('Фото', 'path'),

            Text::make('Surname')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Patronymic')
                ->sortable()
                ->rules('required', 'max:255'),

            BelongsTo::make('Робоче місце', 'work_space', 'App\Nova\WorkSpace')->nullable(),
            Text::make('Email')
                ->sortable()
//                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            Toggle::make('Рецепція', 'reception'),
            Toggle::make('Менеджер', 'manager'),
            Toggle::make('Генератор', 'generator'),
            Toggle::make('Реєстратор', 'registrar'),
            Toggle::make('Читач', 'reader'),
            Toggle::make('Видавач', 'accompanying'),
            Toggle::make('Асистент', 'assistant'),
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
