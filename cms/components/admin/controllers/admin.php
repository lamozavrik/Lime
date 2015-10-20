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
        
        \core\View::addCss('style');
        \core\View::addJs('menu');
        \core\View::addJs('tabs');

        if($this->user->isLogin())
            $this->run();

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

    protected function run(){
        if(!$this->route)
            $this->route = 'main';

        $method = 'index';

        $file = 'cms/components/admin/controllers';
        $segments = explode('/', $this->route);

        foreach($segments as $key => $segment){
            $file .= '/' . $segment;
            unset($segments[$key]);

            if(file_exists($file . '.php'))
                break;

        }

        if($segments)
            $method = array_shift($segments);

        $class = str_replace('/', '\\', $file);
        if(!class_exists($class)){
            return (new error())->index(_('Ошибка!'), _('Доступ запрещен!'), 404);
        }

        $permission = $class . '::' . $method;
        if(!in_array($permission, $this->user->group->permissions))
            return (new error())->index(_('Ошибка!'), _('Доступ запрещен!'));
        
        return (new $class())->$method();
        
    }


}