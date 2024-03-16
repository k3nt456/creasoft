<?php

namespace App\Services\Autentication;

use App\Traits\HasResponse;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthService
{
    use HasResponse;

    public function login($params)
    {
        try {
            $credentials = [
                'username' => $params['username'],
                'password' => $params['password'],
            ];

            $token = Auth::guard('api')->attempt($credentials);
            if (!$token) return $this->errorResponse('Credenciales incorrectas.', 401);

            $user = Auth::guard('api')->user();
            $data = $this->respondWithToken($token, $user);

            return $this->successResponse('Inicio de sesión exitoso.', $data);
        } catch (\Throwable $th) {
            return $this->externalError('durante el inicio de sesión.', $th->getMessage());
        }
    }

    private function respondWithToken($token, $user)
    {
        return [
            'access_token'  => $token,
            'user'          => $user,
            'token_type'    => 'bearer',
            'expires_in'    => JWTAuth::factory()->getTTL() * 2000,
        ];
    }

    public function refreshToken()
    {
        try {
            Auth::guard('api')->refresh();
            return $this->successResponse('Sesión actualizada con éxito.');
        } catch (\Throwable $th) {
            return $this->externalError('durante la actualización del token.', $th->getMessage());
        }
    }

    public function logout()
    {
        try {
            Auth::guard('api')->logout();
            return $this->successResponse('Sesión cerrada con éxito.');
        } catch (\Throwable $th) {
            return $this->externalError('durante el cierre de sesión.', $th->getMessage());
        }
    }
}
