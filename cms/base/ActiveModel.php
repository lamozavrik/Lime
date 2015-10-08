<?php
namespace cms\base;

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

use \Lime;

class ActiveModel{

    public static function factory($model, $id){
        $class = '\\cms\\' . $model;
        return (new $class())->get($id);
    }

    protected $_table;
    protected $_foreign;
    protected $_has_one = [];
    protected $_has_many = [];

    public function __construct(){
        $class_name = get_class($this);
        $this->_table = basename(str_replace('\\', '/', $class_name));
        //$this->_foreign = $this->_table . '_id';
        if(substr($this->_table, -1) == 'y')
            $this->_table = substr_replace($this->_table, 'ies', -1);
        else{
            $this->_table .= 's';
        }

    }

    public function get($id){
        $class_name = get_class($this);
        $sql = "SELECT * FROM `{$this->_table}` WHERE id = :id LIMIT 1";
        Lime::instance()->db->query($sql, ['id' => $id]);
        Lime::instance()->db->setClass($class_name);
        return Lime::instance()->db->fetch();
    }

    public function __get($key){
        if(in_array($key, $this->_has_one)){
            return self::factory($key, $this->{$this->_foreign});
        }

        if(in_array($key, $this->_has_many)){

            $table = basename($key);
            if(substr($key, -3) == 'ies'){
                $model = '\\cms\\' . substr_replace($key, 'y', -3);
             } else {
                $model = '\\cms\\' . substr_replace($key, '', -1);
             }

             $model = new $model();
             $sql = "SELECT * FROM `{$table}` WHERE " . $this->_foreign . " = :id";
             $model->sql = $sql;
             $model->foreign_id = $this->id;
             return $model;

        }
    }

    public function limit($limit, $offset = false){
        if($offset === false){
            $this->sql .= " LIMIT " . (int)$limit;
        }
        else{
            $this->sql .= " LIMIT " . (int)$offset . ", " . (int)$limit;
        }
        return $this;
    }

    public function all(){
        $stmt = Lime::instance()->db->run($this->sql);
        $stmt->bindValue(":id", $this->foreign_id, \PDO::PARAM_INT);
        Lime::instance()->db->setClass('\\' . get_class($this));
        $stmt->execute();
        return Lime::instance()->db->all();
    }

}