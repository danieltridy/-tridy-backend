<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use App\Http\Requests\RequestLogin;
use App\Models\Likes;
use Illuminate\Support\Facades\DB;




class AuthController extends Controller
{
    public function register(UserRequest $request)
    {

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
        ]);



        return response()->json([
            'success'   => true,
            'message'   => 'Registro exitoso',
            'data'      => $user
        ]);
    }


    public function login(RequestLogin $request)
    {

     $user = User::where('email',$request['email'])->first();
     //$like = Likes::where('user_id', $user->id);
     if(!$user){
        return response()->json([
            'success'   => false,
            'message'   => 'Correo Electronico incorrecto',
            'data'      => null
        ]);
     }

     if(!Hash::check($request['password'], $user->password)){

        return response()->json([
            'success'   => false,
            'message'   => 'Contrasena incorrecta',
            'data'      => null
        ]);
     }
     $like = DB::SELECT('select tridy_id from likes al where user_id = ('.$user->id.')');

        return response()->json([
            'success'   => true,
            'message'   => 'Login exitoso',
            'data'      => $user,
            'likes'      => $like
        ]);
    }

    public function logout()
    {
        $user = request()->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return [
            'message'   => 'salir',

        ];
    }
}
