<?php

namespace app\components;

use Andromeda\ISO8583\Contracts\IsoMessageContract;
use Andromeda\ISO8583\MessageDefinition;

class Iso8583Definition extends MessageDefinition implements IsoMessageContract {

    public function getIso(): array {
        return [
//          bit => ['type','size','is variable or fixed']
            1 => ['n', 16, self::FIXED_LENGTH],
            2 => ['n', 19, self::VARIABLE_LENGTH],
            3 => ['n', 6, self::FIXED_LENGTH],
            4 => ['n', 12, self::FIXED_LENGTH],
            5 => ['n', 12, self::FIXED_LENGTH],
            6 => ['n', 12, self::FIXED_LENGTH],
            7 => ['n', 10, self::FIXED_LENGTH],
            8 => ['n', 8, self::FIXED_LENGTH],
            9 => ['n', 8, self::FIXED_LENGTH],
            10 => ['n', 8, self::FIXED_LENGTH],
            11 => ['n', 6, self::FIXED_LENGTH],
            12 => ['n', 6, self::FIXED_LENGTH],
            13 => ['n', 4, self::FIXED_LENGTH],
            14 => ['n', 4, self::FIXED_LENGTH],
            15 => ['n', 4, self::FIXED_LENGTH],
            16 => ['n', 4, self::FIXED_LENGTH],
            17 => ['n', 4, self::FIXED_LENGTH],
            18 => ['n', 4, self::FIXED_LENGTH],
            19 => ['n', 3, self::FIXED_LENGTH],
            20 => ['n', 3, self::FIXED_LENGTH],
            21 => ['n', 3, self::FIXED_LENGTH],
            22 => ['n', 3, self::FIXED_LENGTH],
            23 => ['n', 3, self::FIXED_LENGTH],
            24 => ['n', 3, self::FIXED_LENGTH],
            25 => ['n', 2, self::FIXED_LENGTH],
            26 => ['n', 2, self::FIXED_LENGTH],
            27 => ['n', 1, self::FIXED_LENGTH],
            28 => ['n', 9, self::FIXED_LENGTH],
            29 => ['n', 9, self::FIXED_LENGTH],
            30 => ['n', 9, self::FIXED_LENGTH],
            31 => ['n', 9, self::FIXED_LENGTH],
            32 => ['n', 11, self::VARIABLE_LENGTH],
            33 => ['n', 11, self::VARIABLE_LENGTH],
            34 => ['ns', 28, self::VARIABLE_LENGTH],
            35 => ['z', 37, self::VARIABLE_LENGTH],
            36 => ['n', 104, self::VARIABLE_LENGTH],
            37 => ['an', 12, self::FIXED_LENGTH],
            38 => ['an', 6, self::FIXED_LENGTH],
            39 => ['an', 2, self::FIXED_LENGTH],
            40 => ['an', 3, self::FIXED_LENGTH],
            41 => ['ans', 8, self::FIXED_LENGTH],
            42 => ['ans', 15, self::FIXED_LENGTH],
            43 => ['ans', 40, self::FIXED_LENGTH],
            44 => ['an', 25, self::VARIABLE_LENGTH],
            45 => ['an', 76, self::VARIABLE_LENGTH],
            46 => ['an', 999, self::VARIABLE_LENGTH],
            47 => ['an', 999, self::VARIABLE_LENGTH],
            48 => ['an', 999, self::VARIABLE_LENGTH],
            49 => ['n', 3, self::FIXED_LENGTH],
            50 => ['n', 3, self::FIXED_LENGTH],
            51 => ['n', 3, self::FIXED_LENGTH],
            52 => ['n', 16, self::FIXED_LENGTH],
            53 => ['n', 16, self::FIXED_LENGTH],
            54 => ['an', 120, self::VARIABLE_LENGTH],
            55 => ['ans', 999, self::VARIABLE_LENGTH],
            56 => ['ans', 999, self::VARIABLE_LENGTH],
            57 => ['ans', 999, self::VARIABLE_LENGTH],
            58 => ['ans', 999, self::VARIABLE_LENGTH],
            59 => ['ans', 999, self::VARIABLE_LENGTH],
            60 => ['ans', 999, self::VARIABLE_LENGTH],
            61 => ['ans', 999, self::VARIABLE_LENGTH],
            62 => ['ans', 999, self::VARIABLE_LENGTH],
            63 => ['ans', 999, self::VARIABLE_LENGTH],
            64 => ['n', 16, self::FIXED_LENGTH],
        ];
    }

}
