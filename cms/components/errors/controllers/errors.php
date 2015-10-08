<?php
namespace cms\components\errors\controllers;

use cms\base\BaseController;

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

class errors extends BaseController{

    public function index(){
        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $this->request->status());
    }

}