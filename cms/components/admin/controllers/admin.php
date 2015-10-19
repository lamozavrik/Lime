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

        $pagination = pagination();
        $pagination->link = url('admin', [
            'page' => '{page}'
        ]);
        $pagination->total = 200;
        $pagination->cur_page = request()->get('page', FILTER_SANITIZE_NUMBER_INT);

        $this->data['pagination'] = $pagination->render();
        \core\View::addCss('style');
        $this->render();

    }

    public function login(){

        if($this->user->isLogin()){
            lime()->redirect(url('admin'));
        }

        if(request()->isPost()){
            if($this->user->login(request()->post('email', FILTER_VALIDATE_EMAIL), request()->post('password'))){
                lime()->redirect(url('admin'));
            }
        }

        $this->setLayout(null);
        $this->data['post_url'] = url('admin/login');

        $this->render('login');

    }

    public function logout(){
        $this->user->logout();
        lime()->redirect(url('admin/login'));
    }


}