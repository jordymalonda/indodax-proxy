<?php namespace App\Http\Service;

class ApiHelper {

    public function GetContent($rest)
    {
        $content = json_decode($rest->getBody()->getContents());

        if (!isset($content->message) && !$content->message) {
            return (isset($content->data)) ? $content->data : null;
        } else {
            return $content;
        }
    }

    public function GetStatus($rest)
    {
        $content = json_decode($rest->getBody()->getContents());
        
        return $content;
    }

    public function GetException($e)
    {
        if ($e->getResponse()) {
            $rest = json_decode($e->getResponse()->getBody()->getContents());

            if (isset($rest->message) && $rest->message) {
                return $rest;
            }
        } 

        return NULL;
    }

    public function BuildQuery($params)
    {
        $query = $params;
        foreach ($params as $key => $param) {
            if ($param == null || !$param) {
                unset($query[$key]);
            }
        }

        return $query;
    }
    
}