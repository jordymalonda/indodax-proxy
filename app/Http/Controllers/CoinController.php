<?php

namespace App\Http\Controllers;

use App\Traits\GeneralResponse;
use App\Http\Service\ApiIndodax;
use App\Http\Helper\AppHelper;
use Illuminate\Http\Request;
use Validator;

class CoinController extends Controller
{
    // use GeneralResponse;

    public function __construct()
    {
        $this->apiIndodax = new ApiIndodax();
    }

    public function transaction(Request $request) {
        $validator = Validator::make(
            [
                'method' => $request->method,
                'pair' => $request->pair,
                'type' => $request->type,
                'price' => $request->price,
                'idr' => $request->idr,
                'btc' => $request->btc,
            ],
            [
                'method' => 'required',
                'pair' => 'required',
                'type' => 'required',
                'price' => 'required',
                'idr' => 'required',
                'btc' => 'required',
            ]
        );

        if (!$validator->fails()) {

            $data = [
                'method' => $request->method,
                'nonce' => time(),
                'pair' => $request->pair,
                'type' => $request->type,
                'price' => $request->price,
                'idr' => $request->idr,
                'btc' => $request->btc,
            ];
    
            $result = $this->apiIndodax->transaction($data);
            $resultJson = json_decode(json_encode($result), true);
    
            return response($resultJson, 200);
        } else {
            $messages = json_decode($validator->messages());

            $mess = '';
            foreach ($messages as $key => $val) {
                $mess = $val[0];
                break;
            }

            return response(400, $mess);
        }
    }
}
