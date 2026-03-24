<?php

namespace App\Enum;

enum ApportionmentPercentageEnum
{
    case ONE;
    case TWO;
    case THREE_OR_MORE;

    public function value(): float
    {
        return match($this) {
            self::ONE           => 0.50,
            self::TWO           => 0.60,
            self::THREE_OR_MORE => 0.70,
        };
    }

    public static function fromSeats(int $seats): self
    {
        return match(true) {
            $seats === 1 => self::ONE,
            $seats === 2 => self::TWO,
            default      => self::THREE_OR_MORE,
        };
    }
}