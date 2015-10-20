<?php
namespace cms\components\admin\controllers\administrator;

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

use \cms\components\admin\controllers\BaseAdmin;

class administrator extends BaseAdmin{

    public function index(){
        $this->render('administrator/main');
    }

}