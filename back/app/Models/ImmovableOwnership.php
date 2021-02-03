<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class ImmovableOwnership extends Model implements Sortable
{
    use HasFactory, SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    protected $casts = [
        'gov_reg_date' => 'datetime',
        'discharge_date' => 'datetime'
    ];

    public function immovable()
    {
        return $this->belongsTo(Immovable::class);
    }

    public function discharge_resp()
    {
        return $this->belongsTo(Notary::class, 'discharge_responsible', 'id');
    }

    public static function get_immovable_ownership($id = null)
    {
            if ($immovable_ownership = ImmovableOwnership::select(
               'id',
               'immovable_id',
               'gov_reg_number',
               'gov_reg_date',
               'discharge_number',
               'discharge_date',
//               'discharge_responsible',
               'sort_order',
               'active',
            )->where('immovable_id', $id)->first()) {
                $immovable_ownership->gov_reg_date_format = $immovable_ownership->gov_reg_date->format('d.m.Y');
                $immovable_ownership->discharge_date_format = $immovable_ownership->discharge_date->format('d.m.Y');
                return $immovable_ownership;
        } else {
            return null;
        }
    }
}
