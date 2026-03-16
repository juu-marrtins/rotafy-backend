<?php

namespace App\Services;

use App\Enum\WalletTransactionTypeEnum;
use App\Enum\WebhookStatusEnum;
use App\Enum\WebhookTriggerEnum;
use App\Exceptions\NotFoundException;
use App\Models\WalletTransaction;
use App\Repositories\WalletRepository;
use Illuminate\Support\Facades\DB;

class WalletService
{
    public function __construct(
        protected WalletRepository $walletRepository
    ) {}

    public function create(int $userId): void {
        $this->walletRepository->create($userId);
    }

    public function createRecharge(int $walletId, string $type, float $amount, string $externalTxId){
        return $this->walletRepository->createRechargeTransaction([
            'wallet_id' => $walletId,
            'type' => $type,
            'amount' => $amount,
            'external_tx_id' => $externalTxId,
            'status' => 'pending',
        ]);
    }

    public function handlePixFlow(string $payload) {
        $eventType = data_get($payload, 'event');
        $externalId = data_get($payload, 'data.external_id');
        $transaction = $this->findByExternalId($externalId);
        $transactionType = $transaction->type;

        DB::transaction(function () use ($eventType, $transaction, $transactionType) {
            return match ($transactionType) {
                WalletTransactionTypeEnum::RECHARGE->value => $this->handleCreditOrRecharge($eventType, $transaction),
                WalletTransactionTypeEnum::WITHDRAWAL->value => $this->handleWithdrawal($eventType, $transaction),
                WalletTransactionTypeEnum::DEBIT->value => $this->handleDebit($eventType, $transaction),
                WalletTransactionTypeEnum::CREDIT->value => $this->handleCreditOrRecharge($eventType, $transaction),
            };
        });
    }

    public function findByExternalId(string $externalId) {
        return $this->walletRepository->findWalletTransactionByExternalId($externalId)
            ?? throw new NotFoundException('Wallet transaction not found');
    }

    private function handleCreditOrRecharge(string $type, WalletTransaction $transaction) {
        if ($type === WebhookTriggerEnum::BILLING_PAID->value) {
            $this->walletRepository->updateTransaction([
                'status' => WebhookStatusEnum::PIX_PAID->value, 
            ], $transaction->id);

            $this->walletRepository->incrementBalanceWallet(
                $transaction->wallet_id,
                $transaction->amount
            );

        } else {
            $this->walletRepository->updateTransaction([
                'status' => WebhookStatusEnum::PIX_DISPUTED->value,
            ], $transaction->id);
        }
    }

    private function handleWithdrawal(string $type, WalletTransaction $transaction) {
        if ($type === WebhookTriggerEnum::WITHDRAWAL_DONE->value) {
            //fazer a transacao
            $this->walletRepository->updateTransaction([
                'status' => WebhookStatusEnum::WITHDRAWAL_DONE->value,
            ], $transaction->id);

            $this->walletRepository->decrementBalanceWallet(
                $transaction->wallet_id,
                $transaction->amount
            );
        } else {
            $this->walletRepository->updateTransaction([
                'status' => WebhookStatusEnum::WITHDRAWAL_FAILED->value,
            ], $transaction->id);
        }
    }

    private function handleDebit(string $type, WalletTransaction $transaction) {
        if ($type === WebhookTriggerEnum::BILLING_PAID->value) {
            $this->walletRepository->updateTransaction([
                'status' => WebhookStatusEnum::PIX_PAID->value,
            ], $transaction->id);

            $this->walletRepository->decrementBalanceWallet(
                $transaction->wallet_id,
                $transaction->amount
            );
        } else {
            $this->walletRepository->updateTransaction([
                'status' => WebhookStatusEnum::PIX_DISPUTED->value,
            ], $transaction->id);
        }
    }
}