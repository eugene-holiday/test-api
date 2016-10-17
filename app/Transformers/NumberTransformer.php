<?php

namespace App\Transformers;

use League\Fractal;
use App\Number;

class NumberTransformer  extends Fractal\TransformerAbstract
{
    /**
     * @param Number $number
     * @return array
     */
    public function transform(Number $number)
    {
        return [
            'arabic' => (int) $number->arabic,
            'roman' => $number->roman,
            'times' => $number->times
        ];
    }
}