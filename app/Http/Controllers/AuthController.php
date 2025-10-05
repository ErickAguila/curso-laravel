<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(UserRequest $request){
        $validatedData = $request->validated();
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), //Encriptamos la información
        ]);
        return response()->json(['message' => 'Usuario registrado correctamente', 'user' => $user], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request) {
        $validateData = $request->validated();
        $credentials = [
            'email' => $validateData['email'],
            'password' => $validateData['password']
        ];

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciales inválidas'], Response::HTTP_UNAUTHORIZED);
            }
        } catch(JWTException) {
            return response()->json(['error' => 'No se pudo generar el token'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token) {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function who() {
        $user = auth()->user();
        return response()->json($user);
    }

    public function logout() {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::invalidate($token);
            return response()->json(['message' => 'Sesión cerrada correctamente'], Response::HTTP_OK);
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo cerrar la sesión'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
