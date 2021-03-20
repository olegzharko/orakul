<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Auth;
use Session;

class PassportAuthController extends BaseController
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'message' => 'Користувач був зареєстрований'
        ], 200);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($data)) {
            Session::put('user', auth()->user()->id);
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json([
                'success' => true,
                'data' => [
                    'token' => $token,
                    'type' => auth()->user()->type,
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

    public function check_user()
    {
        if (auth()->user()) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json([
                'success' => true,
                'data' => [
                    'token' => $token,
                    'type' => auth()->user()->type,
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

    public function password_forgot(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = \Str::random(60);

        $datetime = new \DateTime();

        \DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token, 'created_at' => $datetime]
        );

         \Mail::send('auth.password.verify',['token' => $token], function($message) use ($request) {
            $message->from($request->email);
            $message->to('olegzharko@gmail.com');
            $message->subject('Запит на відновлення пароля');
        });

        return response()->json([
            'success' => true,
            'data' => [
                'status' => 'success',
            ],
            'message' => 'Ми відправимо вам email з посиланням на відновлення паролю'
        ], 200);
    }

    public function password_reset($token)
    {
        // повернути токен на view react
        // необхідно передати токен в форму відновлення пароля та надіслати цей токен для перевірки

//        <div class="container">
//             <div class="row justify-content-center">
//                 <div class="col-md-8">
//                     <div class="card">
//                         <div class="card-header">Verify Your Email Address</div>
//                           <div class="card-body">
//            @if (session('resent'))
//                                 <div class="alert alert-success" role="alert">
//                                    {{ __('A fresh verification link has been sent to your email address.') }}
//                                </div>
//            @endif
//                            <a href="{{ url('/reset-password/'.$token) }}">Click Here</a>.
//                        </div>
//                    </div>
//                </div>
//            </div>
//        </div>

    }
    // https://codingdriver.com/laravel-custom-authentication-tutorial-with-example.html
    public function password_update(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',

        ]);

        $updatePassword = \DB::table('password_resets')
            ->where(['email' => $request->email, 'token' => $request->token])
            ->first();

        if(!$updatePassword)
            return $this->sendError("Данний токен не є активним");

        User::where('email', $request->email)
            ->update(['password' => \Hash::make($request->password)]);

        \DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return $this->sendResponse([], 'Пароль було оновлено');
    }

    public function extra_logout(Request $request)
    {
        if (\Auth::check()) {
            $user_id = $request->user()->id;
            $secret_password = \Str::random(15);
            User::where('id', $user_id)->update(['password' => \Hash::make($secret_password)]);
            $request->user()->token()->revoke();
            return $this->sendResponse([], 'Ви закінчили свою сесію.');
        } else {
            return $this->sendError("Користувач не був авторизований.");
        }
    }

    public function logout(Request $request)
    {
        if (\Auth::check()) {
            $request->user()->token()->revoke();
            return $this->sendResponse([], 'Ви закінчили свою сесію.');
        } else {
            return $this->sendError("Користувач не був авторизований.");
        }
    }
}
