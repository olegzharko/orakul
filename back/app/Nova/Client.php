<?php

namespace App\Nova;

use Bissolli\NovaPhoneField\PhoneNumber;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;
use Techouse\IntlDateTime\IntlDateTime as DateTime;

class Client extends Resource
{
    use HasSortableRows;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Client::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public function title()
    {
        return $this->surname_n . " " . $this->name_n . " " . $this->patronymic_n  . " " . $this->tax_code;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static $group = "Покупець";

    public static function label()
    {
        return "Клієнт";
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

            new Panel("Тип клієнта", $this->userType()),
            new Panel("ПІБ", $this->fullNameType()),
            new Panel("Основна інформація", $this->userMainInfo()),
            new Panel("Код та Паспорт", $this->passportInfo()),
            new Panel("Адреса", $this->addressInfo()),
        ];
    }

    public function userType()
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            BelongsTo::make('Тип клієнта', 'client_type', 'App\Nova\ClientType'),
        ];
    }

    public function fullNameType()
    {
        return [
            Heading::make('<p class="text-success">Називний відмінок</p>')->asHtml(),
            Text::make('Прізвище', 'surname_n')->rules('required'),
            Text::make('Ім\'я', 'name_n')->rules('required'),
            Text::make('По батькові', 'patronymic_n')->rules('required'),
            Heading::make('<p class="text-success">Орудний відмінок</p>')->asHtml(),
            Text::make('Прізвище', 'surname_o')->rules('required')->hideFromIndex(),
            Text::make('Ім\'я', 'name_o')->rules('required')->hideFromIndex(),
            Text::make('По батькові', 'patronymic_o')->rules('required')->hideFromIndex(),
        ];
    }

    public function userMainInfo()
    {
        return [
            Heading::make('<p class="text-success">Загальні данні</p>')->asHtml(),
            DateTime::make('Дата народження', 'birthday'),
            Select::make('Стать', 'gender')->options([
                'gender_male' => 'Чоловіча',
                'gender_female' => 'Жіноча',
            ])->displayUsingLabels(),
            PhoneNumber::make('Основний телефон', 'phone'),
            PhoneNumber::make('Додатковий номер', 'mobile'),
            Text::make('E-main', 'email'),
            BelongsTo::make('Одружений з', 'married_with', 'App\Nova\Client')->nullable(),
            BelongsTo::make('Відноситься до забудовника', 'member', 'App\Nova\DevCompany')->nullable(),
        ];
    }

    public function passportInfo()
    {
        return [
            Heading::make('<p class="text-success">Код та Паспорт</p>')->asHtml(),
            Text::make('ІНН', 'tax_code')->creationRules('unique:clients,tax_code')->updateRules('unique:clients,tax_code,{{resourceId}}'),
            BelongsTo::make('Тип паспорту', 'passport_type', 'App\Nova\PassportType'),
            Text::make('Номер паспорта', 'passport_code'),
            DateTime::make('Дата видачі', 'passport_date'),
            Text::make('Орган що видав паспорт', 'passport_department'),
            Text::make('Запису в ЄДДР', 'passport_demographic_code'),
        ];
    }

    public function addressInfo()
    {
        return [
            Heading::make('<p class="text-success">Повна адреса</p>')->asHtml(),
            BelongsTo::make('Область', 'region', 'App\Nova\Region'),
            BelongsTo::make('Тип населеного пункту', 'city_type', 'App\Nova\CityType'),
            BelongsTo::make('Населений пункту', 'city', 'App\Nova\City'),
            //Text::make('Населений пункт', 'city'),
            BelongsTo::make('Тип вулиці', 'address_type', 'App\Nova\AddressType'),
            Text::make('Назва вулиці', 'address'),
            BelongsTo::make('Тип будинку', 'building_type', 'App\Nova\BuildingType'),
            Text::make('Номер будинку', 'building'),
            Text::make('Номер квартири', 'apartment'),
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

//    public static function relatableClients(NovaRequest $request, $query)
//    {
//        $client = $request->findResourceOrFail(); // Retrieve the location instance
//        return $query->whereNotIn('id', [$client->id]);
//    }
}
