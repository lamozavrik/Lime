<?php
namespace core\Traits;

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

trait Singleton{

	private static $_instances = [];

	public static function instance($data = null){
		$class = get_class();
		if(!isset(self::$_instances[$class]) || !self::$_instances[$class])
			self::$_instances[$class] = new $class($data);

		return self::$_instances[$class];
	}

	private function __construct(){}
	private function __clone(){}
}