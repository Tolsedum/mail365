<?php 

namespace App\Mailing\mail365\Api;

class Auth{
    protected $api_key;

    public function __construct(array $param){
        foreach (["api_key"] as $_init_var) {
            if(isset($param[$_init_var])){
                $this->{$_init_var} = $param[$_init_var];
            }
        }
    }

    protected function getHeadersForRequest(){
        return [
            "Authorization: ApiKey " . $this->api_key,
        ];
    }
}