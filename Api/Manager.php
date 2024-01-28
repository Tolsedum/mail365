<?php

namespace App\Mailing\mail365\Api;

use Exception;
use App\Mailing\mail365\Api\traits\Tools;

class Manager extends Auth{
    use Tools;

    protected $dataParam;

    public function __call($method, $args){
        if(method_exists($this->dataParam, $method)){
            $params = isset($args[0]) ? $args[0] : [];
            $this->dataParam->{$method}();
            $method_data = $this->getParam($params, $this->dataParam->{$method}());
            return $this->getReturnParams($method_data);
        }else{
            throw new Exception("Methode dose not exist", 0);
        }
    }

    public function __construct(array $param){
        parent::__construct($param);
        $this->dataParam = new DataContainer();
    }

    protected function getRequestUrl($path){
        $url = sprintf('https://api.mail365.ru/%s', $path);
        $url .= "?apiKey=" . $this->api_key;
        return $url;
    }
    
    protected function getReturnParams($param){
        if(!empty($param["json_format"])){
            // $param["data"] = json_encode($param["data"]);
        }
        if(isset($param["error"])){
            $message = "Empty vars {";
            foreach ($param["error"] as $key => $value) {
                $message .= $key . ", ";
            }
            $message = substr($message, 0, strlen($message) - 1);
            $message .= "}";
            echo $message;
            die;
            throw new Exception($message, 1);
            
        }
        if(empty($param["extra"]["headers"])){
            $param["extra"]["headers"] = [];
        }
        
        $param["extra"]["headers"] = array_merge(
            $param["extra"]["headers"], 
            $this->getHeadersForRequest()
        );
        return [
            "method" => $param["method"],
            "url" => $this->getRequestUrl($param["url"]),
            "data" => $param["data"],
            "extra" => $param["extra"],
        ];
    }
}