<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\WebhookController;
use App\Services\UserService;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/email/verify/{id}/{hash}', function (Request $request, string $id, string $hash, UserService $userService) { // NOTE: Temporario ate ter o front

    $result = $userService->verifyEmail($id, $hash);

    $html = match ($result['status']) {
        'invalid' => '
            <div style="height:4px;background:#e53e3e;margin-bottom:32px"></div>
            <h1 style="color:#1d3557;font-size:20px;margin-bottom:16px">Link inválido</h1>
            <p style="color:#4a5568;font-size:14px;line-height:1.8">Este link de verificação é inválido ou expirou.</p>
        ',
        'already_verified' => '
            <div style="height:4px;background:#457b9d;margin-bottom:32px"></div>
            <h1 style="color:#1d3557;font-size:20px;margin-bottom:16px">Já verificado!</h1>
            <p style="color:#4a5568;font-size:14px;line-height:1.8">Seu e-mail já estava verificado. Pode fazer login normalmente.</p>
        ',
        'verified' => '
            <div style="height:4px;background:#a8e63e;margin-bottom:32px"></div>
            <h1 style="color:#1d3557;font-size:20px;margin-bottom:16px">E-mail verificado!</h1>
            <p style="color:#4a5568;font-size:14px;line-height:1.8">Sua conta foi ativada com sucesso.</p>
        ',
    };

    $statusCode = $result['status'] === 'invalid' ? 403 : 200;

    return response("
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Verificação de E-mail</title>
        </head>
        <body style='font-family:Helvetica Neue,Arial,sans-serif;text-align:center;padding:80px 16px;background:#e8ecf0;margin:0'>
            <div style='background:white;max-width:400px;margin:0 auto;padding:48px;box-shadow:0 2px 12px rgba(29,53,87,0.1)'>
                {$html}
            </div>
        </body>
        </html>
    ", $statusCode);

})->name('verification.verify');

Route::post('v1/webhook/pix', [WebhookController::class, 'pix']);

Route::prefix('v1/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});


Route::prefix('v1/driver')->middleware('auth:sanctum')->group(function () {
    Route::post('/register', [DriverController::class, 'register']);
});

Route::prefix('v1/passenger')->middleware('auth:sanctum')->group(function () {
    Route::post('/wallet/recharge', [PassengerController::class, 'recharge']);
    Route::get('/wallet/balance', [PassengerController::class, 'balance']);
});

