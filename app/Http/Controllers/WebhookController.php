<?php

namespace App\Http\Controllers;

use App\Services\WalletService;
use Symfony\Component\HttpFoundation\Request;

class WebhookController
{
    public function __construct(
        protected WalletService $walletService,
    ){}

    public function pix(Request $request) {
        $this->walletService->handlePixFlow($request->getContent());
        return response()->noContent();
    }
}