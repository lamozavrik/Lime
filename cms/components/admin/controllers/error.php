<?php
namespace cms\components\admin\controllers;

//Проверка на прямое обращение к файлу
if(!defined('LIMECMS'))
    exit("no LimeCMS!");

/**
* Lime CMS
* 
* @author Сердюк Кирилл
* @since 0.1b
* @copyright Copyright (c) 2015 Сердюк Кирилл
*/

class error extends BaseAdmin{

    public function index($title, $msg, $status = 200){
        if($status != 200){
            header("HTTP/1.1 " . $status);
        }

        $this->data['title'] = $title;
        $this->data['msg'] = $msg;
        
        $this->render('error');
    }

}