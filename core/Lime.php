<?php
//Проверка на прямое обращение к файлу
if(!defined('LIMECMS'))
	exit("no LimeCMS!");

/**
* Lime CMS
* 
* Основной класс CMS
* 
* Класс на основе Singleton
* 
* @author Сердюк Кирилл
* @since 0.1b
* @copyright Copyright (c) 2015 Сердюк Кирилл
*/

class Lime{

	use core\traits\Singleton;	

	private $registry = [];

	private function __construct(){
		$this->registry['db'] = core\DB::factory('default');
		config()->load(unserialize($this->registry['db']->prepare("SELECT config FROM settings LIMIT 1")->execute()->fetch()->config));
		$this->registry['config'] = config();

		set_exception_handler([$this, 'exceptionHandler']);
		set_error_handler([$this, 'errorHandler']);

		ini_set('display_errors', $this->config->get('cms.debug'));
		if($this->config->get('cms.debug'))
			error_reporting(E_ALL);
		else
			error_reporting(0);
	}

	public function Init(array $objects){
		array_map(function($alias, $object){
			$this->registry[$alias] = $object;
		}, array_keys($objects), $objects);	
	}

	public function __get($alias){
		return $this->registry[$alias];
	}

	public function redirect($location, $status = 302){
		header("HTTP/1.1 " . $status);
		header("Location: " . $location);
		exit;
	}

	public function deleteDir($dirname) {
		if (is_dir($dirname))
			$dir_handle = opendir($dirname);
		
		if (!$dir_handle)
			return false;

		while($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
			    if (!is_dir($dirname."/".$file))
		         	unlink($dirname."/".$file);
			    else
	         		$this->deleteDir($dirname.'/'.$file);
			}
		}
		closedir($dir_handle);
		rmdir($dirname);
		return true;
	}

	public function exceptionHandler($e){
		$debug = config('cms.debug');
		ob_start();
		include_once 'templates/exception.template.php';
		die(ob_get_clean());
	}

	public function errorHandler($errno, $errstr, $errfile, $errline, $errcontext ){
		$debug = config('cms.debug');
		ob_start();
		include_once 'templates/error.template.php';
		die(ob_get_clean());
	}
}