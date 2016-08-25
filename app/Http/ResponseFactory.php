<?php

namespace App\Http;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Laravel\Lumen\Http\ResponseFactory as Response;
use Zend\Config\Config;
use Zend\Config\Writer\Xml;

class ResponseFactory extends Response
{
    public function make($content = '', $status = 200, array $headers = [])
    {
        /** @var Request $request */
        $request = app('request');
        $acceptHeader = $request->header('accept');
        if($acceptHeader == '*/*'){
            return parent::make($this->getXML($content),$status, $headers);
        }
        $result = "";
        switch ($acceptHeader){
            case 'application/json':
                $result = $this->json($content, $status, $headers);
                break;
            case 'application/xml':
                $result = parent::make($this->getXML($content),$status, $headers);
                break;
        }
        return $result;
    }

    protected function getXML($data)
    {
        if($data instanceof Arrayable){
            $data = $data->toArray();
        }
        $config = new Config(['result' => $data],true);
        $xmlWriter = new Xml();
        return $xmlWriter->toString($config);
    }
}