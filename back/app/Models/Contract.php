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
        return $this->belongsTo(TemplateType::class, 'template_id');
    }

    public function immovable()
    {
        return $this->belongsTo(Immovable::class);
    }

    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }

    public function assistant()
    {
        return $this->belongsTo(Developer::class, 'assistant_id');
    }

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
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
}
