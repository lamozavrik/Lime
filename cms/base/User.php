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

class User{

    use \core\traits\Singleton;

    public $id;
    public $login;
    public $name;
    public $email;
    public $group;

    private function __construct(){
        if(isset($_SESSION['user_id'])){

            $user_id = $_SESSION['user_id'];
            $user = db("SELECT * FROM users WHERE id = ? AND active = 1 LIMIT 1")->execute([$user_id]);

            if($user->rows()){

                $user = $user->fetch();

                $group = db("SELECT * FROM user_groups WHERE id = ? LIMIT 1")->execute([$user->group_id])->fetch();
                $group->permissions = unserialize($group->permissions);

                $this->id = $user->id;
                $this->login = $user->login;
                $this->name = $user->name;
                $this->email = $user->email;
                $this->group = $group;

            } 
        } 
    }

    public function isLogin(){
        return $this->id ? true : false;
    }

    public function register(){

    }

    public function login($email, $pass){

        $user = db("SELECT * FROM users WHERE email = ? AND active = 1 LIMIT 1")->execute([$email]);

        if($user->rows()){

            $user = $user->fetch();
            if($user->password !== crypt($pass, $user->password))
                return false;

            $group = db("SELECT * FROM user_groups WHERE id = ? LIMIT 1")->execute([$user->group_id])->fetch();
            $group->permissions = unserialize($group->permissions);

            $this->id = $user->id;
            $this->login = $user->login;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->group = $group;

            $_SESSION['user_id'] = $this->id;
            return true;

        } else {
            return false;
        }

    }

    public function logout(){
        unset($_SESSION['user_id']);
        $this->id = null;
        $this->login = null;
        $this->name = null;
        $this->email = null;
        $this->group = null;
    }

}