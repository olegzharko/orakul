<?php

namespace App\Models;

use App\Models\ImmFence;
use App\Models\NumericConvert;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Immovable extends Model implements Sortable
{
    use HasFactory, SortableTrait, SoftDeletes;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'immovable_type_id',
        'developer_building_id',
        'immovable_number',
        'registration_number',
        'grn',
        'dollar',
        'reserve_grn',
        'reserve_dollar',
        'm2_grn',
        'm2_dollar',
        'roominess_id',
        'total_space',
        'living_space',
        'section',
        'floor',
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function immovable_type()
    {
        return $this->belongsTo(ImmovableType::class, 'immovable_type_id');
    }

    public function developer_building()
    {
        return $this->belongsTo(DeveloperBuilding::class);
    }

    public function roominess()
    {
        return $this->belongsTo(RoominessType::class, 'roominess_id');
    }

    public function security_payment()
    {
        return $this->hasOne(SecurityPayment::class, 'immovable_id');
    }

    public function exchange_rate()
    {
        return $this->hasOne(ExchangeRate::class, 'immovable_id');
    }

    public function contract()
    {
        return $this->hasOne(Contract::class, 'immovable_id');
    }

    public function pvprice()
    {
        return $this->hasOne(PropertyValuationPrice::class, 'immovable_id');
    }

    public static function get_all_by_id($immovables_id)
    {
        return Immovable::whereIn('id', $immovables_id)->get();
    }

    public function installment()
    {
        return $this->hasOne(Installment::class, 'immovable_id');
    }
}
