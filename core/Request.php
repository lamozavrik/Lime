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

class Request{

	use traits\Singleton;	

	private $get = [];
	private $post = [];

	private $uri;
	private $query_string;

	private $segmets = [];
	private $status = 200;

	private function __construct(){
		$get =& $this->get;
		$post =& $this->post;

		array_map(function($key) use(&$get){
			$get[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_STRING);
		}, array_keys($_GET));

		array_map(function($key) use(&$post){
			$post[$key] = filter_input(INPUT_POST, $key);
		}, array_keys($_POST));

		$this->parseUrl();
	}

	private function parseUrl(){
		$this->uri = strtolower(trim($_SERVER['REQUEST_URI'], '/'));

		$get = stripos($this->uri, '?');
		if($get !== false)
			$this->uri = substr($this->uri, 0, $get);
		
		$this->segments = explode('/', $this->uri);

		if($get !== false && $_SERVER['QUERY_STRING']){
			$this->query_string = $_SERVER['QUERY_STRING'];
		}
	}

	public function segment($n){
		$n--;
		return isset($this->segments[$n]) ? strtolower($this->segments[$n]) : null;
	}

	public function segments(){
		return $this->segments;
	}

	public function query_string(){
		return $this->query_string;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function status($status = null){
		if(!$status)
			return $this->status;

		return $status == $this->status;
	}

	public function isPost(){
		if($_SERVER['REQUEST_METHOD'] == 'POST')
			return true;

		return false;
	}

	public function isGet(){
		if($_SERVER['REQUEST_METHOD'] == 'GET')
			return true;

		return false;
	}

	public function isAjax(){
		return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
        		&& !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
        		&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}

	public function get($value){
		if(isset($this->get[$value]))
			return $this->get[$value];

		return null;
	}

	public function post($value){
		if(isset($this->post[$value]))
			return $this->post[$value];

		return null;
	}

}