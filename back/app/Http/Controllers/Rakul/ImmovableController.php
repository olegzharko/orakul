<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\DeveloperBuilding;
use App\Models\Immovable;
use App\Models\ImmovableType;
use Illuminate\Http\Request;

class ImmovableController extends BaseController
{
    public function add_immovables($immovables, $developer)
    {
        $imm_id = [];
        foreach ($immovables as $value) {
            $imm_id[] =  $this->create($value, $developer);
        }

        return $imm_id;
    }

    public function create($value, $developer)
    {
        $imm_exist = $this->imm_exist($value, $developer);

        if (!$imm_exist) {
            $imm = new Immovable();
            $imm->developer_building_id = $value->building_id;
            $imm->immovable_type_id = $value->imm_type_id;
            $imm->immovable_number = $value->imm_num;
            $imm->save();
            return $imm->id;
        }

        return $imm_exist->id;
    }

    public function imm_exist($value, $developer)
    {
        $developer_building = DeveloperBuilding::where('id', $value->building_id)->first();
        if (!$developer_building || $developer_building->dev_company->id != $developer->id) { // dev_company
            return false;
        }

        $imm_type = ImmovableType::find($value->imm_type_id);
        if (!$imm_type) {
            return false;
        }

        $imm = Immovable::where([
            'developer_building_id' => $value->building_id,
            'immovable_type_id' => $value->imm_type_id,
            'immovable_number' => $value->imm_num,
        ])->first();

        if ($imm)
            return $imm;
        else {
            return false;
        }
    }
}
