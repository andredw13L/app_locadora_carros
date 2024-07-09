<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(Request $request) {

        $credenciais = $request->all(['email', 'password']);

        // Autenticação (email e senha)
        $token = auth('api')->attempt($credenciais);

        if($token) {
            return response()->json(['token' => $token]);
            
        } else {
            return response()->json(
                ['erro' => 'Usuário ou senha inválido!']
                ,401
            );

            // 401 = Unauthorized
        }

        return 'login';
    }


    public function logout() {
        return 'logout';
    }


    public function refresh() {

        $token = auth('api')->refresh(); // Cliente encaminhe um jwt válido

        return response()->json(['token' => $token]);
    }


    public function me() {
        return response()->json(auth()->user());
    }

}
