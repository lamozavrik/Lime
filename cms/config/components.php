<?php
/**
* Lime CMS
* 
* @author Сердюк Кирилл
* @since 0.1b
* @copyright Copyright (c) 2015 Сердюк Кирилл
*/

//Проверка на прямое обращение к файлу
if(!defined('LIMECMS'))
	exit("no LimeCMS!");

return [
    'default' => 'page',
    'installed' => [
        'page' => [
            'name' => 'pages',
            'url_access' => true,
            'path' => 'pages/controllers/pages',
        ],
        'errors' => [
            'name' => 'errors',
            'path' => 'errors/controllers/errors',
            'url_access' => false,
        ],
        'admin' => [
            'name' => 'admin',
            'path' => 'admin/controllers/admin',
            'url_access' => true,
        ],
    ],
];
