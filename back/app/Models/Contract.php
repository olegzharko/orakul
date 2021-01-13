<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Contract extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    protected $casts = [
        'event_datetime' => 'datetime',
        'sign_date' => 'datetime',
    ];

    public function template()
    {
//        return $this->belongsTo(TemplateType::class, 'template_id');
        return $this->belongsTo(Template::class, 'template_id');
    }

    public function immovable()
    {
        return $this->belongsTo(Immovable::class);
    }

    public function event_city()
    {
        return $this->belongsTo(City::class);
    }

    public function dev_company()
    {
        return $this->belongsTo(DevCompany::class, 'developer_id');
    }

    public function developer_spouse_consent()
    {
        return $this->belongsTo(ClientSpouseConsent::class, 'dev_sp_consents_id');
    }

    public function assistant()
    {
        return $this->belongsTo(Client::class, 'assistant_id');
    }

    public function manager()
    {
        return $this->belongsTo(Client::class, 'manager_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function notary()
    {
        return $this->belongsTo(Notary::class, 'notary_id');
    }

    public function reader()
    {
        return $this->belongsTo(Staff::class, 'reader_id');
    }

    public function delivery()
    {
        return $this->belongsTo(Staff::class, 'delivery_id');
    }

    public function pvprice()
    {
        return $this->belongsTo(PVPrice::class, 'pvprice_id');
    }

    public function client_spouse_consent()
    {
        return $this->belongsTo(ClientSpouseConsent::class, 'cl_sp_consents_id');
    }

    public function developer_statement()
    {
        return $this->belongsTo(DeveloperStatement::class, 'developer_statement_id');
    }

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id');
    }

    public function client_spouse_word()
    {
        return $this->belongsTo(SpouseWord::class, 'cl_sp_word_id');
    }

    public function developer_spouse_word()
    {
        return $this->belongsTo(SpouseWord::class, 'dev_sp_word_id');
    }

    public function proxy()
    {
        return $this->belongsTo(Proxy::class, 'proxy_id');
    }
}
