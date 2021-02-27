<?php

namespace App\Models;

use App\Models\ImmFence;
use App\Models\NumericConvert;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Immovable extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function immovable_type()
    {
        return $this->belongsTo(ImmovableType::class);
    }

    public function developer_building()
    {
        return $this->belongsTo(DeveloperBuilding::class);
    }

    public function roominess()
    {
        return $this->belongsTo(RoominessType::class, 'roominess_id');
    }

    public function proxy()
    {
        return $this->belongsTo(Proxy::class, 'proxy_id');
    }

    public function security_payment()
    {
        return $this->hasOne(SecurityPayment::class, 'immovable_id');
    }

    public function exchange_rate()
    {
        return $this->hasOne(ExchangeRate::class, 'immovable_id');
    }

    public function pvprice()
    {
        return $this->hasOne(PropertyValuationPrice::class, 'immovable_id');
    }
}
