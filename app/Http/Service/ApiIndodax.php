<?php namespace App\Http\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use App\Http\Service\ApiHelper;

class ApiIndodax {

    protected $_baseUri;
    protected $_apiHelper;

    public function __construct()
    {
        $this->_baseUri = new Client(['base_uri' => 'https://indodax.com/tapi/', 'timeout' => env('TIMEOUT_API', 60.0)]);
        $this->_apiHelper = new ApiHelper();
    }

    public function GetSummaries()
    {
        try {
            $rest = $this->_baseUri->request('GET',  "summaries");

            return $this->_apiHelper->GetStatus($rest);
        } catch (RequestException $e) {
            $er = $this->_apiHelper->GetException($e);

            return $er;
        }
    }

    public function GetStreaming($coint)
    {
        $_baseUri = new Client(['base_uri' => 'https://vip.bitcoin.co.id/api/', 'timeout' => env('TIMEOUT_API', 60.0)]);

        try {
            $rest = $_baseUri->request('GET',  "{$coint}/webdata");

            return $this->_apiHelper->GetStatus($rest);
        } catch (RequestException $e) {
            $er = $this->_apiHelper->GetException($e);

            return $er;
        }
    }

    public function transaction($req)
    {
        $post_data = http_build_query($req, '', '&');
        $sign = hash_hmac('sha512', $post_data, env('INDODAX_SECRET'));
        $key = env('INDODAX_KEY');
        $headers = array(
            'Sign: '.$sign,
            'Key: '.$key
        );

        static $ch = null;
        if (is_null($ch)) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; INDODAXCOM PHP client;
       '.php_uname('s').'; PHP/'.phpversion().')');
        }
        curl_setopt($ch, CURLOPT_URL, env('INDODAX_HOST'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        // run the query
        $res = curl_exec($ch);
        
        if ($res === false) throw new Exception('Could not get reply: '.curl_error($ch));
        $dec = json_decode($res, true);

        if (!$dec) throw new Exception('Invalid data received, please make sure connection is working and
       requested API exists: '.$res);
       curl_close($ch);
       $ch = null;
       return $dec;
    }
}