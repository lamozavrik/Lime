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

class Url{

    use traits\Singleton;
    
    public function set($url, $qs = [], $protocol = 'http'){

        if($url)
            $segments = explode('/', trim($url, '/'));

        $return_url = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/';

        $def_component = config('components.default');
        $langs = lang()->installed_langs;

        if(isset($segments) && $segments){
            if(in_array($segments[0], $langs))
                array_shift($segments);

            if($segments[0] == $def_component)
                array_shift($segments);
        }

        if(isset($segments) && $segments)
            $return_url .= implode('/', $segments);

        if($qs){
            $return_url .= '?' . http_build_query($qs);
        }

        return $return_url;
    
    }
}