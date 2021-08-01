<?php

namespace App\Http\Controllers;

use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


class AuthController extends Controller
{

    public $token = true;

    public function __construct()
    {
    }

    public function login(Request $request)
    {


        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token =  JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], Response::HTTP_UNAUTHORIZED);
        }


        return response()->json([
            'success' => true,
            'token' => $jwt_token,

        ]);
    }


    public function register(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'c_password' => 'required|same:password',
                'id_role' => 'required',
            ]
        );

        if ($validator->fails()) {

            return response()->json(['error' => $validator->errors()], 401);
        }


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->id_role = $request->id_role;
        $user->password = bcrypt($request->password);
        $user->save();

        $token = JWTAuth::fromUser($user);

        return response()->json(['status' => "created"], 201);


        // return response()->json([
        //     'success' => true,
        //     'data' => $user
        // ], Response::HTTP_OK);
    }
    public function logout()
    {

        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'error'   => false,
                'message' => trans('auth.logged_out')
            ]);
        } catch (TokenExpiredException $exception) {
            return response()->json([
                'error'   => true,
                'message' => trans('auth.token.expired')

            ], 401);
        } catch (TokenInvalidException $exception) {
            return response()->json([
                'error'   => true,
                'message' => trans('auth.token.invalid')
            ], 401);
        } catch (JWTException $exception) {
            return response()->json([
                'error'   => true,
                'message' => trans('auth.token.missing')
            ], 500);
        }
    }
    public function profil()
    {
        return response()->json($this->guard()->user());
    }

    public function get_user(Request $request)
    {


        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }




    public function refresh()
    {

        return $this->respondWithToken(auth()->refresh());
    }
}