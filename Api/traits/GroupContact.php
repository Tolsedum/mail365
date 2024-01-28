<?php


namespace App\Mailing\mail365\Api\traits;

trait GroupContact{
    protected $path = "../app/Mailing/mail365/Api/scheme/contactGroups.json";

    /**
     * Получения список групп контактов
     * Данные для получения информации о группах контактов в порядке их создания
     * @link https://www.mail365.ru/api.php#descriptionGetContactGroups
     */
    public function getContactGroup(array $param = []){
        $js_data = json_decode(file_get_contents($this->path), 
            true
        )["get_contactGroups"];
        
        return $js_data;
    }

    /**
     * Добавление новой адресной базы
     * Данные для создания новой контактной группы 
     * @link https://www.mail365.ru/api.php#descriptionGetContactGroups
     */
    public function addContactGroup(array $param = []){
        $js_data = json_decode(file_get_contents($this->path), 
            true
        )["post_contactGroups"];
        
        return $js_data;
    }

    /**
     * Обновление контактной информации адресной базы
     * Данные для того чтобы переименовать контактную группу
     * @link https://www.mail365.ru/api.php#descriptionGetContactGroups
     */
    public function updateContactGroup(array $param = []){
        $js_data = json_decode(file_get_contents($this->path), 
            true
        )["post_contactGroups/{Id}"];
        
        return $js_data;
    }

    /**
     * Удалить контактную группу
     * Данные для удаления контактной группы
     * @link https://www.mail365.ru/api.php#descriptionGetContactGroups
     */
    public function deleteContactGroup(array $param = []){
        $js_data = json_decode(file_get_contents($this->path), 
            true
        )["delete_contactGroups/{id}"];
        
        return $js_data;
    }

    /**
     * Подписать пользователя на рассылку
     * Добавить контакт и прикрепить его к группе
     * Данные для добавления в группу контакта
     * @link https://www.mail365.ru/api.php#descriptionGetContactGroups
     */
    public function subscribeContact(array $param = []){
        $js_data = json_decode(file_get_contents($this->path),
            true
        )["post_contactGroups/{id}/contacts"];
        
        return $js_data;
    }
}