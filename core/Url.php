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
    
    public function set($url = null, $qs = [], $protocol = 'http'){
        $return_url = $protocol . '://' . $_SERVER['HTTP_HOST'];

        $component = router()->component()['name'];
        $def_component = config('components.default');

        $return_url .= $component == $def_component ? '' : '/' . $component;
        $return_url .= $url ? '/' . trim($url, '/') : '';

        if($qs)
            $return_url .= '?' . http_build_query($qs);

        return $return_url;
    
    }
}