<?php

namespace App\Services;

class Converter
{
    private $roman_numerals = [
        'M'  => 1000,
        'CM' => 900,
        'D'  => 500,
        'CD' => 400,
        'C'  => 100,
        'XC' => 90,
        'L'  => 50,
        'XL' => 40,
        'X'  => 10,
        'IX' => 9,
        'V'  => 5,
        'IV' => 4,
        'I'  => 1
    ];

    /**
     * @param int $n
     * @return string
     */
    public function convert(int $n)
    {
        $res = '';

        $n = abs($n);

        foreach ($this->roman_numerals as $roman => $number){

            $matches = intval($n / $number);

            $res .= str_repeat($roman, $matches);

            $n = $n % $number;
        }

        return $res;
    }
}