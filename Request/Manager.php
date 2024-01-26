<?php

namespace App\Mailing\mail365\Request;

use Exception;

class Manager{
    protected $api_key;

    public function __construct(array $param){
        foreach (["api_key"] as $_init_var) {
            if(isset($param[$_init_var])){
                $this->{$_init_var} = $param[$_init_var];
            }
        }
    }

    /**
     * Get unisender api host
     * @return string
     */
    protected function getApiHost($path){
        return sprintf('https://api.mail365.ru/%s', $path);
    }

    protected function getRequestUrl($path){
        $url = $this->getApiHost($path);
        return $url;
    }
    
    protected function getHeadersForRequest(){
        return [
            "Authorization: ApiKey " . $this->api_key,
        ];
    }

    protected function getReturnParams($param){
        if(!empty($param["json_format"])){
            $param["data"] = json_encode($param["data"]);
        }
        $param["extra"]["headers"][] = $this->getHeadersForRequest();
        return [
            "method" => $param["method"],
            "url" => $this->getRequestUrl($param["url"]),
            "data" => $param["data"],
            "extra" => $param["extra"],
        ];
    }
}