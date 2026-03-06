<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\RegisterDriver;
use App\Services\DriverService;

class DriverController extends Controller
{
    public function __construct(
        protected DriverService $driverService
    ){}

    public function register(RegisterDriver $request){
        $this->driverService->register(
            $request->file('cnh_verse'), 
            $request->file('cnh_front'), 
            $request->file('handle_cpf'), 
            $request->cnh_digits,
            $request->plate,
            $request->file('crlv')
        );

        return ApiResponse::success(
            'We are going to analyze your driver license',
            [],
            200
        );
    }
}
