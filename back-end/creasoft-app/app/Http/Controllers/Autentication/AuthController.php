<?php

namespace App\Http\Controllers\Autentication;

use App\Http\Controllers\Autentication\Request\AuthRequest;
use App\Http\Controllers\Controller;
use App\Services\Autentication\AuthService;
use App\Traits\HasResponse;

class AuthController extends Controller
{
    use HasResponse;
    /** @var AuthService */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(AuthRequest $request)
    {
        return $this->authService->login($request->validated());
    }

    public function refreshToken()
    {
        return $this->authService->refreshToken();
    }

    public function logout()
    {
        return $this->authService->logout();
    }
}
