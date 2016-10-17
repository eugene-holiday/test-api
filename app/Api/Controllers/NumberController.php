<?php

namespace App\Api\Controllers;

use App\Number;
use App\Services\Converter;
use App\Services\NumberValidator;
use App\Transformers\NumberTransformer;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NumberController extends Controller
{
    use Helpers;

    /**
     * @param Request $request
     * @param Converter $converter
     * @param NumberValidator $numberValidator
     * @return \Dingo\Api\Http\Response
     */
    public function convert(Request $request, Converter $converter, NumberValidator $numberValidator)
    {
        $n = $request->route('number');

        if(!$numberValidator->validate($n)){
            throw new ResourceException('Could not convert the number.', $numberValidator->errors());
        }

        $number = Number::where('arabic', $n)->first();

        if(!$number){
            $number = new Number([
                'arabic' => $n,
                'roman' => $converter->convert($n),
                'times' => 1
            ]);
        } else {
            $number->times +=1;
        }
        $number->save();

        return $this->response->item($number, new NumberTransformer());
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function recent()
    {
        $numbers = Number::recent()->take(10)->get();
        return $this->response->collection($numbers, new NumberTransformer());
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function top()
    {
        $numbers = Number::top()->take(10)->get();
        return $this->response->collection($numbers, new NumberTransformer());
    }
}
