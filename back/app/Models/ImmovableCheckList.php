<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImmovableCheckList extends Model
{
    use HasFactory;

    protected $fillable = [
            'immovable_id',
            'right_establishing',
            'technical_passport',
            'pv_price',
            'evaluation_on_the_fund',
    ];

    public function immovable()
    {
        return $this->belongsTo(Immovable::class, 'immovable_id');
    }

    public static function get_check_list($immovable_id)
    {
        $result = [];
        $check_list = ImmovableCheckList::select(
            'right_establishing',
            'technical_passport',
            'pv_price',
            'evaluation_on_the_fund',
        )->where('immovable_id', $immovable_id)->first()->toArray();

        $i = 0;
        foreach ($check_list as $key => $value) {
            $result[$i]['title'] = Text::where('alias', $key)->value('value');
            $result[$i]['key'] = $key;
            $result[$i]['value'] = $value ? true : false;
            $i++;
        }

        return $result;
    }
}
