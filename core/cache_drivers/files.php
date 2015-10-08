<?php
namespace core\cache_drivers;

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

class files{

    use \core\traits\Singleton;

    private $config;
    private $path;

    public function __construct(){

        $this->config = \core\Config::instance()->get('cache');
        $this->path = DIR_CMS . '/cache';

        if(!is_dir($this->path))
            mkdir($this->path, 0775);
        
    }

    public function set($key, $val){
        if(!$this->config['lifetime'])
            return false;
        
        $cache_file = $this->path . '/' . md5($key) . '.cache';
        file_put_contents($cache_file, serialize($val));
    }
    public function get($key){
        $cache_file = $this->path . '/' . md5($key) . '.cache';

        if(!file_exists($cache_file))
            return false;

        if($this->config['lifetime'] > 0 && (time() - $this->config['lifetime']) > filemtime($cache_file)){
            $this->delete($key);
            return false;
        } else {
            return unserialize($cache_file);
        }
    }

    public function delete($key){

        $cache_file = $this->path . '/' . md5($key) . '.cache';

        if(file_exists($cache_file)){
            unlink($cache_file);
        }    

        return;

    }

}
