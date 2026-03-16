<?php

namespace App\Repositories;

use App\Models\Wallet;
use App\Models\WalletTransaction;

class WalletRepository
{
    public function getPassengerWallet(int $userId){
        return Wallet::select('balance')
            ->where('user_id', $userId)
            ->first();
    }

    public function create(int $userId): void {
        Wallet::create([
            'user_id' => $userId,
            'balance' => 0.00,
        ]);
    }

    public function createRechargeTransaction(array $data): mixed {
        return WalletTransaction::create($data);
    }

    public function updateTransaction(array $data, string $id): mixed {
        return WalletTransaction::where('id', $id)->update($data);
    }

    public function findWalletTransactionByExternalId(string $externalId): mixed {
        return WalletTransaction::select('id', 'wallet_id', 'type')
            ->where('external_tx_id', $externalId)
            ->first();
    }

    public function incrementBalanceWallet(int $walletId, float $amount): void {
        Wallet::where('id', $walletId)->increment('balance', $amount);
    }

    public function decrementBalanceWallet(int $walletId, float $amount): void {
        Wallet::where('id', $walletId)->decrement('balance', $amount);
    }
}