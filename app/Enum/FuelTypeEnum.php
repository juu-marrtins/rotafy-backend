<?php

namespace App\Enum;

enum FuelTypeEnum: string
{
    case GASOLINE = 'gasoline';
    case ETHANOL  = 'ethanol';
    case FLEX     = 'flex';
    case DIESEL   = 'diesel';

    public function price(): float
    {
        return match($this) {
            self::GASOLINE => 6.52,
            self::ETHANOL  => 4.87,
            self::FLEX     => 6.52,
            self::DIESEL   => 6.08,
        };
    }

    public function consumption(): float
    {
        return match($this) {
            self::GASOLINE => 10.6,
            self::ETHANOL  => 7.5,
            self::FLEX     => 10.6,
            self::DIESEL   => 11.9,
        };
    }
}