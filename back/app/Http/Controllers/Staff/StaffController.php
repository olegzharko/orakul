<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\BaseController;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Models\User;
use App\Models\Card;

class StaffController extends BaseController
{
    public $convert;
    public $tools;

    public function __construct()
    {
        $this->convert = new ConvertController();
        $this->tools = new ToolsController();
    }

    public function get_staff_info()
    {
        $result = [];

        $staff = User::whereNotNull('type')->get();

        $group = [];
        $space = [];
        foreach ($staff as $key => $user) {
            $info = [];
            if (!$user->work_space)
                continue ;
            $work_space = $user->work_space;
            $space[] = $work_space;
            $info['color'] = 'FF0000';
            $info['full_name'] = $this->convert->get_staff_full_name($user);
            $info['generate'] = $this->get_staff_generate_info($user);
            $info['read'] = $this->get_staff_read_info($user);
            $info['accompanying'] = $this->get_staff_generate_info($user);
            $group[$work_space->alias][] = $info;
        }

        foreach ($space as $key => $value) {
            $result[$key]['title'] = $value->title;
            $result[$key]['staff'] = $group[$value->alias];
        }

        return $this->sendResponse($result, 'Дані для колонок архіву');
    }

    public function get_staff_generate_info($user)
    {
        $result = [];

        $date = new \DateTime('today');
        $ready = Card::where('date_time', '>', $date)->where(['generator_step' => true, 'staff_generator_id' => $user->id, 'ready' => true])->count();
        $total = Card::where('date_time', '>', $date)->where(['generator_step' => true, 'staff_generator_id' => $user->id])->count();

        $result['ready'] = $ready;
        $result['total'] = $total;
        return $result;
    }

    public function get_staff_read_info($user)
    {
        $result = [];

        $date = new \DateTime('today');
        $ready = Contract::where('sign_date', '>', $date)->where(['reader_id' => $user->id, 'ready' => true])->count();
        $total = Contract::where('sign_date', '>', $date)->where(['reader_id' => $user->id])->count();

        $result['ready'] = $ready;
        $result['total'] = $total;
        return $result;
    }

    public function get_staff_accompanying_info($user)
    {
        $result = [];

        $date = new \DateTime('today');
        $ready = Contract::where('sign_date', '>', $date)->where(['accompanying_id' => $user->id, 'ready' => true])->count();
        $total = Contract::where('sign_date', '>', $date)->where(['accompanying_id' => $user->id])->count();

        $result['ready'] = $ready;
        $result['total'] = $total;
        return $result;
    }
}
