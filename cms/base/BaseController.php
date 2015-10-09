<?php
namespace cms\base;

use \core\View as View;

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

class BaseController{

	protected $layout = 'main';
	protected $data = [];
	protected $user;
	protected $settings;

	public function __construct(){
		$this->user = User::instance();
		$this->data['user'] = $this->user;
	}

	public function __get($var){
		return lime($var);
	}

	protected function setLayout($layout){
		$this->layout = $layout;
	}

	protected function render($view = null, $return = false){
		if($return)
			return View::factory($view)->render($this->data);

		if(!$view){
			echo View::factory($this->layout)->render($this->data);
			return;
		}

		if($this->layout){
			$data = View::factory($view)->render($this->data);
			echo View::factory($this->layout)->render(['content' => $data]);
		} else {
			echo View::factory($view)->render($this->data);
		}
	}

}