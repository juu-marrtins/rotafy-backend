<?php

namespace App\Jobs;

use App\Models\User;
use App\Providers\PaymentProvider;
use App\Services\WalletService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CreateAbacateAccountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public User $user,
    ){}

    public function handle(PaymentProvider $paymentProvider, WalletService $walletService) {
        $user = $this->user;
        if ($user->abacate_id) {
            return;
        }

        $abacateId = $paymentProvider->createAccount([
            'name'  => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
            'cpf'   => $user->cpf,
        ]);

        DB::transaction(function () use ($user, $abacateId, $walletService) {
            $user->update(['abacate_id' => $abacateId]);
            $walletService->create($user->id);
        });
    }
}
