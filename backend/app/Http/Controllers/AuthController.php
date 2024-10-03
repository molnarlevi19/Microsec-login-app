<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function login(Request $request)
    {
        return $this->authService->login($request);
    }

    public function logout()
    {
        return $this->authService->logout();
    }

}
