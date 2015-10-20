<?php
namespace cms\components\admin\controllers;

use cms\base\BaseController;
use \Lime;

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

class BaseAdmin extends BaseController{

    protected $route;
    protected $settings;

    public function __construct(){

        parent::__construct();
        config()->set('cms.template', 'admin');

        if(!$this->user->isLogin()){
           return $this->login();
        }

        $this->user->group->permissions = [
            'cms\\components\\admin\\controllers\\admin',
            'cms\\components\\admin\\controllers\\administrator\\administrator::index',

            'cms\\components\\admin\\controllers\\administrator\\clients::index',
            'cms\\components\\admin\\controllers\\administrator\\clients::create',
            'cms\\components\\admin\\controllers\\administrator\\clients::remove',
            'cms\\components\\admin\\controllers\\administrator\\clients::edit',
        ];

        if(!in_array('cms\\components\\admin\\controllers\\admin', $this->user->group->permissions))
            $this->logout();

        if(config('components.default') == 'admin' && request()->segment(1) == 'admin')
            lime()->redirect(url());
        
        // if(config('components.default') != 'admin' && request()->segment(1) != 'admin'){
        //    request()->setStatus(404);
        //    lime()->redirect('errors', request()->status());
        // }

        if(db("SELECT settings FROM components WHERE name = 'admin'")->execute())
            $this->settings = unserialize(db()->fetch()->settings);

        $this->route = request()->get('r');

    }

}