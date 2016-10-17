<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class NumberValidator
{
    private $rules = [
        'number' => 'required|roman',
    ];

    private $errors;

    /**
     * @param $n
     * @return bool
     */
    public function validate($n)
    {
        $validator = Validator::make(['number' => (int) $n], $this->rules);

        if ($validator->fails())
        {
            $this->errors = $validator->errors();
            return false;
        }

        return true;
    }

    public function errors()
    {
        return $this->errors;
    }

    /**
     *  Register in AppServiceProvider
     */
    public function register()
    {
        Validator::extend('roman', function($attribute, $value, $parameters, $validator) {
            return is_int($value) && $value < 4000 && $value > 0;
        });
    }
}