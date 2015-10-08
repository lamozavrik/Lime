<?php
/**
* Lime CMS
* 
* @author Сердюк Кирилл
* @since 0.1b
* @copyright Copyright (c) 2015 Сердюк Кирилл
*/

//Установка кодировки
header("Content-type:text/html; Charset=utf-8");

session_start();

//Проверка версии php
if(version_compare(PHP_VERSION, '5.4', '<'))
	exit("Версия PHP должна быть не меньше 5.4");

//Защита от прямого обращения к скриптам
define('LIMECMS', true);

//Проверка на прямое обращение к файлу
if(!defined('LIMECMS'))
	exit("no LimeCMS!");

//Установка коренного каталога
define("DIR_ROOT", str_replace('\\', '/', dirname(__FILE__)));
define("DIR_LIBS", DIR_ROOT . '/libs');
define("DIR_CMS", DIR_ROOT . '/cms');

//основной автоподгрузчик классов и трейтов
function autoload($class_name){
	$path = str_replace('\\', '/', $class_name);
	$file = DIR_ROOT . '/' . $path . '.php';
	
	if(!file_exists($file))
		throw new Exception('Файл ' . $file . ' не существует!');

	include $file;		
}

//Регистрация основного автозагрузчика
spl_autoload_register('autoload');

include_once DIR_ROOT . '/core/helpers/lime.php';

//Подключения основного класса CMS
require DIR_ROOT . '/core/Lime.php';

//Создание и запуск приложения
lime()->init([
	'request' 	=> request(),
	'lang'	=> lang(),
	'router' => router(),
	'cache' => core\Cache::factory(config('cache.driver'))
]);

router()->run();

