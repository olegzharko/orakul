<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use http\Cookie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;

class CookieController extends Controller
{
    public $crypt_key;

    public function __construct()
    {

    }

    public function set_cookie(Request $request)
    {
        $minutes = 60;
        $user_id = 10;
        $encrypt_string = $this->encrypt($user_id);
        $response = new Response('notary');
        $response->withCookie(cookie('user', $encrypt_string, $minutes));
        return $response;
    }

    public function get_cookie(Request $request)
    {
        $cookie = $request->cookie('user');
        $result = $this->decrypt($cookie);
        return $result;
    }

   public function encrypt($string)
   {
        $encrypted = Crypt::encryptString($string);

        return $encrypted;
   }

    public function decrypt($string)
    {
         $decrypt= Crypt::decryptString($string);
         dd($decrypt);
    }
}
