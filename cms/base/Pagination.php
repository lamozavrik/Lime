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

class Pagination{

    public $links = 10;
    public $per_page = 10;
    public $total = 0;
    public $template = DIR_CMS . '/templates/pagination.tpl.php';

    public function render(){

    }

}