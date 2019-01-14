<?php

namespace App\Http\Controllers\Api\Auth;

use Artisan;
use App\User;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'me']]);
    }

    public function login(Request $request)
    {
        Artisan::call('config:cache');
        Artisan::call('cache:clear');

        if(is_numeric($request->get('email'))) {
            $credentials = [ 'phone' => $request->get('email'), 'password' => $request->get('password') ];
        }
        elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $request->get('email'), 'password' => $request->get('password')];
        }

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me(Request $request)
    {
        return Order::where('user_id', $request->user_id)
                    ->with([
                      'order_steps', 'order_steps.room_steps', 'order_steps.room_steps.room.roomType',
                      'order_steps.room_steps.room', 'order_steps.room_steps.services',
                      'order_steps.room_steps.services'
                    ])
                    ->first();
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 3600,
            'user_id' => auth()->id()
        ]);
    }
}
