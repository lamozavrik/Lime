<?php
namespace cms\components\admin\controllers;

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

class admin extends BaseAdmin{

    public function index(){

        $this->checkPermission();
        //$this->logout();
        \core\View::addJs('menu');
        if($this->route){

        }

        echo pagination()->render();
        \core\View::addCss('style');
        $this->render();

    }

    public function login(){

        if($this->user->isLogin()){
            lime()->redirect(url());
        }

        if(request()->isPost()){
            if($this->user->login(request()->post('email'), request()->post('password'))){
                lime()->redirect(url());
            }
        }

        $this->setLayout(null);
        $this->data['post_url'] = url('login');

        $this->render('login');

    }

    public function logout(){
        $this->user->logout();
        lime()->redirect(url('login'));
    }


}