<?php
namespace cms\components\pages\controllers;

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

class pages extends BaseController{

	public function index(){
		$this->data['title'] = 'Hello, World!';

		$this->render('test');
	}

}