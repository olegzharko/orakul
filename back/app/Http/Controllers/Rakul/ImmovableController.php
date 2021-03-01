<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\DevCompany;
use App\Models\DeveloperBuilding;
use App\Models\Immovable;
use App\Models\ImmovableType;
use Illuminate\Http\Request;

class ImmovableController extends BaseController
{
    public function add_immovables($r)
    {
        $imm_id = [];
        $immovables = $r['immovables'];

        foreach ($immovables as $value) {
            if ($this->developer_building_exist($value, $r) && $this->immovable_type_exist($value)) {
                $imm_id[] =  $this->create($value, $r);
            }
        }

        return $imm_id;
    }

    public function create($value, $r)
    {
        $imm = $this->imm_exist($value);

        if (!$imm) {
            $imm = new Immovable();
            $imm->developer_building_id = $value->building_id;
            $imm->immovable_type_id = $value->imm_type_id;
            $imm->immovable_number = $value->imm_num;
            $imm->save();
        }

        return $imm->id;
    }

    public function imm_exist($value)
    {
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

    public function developer_building_exist($value, $r)
    {
        $developer = DevCompany::find($r['dev_company_id']);
        $developer_building = DeveloperBuilding::where('id', $value->building_id)->first();

        if (!$developer_building || $developer_building->dev_company->id != $developer->id) { // dev_company
            echo "Будинок відсутній або належить іншому забудовнику<br>";
            return false;
        } else {
            return true;
        }
    }

    public function immovable_type_exist($value)
    {
        $imm_type = ImmovableType::find($value->imm_type_id);

        if (!$imm_type) {
            echo "Невідомий тип нерухомості<br>";
            return false;
        } else {
            return true;
        }
    }
}
