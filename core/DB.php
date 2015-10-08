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

class DB{

    private $link;

    private $stms;

    public static function factory($connect_name){

        return new self($connect_name);
        
    }

    private function __construct($connect_name){
        $config = require_once DIR_CMS . '/config/database.php';

        $config = $config[$connect_name];

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        $dsn = 'mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'] . ';charset=' . $config['charset'];
        $this->link = new PDO($dsn, $config['db_user'], $config['db_pass'], $options);
    }

    public function prepare($sql){
        $this->stmt = $this->link->prepare($sql);
        return $this;
    }

    public function execute($args = []){
        $this->stmt->execute($args);
        return $this;
    }

    public function fetch(){
        return  $this->stmt->fetch();
    }

    public function fetchAll(){
        return  $this->stmt->fetchAll();
    }

    public function rows(){
        return  $this->stmt->rowCount();
    }

    public function bindValue($parametr, $value, $data_type = PDO::PARM_STR){
        $this->stmt->bindValue($parametr, $value, $data_type);
        return $this;
    }

}