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

use \PDO;
use \PDOException;
use \Exception;
use \Lime;

class DB{

    private $link;

    private $_prepare = null;

    public function __construct($connect_name){

        $config = Lime::instance()->config;
        $config->load('config.database');

        $config = $config->get('database.' . $connect_name);

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        $dsn = 'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'] . ';charset=' . $config['charset'];
        $this->link = new PDO($dsn, $config['db_user'], $config['db_pass'], $options);
        
    }

    public function query($sql, $data = []){
        $this->_prepare = $this->link->prepare($sql);

        if($data){
            array_map(function($k, $v){
                if(is_int($v))
                    $this->_prepare->bindValue(':' . $k, $v, PDO::PARAM_INT);
                else
                    $this->_prepare->bindValue(':' . $k, $v);
            }, array_keys($data), $data);
        }

        $this->_prepare->execute();
        return $this->_prepare;
    }

    public function queryIn($sql, $data){
        $sql = str_replace('{in}', implode(', ', array_fill(0, count($data), '?')), $sql);
        return $this->query($sql, $data);
    }

    public function fetch(){
        if($this->_prepare)
            return $this->_prepare->fetch();
        else
            return false;
    }

    public function all(){
        if($this->_prepare)
            return $this->_prepare->fetchAll();
        else
            return false;
    }

    public function setClass($class_name){
        if($class_name)
            $this->_prepare->setFetchMode(PDO::FETCH_CLASS, $class_name);
    }

    public function run($sql, $data = []){
        $this->_prepare = $this->link->prepare($sql);

        if(!$data)
            return $this->_prepare;

        foreach($data as $k => $v){
            $this->_prepare->execute($v);
        }

        $this->_prepare = null;
    }

    public function lastId(){
        return $this->link->lastInsertId();
    }
    
}