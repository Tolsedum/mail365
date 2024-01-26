<?php

namespace App\Mailing\mail365\Api;

use App\Mailing\IApiRequest;

class Data extends IApiRequest{

    protected function getParam($param, $js_data){
        $insert_data_in_url = is_numeric(strpos($js_data["url"], "{"));
        $ret_params = [
            "methode" => $js_data["methode"],
            "url" => $js_data["url"],
        ];
        foreach ($js_data["patern"] as $key => $value) {
            $id = strtolower($key);
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
                    $ret_params["request_param"][$key] = $param[$id];
                }
            } 
        }
        $ret_params["extra"] = [];
        if(in_array($ret_params["methode"], ["post", "put"])){
            foreach (["Accept: application/json", "Content-Type: application/json"] 
                as $_header
            ) {
                $ret_params["extra"]["headers"][] = $_header;    
            }
            $ret_params["json_format"] = true;
        }
        return $ret_params;
    }

     /**
     * Получения список групп контактов
     * Данные для получения информации о группах контактов в порядке их создания
     * @link https://www.mail365.ru/api.php#descriptionGetContactGroups
     */
    public function getDataGroupList(array $param){
        $js_data = json_decode(file_get_contents(
            "../private/files/mail_service_schems/mail365/scheme/contactGroups.json"
            ), 
            true
        )["get_contactGroups"];
        
        return $this->getParam($param, $js_data);
    }

    /**
     * Добавление новой адресной базы
     * Данные для создания новой контактной группы 
     * @link https://www.mail365.ru/api.php#descriptionGetContactGroups
     */
    public function addContactGroup(array $param){
        $js_data = json_decode(file_get_contents(
            "../private/files/mail_service_schems/mail365/scheme/contactGroups.json"
            ), 
            true
        )["post_contactGroups"];
        
        return $this->getParam($param, $js_data);
    }

    /**
     * Обновление контактной информации адресной базы
     * Данные для того чтобы переименовать контактную группу
     * @link https://www.mail365.ru/api.php#descriptionGetContactGroups
     */
    public function updateContactGroup(array $param){
        $js_data = json_decode(file_get_contents(
            "../private/files/mail_service_schems/mail365/scheme/contactGroups.json"
            ), 
            true
        )["post_contactGroups/{Id}"];
        
        return $this->getParam($param, $js_data);
    }

    /**
     * Удалить контактную группу
     * Данные для удаления контактной группы
     * @link https://www.mail365.ru/api.php#descriptionGetContactGroups
     */
    public function deleteContactGroup(array $param){
        $js_data = json_decode(file_get_contents(
            "../private/files/mail_service_schems/mail365/scheme/contactGroups.json"
            ), 
            true
        )["delete_contactGroups/{id}"];
        
        return $this->getParam($param, $js_data);
    }

    /**
     * Подписать пользователя на рассылку
     * Добавить контакт и прикрепить его к группе
     * Данные для добавления в группу контакта
     * @link https://www.mail365.ru/api.php#descriptionGetContactGroups
     */
    public function subscribeContact(array $param){
        $js_data = json_decode(file_get_contents(
            "../private/files/mail_service_schems/mail365/scheme/contactGroups.json"
            ), 
            true
        )["post_contactGroups/{id}/contacts"];
        
        return $this->getParam($param, $js_data);
    }
}