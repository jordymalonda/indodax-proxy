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

    public function orderBuy(Request $request) {
        $validator = Validator::make(
            [
                'method' => $request->method,
                'pair' => $request->pair,
                'type' => $request->type,
                'price' => $request->price,
            ],
            [
                'method' => 'required',
                'pair' => 'required',
                'type' => 'required',
                'price' => 'required',
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

    public function orderSell(Request $request) {
        $validator = Validator::make(
            [
                'method' => $request->method,
                'pair' => $request->pair,
                'type' => $request->type,
                'price' => $request->price,
                'idr' => $request->idr,
                'symbol' => $request->symbol,
                'amount' => $request->amount,
            ],
            [
                'method' => 'required',
                'pair' => 'required',
                'type' => 'required',
                'price' => 'required',
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
                $request->symbol => $request->amount,
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

    public function cancelOrder(Request $request) {
        $validator = Validator::make(
            [
                'pair' => $request->pair,
                'order_id' => $request->order_id,
                'type' => $request->type,
            ],
            [
                'pair' => 'required',
                'order_id' => 'required',
                'type' => 'required',
            ]
        );

        if (!$validator->fails()) {

            $data = [
                'method' => $request->method,
                'nonce' => time(),
                'pair' => $request->pair,
                'order_id' => $request->order_id,
                'type' => $request->type,
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

    public function openOrder(Request $request) {
        $validator = Validator::make(
            [
                'pair' => $request->pair,
            ],
            [
                'pair' => 'required',
            ]
        );

        if (!$validator->fails()) {

            $data = [
                'method' => $request->method,
                'nonce' => time(),
                'pair' => $request->pair,
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

    public function getOrder(Request $request) {
        $validator = Validator::make(
            [
                'pair' => $request->pair,
                'order_id' => $request->order_id,
            ],
            [
                'pair' => 'required',
                'order_id' => 'required',
            ]
        );

        if (!$validator->fails()) {

            $data = [
                'method' => $request->method,
                'nonce' => time(),
                'pair' => $request->pair,
                'order_id' => $request->order_id,
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
