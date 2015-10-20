<?php
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

function lime($key = null){
    if(!$key)
        return Lime::instance();

    return Lime::instance()->{$key};
}

function lang(){
    return \core\Language::instance();
}

function config($key = null){
    if(!$key)
        return \core\Config::instance();

    return \core\Config::instance()->get($key);
}

function request(){
    return \core\Request::instance();
}

function router(){
    return \core\Router::instance();
}

function db($sql = null){
    if(!$sql)
        return lime('db');

    return lime('db')->prepare($sql);
}

function cache($key = null){
    if(!$key)
        return lime('cache');

    return lime('cache')->get($key);
}

function url($url = null, $qs = [], $protocol = 'http'){
    return \core\Url::instance()->set($url, $qs, $protocol);
}

function view($view, $data = []){
    return new \core\View($view, $data);
}
