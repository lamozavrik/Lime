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

class clients extends BaseAdmin{

    public function index(){

        $this->data['create_action'] = url('admin', [
            'r' => 'administrator/clients/create'
        ]);

        $this->render('administrator/clients');
    }

    public function create(){

        $this->data['cancel_action'] = url('admin', [
            'r' => 'administrator/clients'
        ]);

        $this->render('administrator/clients-form');
    }

    public function remove(){

    }

    public function edit(){

    }

}