<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\RegistrationService;
use Illuminate\Http\Request;


class RegistrationController extends Controller
{
    private RegistrationService $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }


    public function register(Request $request) 
    {
        return $this->registrationService->register($request);
    }

    public function retrieveData() 
    {
        return $this->registrationService->retrieveData();
    }

    public function updateProfile(Request $request)
    {
        return $this->registrationService->updateProfile($request);
    }

}
