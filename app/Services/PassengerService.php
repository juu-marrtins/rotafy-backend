<?php

namespace App\Services;

use App\Enum\WalletTransactionTypeEnum;
use App\Helpers\AuthUtils;
use App\Helpers\PaymentHelper;
use App\Providers\PaymentProvider;
use App\Repositories\WalletRepository;

class PassengerService
{
    public function __construct(
        protected WalletRepository $walletRepository,
        protected AuthUtils $authUtils,
        protected PaymentProvider $paymentProvider,
        protected PaymentHelper $paymentHelper,
        protected WalletService $walletService,
    ) {}

    public function getWallet(): string {
        $user = $this->authUtils->user();
        $wallet = $this->walletRepository->getPassengerWallet($user->id);

        return number_format($wallet->balance, 2, '.', '');
    }

    public function recharge(array $data) {
        $user =  $this->authUtils->user();
        $amount = (float) $data['amount'];
        
        $customerData = $this->paymentHelper->makeCustomerData(
            $user->name,
            $user->phone,
            $user->email,
            $user->cpf
        );

        $pix = $this->paymentProvider->createPix(
            $amount,
            $customerData,
            86400,
            'Recharge'
        );

        $this->walletService->createRecharge(
            $user->wallet->id,
            WalletTransactionTypeEnum::RECHARGE->value,
            $amount,
            $pix['data']['id']
        );

        return $pix;
    }
}