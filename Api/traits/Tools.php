<?php 

namespace App\Mailing\mail365\Api\traits;

trait Tools{
    protected function getParam($param, $js_data){
        $insert_data_in_url = is_numeric(strpos($js_data["url"], "{"));
        $ret_params = [
            "method" => $js_data["method"],
            "url" => $js_data["url"],
            "data" => []
        ];
        foreach ($js_data["patern"] as $key => $value) {
            $id = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $key)); //strtolower($key);
            if(!isset($param[$id]) && $value["optional"]){
                $ret_params["errors"][$id] = "Not enough";
            }else if(isset($param[$id])){
                if(
                    $insert_data_in_url
                    && is_numeric(strpos($ret_params["url"], "{" .$id. "}"))
                ){
                    $ret_params["url"] = 
                        str_replace("{" .$param[$id]. "}", $id, $ret_params["url"]);
                }else{
                    $ret_params["data"][$key] = $param[$id];
                }
            } 
        }
        $ret_params["extra"] = [];
        if(in_array($ret_params["method"], ["post", "put"])){
            foreach (["Accept: application/json", "Content-Type: application/json"] 
                as $_header
            ) {
                $ret_params["extra"]["headers"][] = $_header;    
            }
            $ret_params["json_format"] = true;
        }
        return $ret_params;
    }
}