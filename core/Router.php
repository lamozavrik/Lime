<?php
namespace core;

//Проверка на прямое обращение к файлу
if(!defined('LIMECMS'))
	exit("no LimeCMS!");

/**
* Lime CMS
* 
* Класс на основе Singleton
* 
* @author Сердюк Кирилл
* @since 0.1b
* @copyright Copyright (c) 2015 Сердюк Кирилл
*/

class Router{

	use traits\Singleton;

	private $component;
	private $page_type;
	private $method = 'index';

	private function __construct(){

		$this->component = config('components.installed.' . config('components.default'));

		if(!$first_segment = request()->segment(1)){
			lang()->setLanguage(lang()->def_lang['id']);
			$this->page_type = 'main';
		} else {

			if(isset(lang()->installed_langs[$first_segment])){

				if(lang()->def_lang['id'] == $first_segment){

					$segments = request()->segments();
					unset($segments[0]);
					$location = '/' . implode('/', $segments);

					if(request()->query_string()){
						$location .= '?' . request()->query_string();
					}

					\Lime::instance()->redirect($location);
				}

				lang()->setLanguage($first_segment);
				$first_segment = request()->segment(2);
			} else {
				lang()->setLanguage(lang()->def_lang['id']);
			}

			if($first_segment){
				//$this->component = config('components.installed.' . $first_segment);	
				if(config('components.installed.' . $first_segment)){
					$this->component = config('components.installed.' . $first_segment);
				} else {
					$this->method = $first_segment;
				}
			} else {
				$this->page_type = 'main';
			}

		}

		if(!$this->component || !isset($this->component['url_access']) || !$this->component['url_access'])
			request()->setStatus(404);

		if(!isset($this->component['path']) || !$this->component['path'])
			request()->setStatus(404);

		if(request()->status(404))
			$this->component = config('components.installed.errors');

	}

	public function run(){
		$class = 'cms/components/' . $this->component['path'];
		$action = $this->action($class);

		if(!method_exists($action, $this->method))
			throw new \Exception("Метод " . $this->method . " в классе ' . $class . ' не существует");

		$action->{$this->method}();
	}

	public function action($class, $args = []){
		$class = str_replace('/', '\\',  $class);
		if(!class_exists($class))
			throw new \Exception("Класс " . $class . " не существует");

		return new $class($args);
	}

	public function pageType(){
		return $this->page_type;
	}

	public function component($key = null){
		if(!$key)
			return $this->component;

		return isset($this->component[$key]) ? $this->component[$key] : null;
	}

}