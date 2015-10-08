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

class Config{

    use traits\Singleton;

    /**
     * @var private Array Масиив с конфигурационными данными
     */
    public $config = [];

    public function load($config){
        $this->config = $config;
    }

    /**
     * Публичный метод для загрузки значений конфигурации
     * Синтаксис: $obj->get('cms.lang');
     * 
     * @param string Строка ключ к конф. файла: $obj->get('cms.lang');
     * @return value значение
     * */
    public function get($key){
        //Последовательность ключей конф массива
        $path = explode('.', $key);
        $value = null;
        
        //Получить конф данные по последовательности ключей. Если какой то ключ не существует, вернет null
        array_map(function($key) use(&$value){
            $find = false;
            if(isset($this->config[$key])){
                $value = $this->config[$key];
                $find = true;
            } 

            if(!$find){
                if(isset($value[$key])){
                    $value = $value[$key];
                } else {
                    $value = null;
                    return;
                }
            }
            
            
        }, $path);
        
        return $value;
    }

    /**
     * Публичный метод для установки значений конфигурации
     * Синтаксис: $obj->get('cms.lang', $value);
     * 
     * @param string Строка ключ к конф. файла: $obj->get('cms.lang');
     * @param mixed новое значения конфигурации
     * @return boolean
     * */
    public function set($key, $val){
        //Получить последовательность ключей для записи в массив конф. данных
        $path = explode('.', $key);
        $config = null;

        //Если последовательность ключей правильная, то пометь конф значение, иначе добавить новые значения
        foreach($path as $key){
            if(isset($this->config[$key])){
                $config = &$this->config[$key];
                $find = true;
                continue;
            } else {
                $config = &$config[$key];
                continue;
            }

        }

        $config = $val;

    }

    public function delete($key){
        $path = explode('.', $key);
        $config = null;
        $find = false;

        //Если последовательность ключей правильная, то пометь конф значение, иначе нет
        foreach($path as $key => $val){

            if(!isset($path[++$key]))
                break;

            if(isset($this->config[$val])){
                $config = &$this->config[$val];
                continue;
            } else {
                $config = &$config[$val];
                continue;
            }

            $config = null;
            break;

        }

        if($config)
            unset($config[$val]);

    }

    /**
     * Публичный метод для сохранения конфигураций
     * Синтаксис: $obj->save('cms.lang', $value);
     * 
     * @param string Строка ключ (путь) к конф. файла: $obj->get('config.cms');
     * @return boolean
     * */
    public function save(){
        return db()->prepare("UPDATE settings SET config = ?")->execute([serialize($this->config)]);
    }

}
