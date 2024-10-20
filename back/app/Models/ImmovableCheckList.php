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
            'fund_evaluation',
    ];

    public function immovable()
    {
        return $this->belongsTo(Immovable::class, 'immovable_id');
    }

    public static function create_new($immovable_id)
    {
        $imm_check_list = new ImmovableCheckList();
        $imm_check_list->immovable_id = $immovable_id;
        $imm_check_list->right_establishing = 0;
        $imm_check_list->technical_passport = 0;
        $imm_check_list->pv_price = 0;
        $imm_check_list->fund_evaluation = 0;
        $imm_check_list->save();

        return $imm_check_list;
    }

    public static function get_check_list($immovable_id)
    {
        $result = [];
        $check_list = ImmovableCheckList::select(
            'right_establishing',
            'technical_passport',
            'pv_price',
            'fund_evaluation',
        )->where('immovable_id', $immovable_id)->first();

        if (!$check_list) {
            ImmovableCheckList::create_new($immovable_id);
            $check_list = ImmovableCheckList::select(
                'right_establishing',
                'technical_passport',
                'pv_price',
                'fund_evaluation',
            )->where('immovable_id', $immovable_id)->first();
        }

        $check_list = $check_list->toArray();

        $i = 0;
        foreach ($check_list as $key => $value) {
            $result[$i]['title'] = Text::where('alias', $key)->value('value');
            $result[$i]['key'] = $key;
            $result[$i]['value'] = $value ? true : false;
            $i++;
        }

        return $result;
    }

    public static function start_data_check_list()
    {
        $result = [];

        $check_list = [
            'right_establishing',
            'technical_passport',
            'pv_price',
            'fund_evaluation',
        ];

        $i = 0;
        foreach ($check_list as $key => $value) {
            $result[$i]['title'] = Text::where('alias', $value)->value('value');
            $result[$i]['key'] = $value;
            $result[$i]['value'] = false;
            $i++;
        }

        return $result;
    }
}
