<?php

namespace App\Http\Controllers\Rakul;

use App\Http\Controllers\Controller;
use App\Models\DevCompany;
use Illuminate\Http\Request;
use App\Models\Client;

class CardController extends Controller
{
    /*
     * GET
     * */
    public function index()
    {
        dd('index');
    }

    /*
     * GET with param
     * */
    public function show($id)
    {
        dd('show');

    }

    /*
     * POST
     * */
    public function store(Request $r)
    {
        dd($r->toArray());
        $date = $r['date'];
        $developer = DevCompany::find($r['developer_id']);
        $assistant = Client::find($r['dev_assistant_id']);
        $manager = Client::find($r['dev_manager_id']);
//        $immovable = $r['immovable'];

        $test_imm = [];

        $test_imm['immovable'] = [];

        $test_imm['immovable'][0] = [
            'contract_type_id' => 1,
            'building_id' => 1,
            'imm_type_id' => 1,
            'imm_num' => 7,
        ];

        $test_imm['immovable'][1] = [
            'contract_type_id' => 1,
            'building_id' => 1,
            'imm_type_id' => 2,
            'imm_num' => 124,
        ];

        $test_cl = [];

        $test_cl['client'] = [];

        $test_cl['client'][0] = [
            'phone' => '+380647259244',
            'full_name' => 'Жарко Олег',
        ];

        $test_cl['client'][1] = [
            'phone' => '+380647277777',
            'full_name' => 'Петров А.А.',
        ];
    }

    /*
     * PUT with param
     * */
    public function update(Request $request, $id)
    {
        dd('update');

    }

    /*
     * DELETE
     * */
    public function destroy($id)
    {
        dd('destroy');

    }

}
