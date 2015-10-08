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
    'langs' => [
        'ru' => [
            'locale' => 'ru_RU',
            'name' => 'Русский',
            'domain' => 'ru_language_1443378441',
        ],
        'ua' => [
            'locale' => 'uk_UA',
            'name' => 'Українська',
            'domain' => 'ua_language_1443378441',
        ],
    ],
    'def_lang' => [
        'id' => 'ru',
        'locale' => 'ru_RU',
        'name' => 'Русский',
        'domain' => 'language',
    ],
    'template' => 'lime',
    'debug' => true,
    'log_errors' => false,
    'base_url' => 'cms.local'
];
