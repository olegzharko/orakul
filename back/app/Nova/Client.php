<?php

namespace App\Nova;

use Bissolli\NovaPhoneField\PhoneNumber;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
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

    public static $group = "Угода";

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
            new Panel("Контактна інформація", $this->userMainInfo()),
            new Panel("Відноситься до:", $this->relationships()),
            new Panel("Код та Паспортні данні", $this->passportInfo()),
            new Panel("Адреса", $this->addressInfo()),
            BelongsToMany::make('Угода', 'contracts', 'App\Nova\Contract')->nullable(),

        ];
    }

    public function userType()
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            BelongsTo::make('Тип клієнта', 'client_type', 'App\Nova\ClientType')->nullable(),
        ];
    }

    public function fullNameType()
    {
        return [
            Heading::make('<p class="text-success">Називний відмінок</p>')->asHtml(),
            Text::make('Прізвище', 'surname_n')->rules('required'),
            Text::make('Ім\'я', 'name_n')->rules('required'),
            Text::make('По батькові', 'patronymic_n'),

            Heading::make('<p class="text-success">Родовий відмінок</p>')->asHtml(),
            Text::make('Прізвище', 'surname_r')->rules('required')->hideFromIndex(),
            Text::make('Ім\'я', 'name_r')->rules('required')->hideFromIndex(),
            Text::make('По батькові', 'patronymic_r')->hideFromIndex(),

//            Heading::make('<p class="text-success">Давальний відмінок</p>')->asHtml(),
//            Text::make('Прізвище', 'surname_d')->rules('required')->hideFromIndex(),
//            Text::make('Ім\'я', 'name_d')->rules('required')->hideFromIndex(),
//            Text::make('По батькові', 'patronymic_d')->hideFromIndex(),

            Heading::make('<p class="text-success">Орудний відмінок</p>')->asHtml(),
            Text::make('Прізвище', 'surname_o')->rules('required')->hideFromIndex(),
            Text::make('Ім\'я', 'name_o')->rules('required')->hideFromIndex(),
            Text::make('По батькові', 'patronymic_o')->hideFromIndex(),
            Heading::make("Називний: хто? що? - ластівк-а"),
            Heading::make("Родовий: кого?чого? - ластівк-и"),
            Heading::make("Давальний: кому?чому? - ластівц-і"),
            Heading::make("Знахідний: кого?що? -	ластівк-у"),
            Heading::make("Орудний: ким?чим? - ластівк-ою"),
            Heading::make("Місцевий: на кому?на чому? - на ластівц-і"),
            Heading::make("Кличний: * * - ластівк-о"),
        ];
    }

    public function userMainInfo()
    {
        return [
            Heading::make('<p class="text-success">Загальні данні</p>')->asHtml(),
            PhoneNumber::make('Основний телефон', 'phone'),
            PhoneNumber::make('Додатковий номер', 'mobile'),
            Text::make('E-main', 'email'),

        ];
    }

    public function relationships()
    {
        return [
            BelongsTo::make('Громадянсво', 'citizenship', 'App\Nova\Citizenship')->nullable(),
            BelongsTo::make('Одружений(а) з', 'spouse', 'App\Nova\Client')->creationRules('unique:clients,spouse_id')->updateRules('unique:clients,spouse_id,{{resourceId}}')->nullable(),
            BelongsTo::make('Відноситься до компанії забудовника', 'member', 'App\Nova\DevCompany')->nullable(),
        ];
    }

    public function passportInfo()
    {
        return [
            Heading::make('<p class="text-success">Дата народження та стать</p>')->asHtml(),
            DateTime::make('Дата народження', 'birthday'),
            Select::make('Стать', 'gender')->options([
                'male' => 'Чоловіча',
                'female' => 'Жіноча',
            ])->displayUsingLabels(),
            Heading::make('<p class="text-success">Код</p>')->asHtml(),
            Text::make('ІНН', 'tax_code')->creationRules('unique:clients,tax_code')->updateRules('unique:clients,tax_code,{{resourceId}}'),
            Heading::make('<p class="text-success">Паспорт</p>')->asHtml(),
            BelongsTo::make('Тип паспорту', 'passport_type', 'App\Nova\PassportTemplate')->nullable(),
            Text::make('Серія/Номер паспорта', 'passport_code'),
            DateTime::make('Дата видачі', 'passport_date'),
            Text::make('Орган що видав паспорт', 'passport_department'),
            Text::make('Запису в ЄДДР (для ID карток)', 'passport_demographic_code'),
        ];
    }

    public function addressInfo()
    {
        return [
            Heading::make('<p class="text-success">Повна адреса</p>')->asHtml(),
            BelongsTo::make('Населений пункту', 'city', 'App\Nova\City')->nullable(),
            BelongsTo::make('Тип вулиці', 'address_type', 'App\Nova\AddressType')->nullable(),
            Text::make('Назва вулиці', 'address'),
            BelongsTo::make('Тип будинку', 'building_type', 'App\Nova\BuildingType')->nullable(),
            Text::make('Номер будинку', 'building'),
            BelongsTo::make('Тип житлового приміщення', 'apartment_type', 'App\Nova\ApartmentType')->nullable(),
            Text::make('Номер житлового приміщення', 'apartment_num'),
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
