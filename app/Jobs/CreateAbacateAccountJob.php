<?php

namespace App\Jobs;

use App\Models\User;
use App\Providers\PaymentProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateAbacateAccountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public User $user
    ){}

    public function handle(PaymentProvider $paymentProvider) {
        if ($this->user->abacate_id) {
            return;
        }

        $abacateId = $paymentProvider->createAccount([
            'name'  => $this->user->name,
            'phone' => $this->user->phone,
            'email' => $this->user->email,
            'cpf'   => $this->user->cpf,
        ]);

        $this->user->update([
            'abacate_id' => $abacateId
        ]);
    }
}
