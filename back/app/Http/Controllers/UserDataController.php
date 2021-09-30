<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Factory\ConvertController;
use App\Http\Controllers\Helper\ToolsController;
use App\Http\Controllers\PassportAuthController;

class UserDataController extends BaseController
{
    public $convert;
    public $tools;
    public $passport;

    public function __construct()
    {
        $this->convert = new ConvertController();
        $this->tools = new ToolsController();
        $this->passport = new PassportAuthController();
    }

    public function get_user_data(Request $request)
    {
        $cookie = $request->cookie('user');
        $user_data = Crypt::decryptString($cookie);

        $user_data = json_decode($user_data);
        $user_id = $user_data->user_id;
        $token = $user_data->token;

        if (auth()->user()->id == $user_id) {

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => auth()->user()->id,
                    'type' => auth()->user()->type,
                    'user_name' => $this->convert->get_full_name(auth()->user()),
                    'avatar' => $this->tools->get_user_avatar(auth()->user()),
                    'extra_type' => $this->passport->get_extra_type(auth()->user()->type),
                    'token' => $token,
                ],
                'message' => 'Авторизація прошла успішно'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'Користувач не авторизований'
            ], 401);
        }
    }
}
