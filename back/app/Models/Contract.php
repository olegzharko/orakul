<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Contract extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    protected $fillable = [
        'reader_id',
        'accompanying_id',
        'type_id',
        'printer_id',
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    protected $casts = [
        'event_datetime' => 'datetime',
        'sign_date' => 'datetime',
        'date' => 'datetime',
    ];

//    public function contract_type()
//    {
//        return $this->belongsTo(ContractType::class, 'type_id');
//    }

    public function template()
    {
        return $this->belongsTo(ContractTemplate::class, 'template_id');
    }

    public function immovable()
    {
        return $this->belongsTo(Immovable::class, 'immovable_id');
    }

    public function reader()
    {
        return $this->belongsTo(User::class, 'reader_id');
    }

    public function accompanying()
    {
        return $this->belongsTo(User::class, 'accompanying_id');
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    public function developer_statement()
    {
        return $this->hasOne(DeveloperStatement::class, 'contract_id');
    }

    public function questionnaire()
    {
        return $this->hasOne(Questionnaire::class, 'contract_id');
    }

    public function client_spouse_consent()
    {
        return $this->belongsToMany(ClientSpouseConsent::class);
    }

    public function bank_account_payment()
    {
        return $this->hasOne(BankAccountPayment::class, 'contract_id');
    }

    public function bank_taxes_payment()
    {
        return $this->hasOne(BankTaxesPayment::class, 'contract_id');
    }

    public function final_sign_date()
    {
        return $this->hasOne(FinalSignDate::class, 'contract_id');
    }

    public function event_city()
    {
        return $this->belongsTo(City::class, 'event_city_id');
    }

    public function notary()
    {
        return $this->belongsTo(Notary::class, 'notary_id');
    }

    public function manager()
    {
        return $this->belongsTo(Client::class, 'manager_id');
    }

    public function dev_company()
    {
        return $this->belongsTo(DevCompany::class, 'dev_company_id');
    }

    public function dev_representative()
    {
        return $this->belongsTo(Client::class, 'dev_representative_id');
    }

    public function has_contracts()
    {
        return $this->hasMany(CardContract::class, 'card_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function type()
    {
        return $this->belongsTo(ContractType::class, 'type_id');
    }

    public static function get_contract_by_immovable($immovable_id)
    {
        return Contract::where('immovable_id', $immovable_id)->first();
    }
}
