<?php
namespace core;

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

class View{
    
    private static $_css = array();
    private static $_js = array();
    private static $_afterJs = array();
    private static $_meta = [];
    private static $_page_title;

    private $template_dir;
    private $_data = array();
    private $_view;
    
    public static function factory($view, $data = []){
        return new self($view, $data);
    }
    
    public function __construct($view, $data = []){

    	$this->template_dir = DIR_CMS . '/templates/' . config('cms.template');
        $this->_view = $this->template_dir . '/' . $view . '.tpl.php';
        
        if(!file_exists($this->_view))
            throw new \Exception('Файл шаблона '  . $this->_view . ' не найден');   

        $this->_data = $data; 
    }
    
    public function set($key, $val){
        $this->_data[$key] = $val;
        return $this;
    }
    
    public function __set($key, $val){
        $this->set($key, $val);
    }
    
    public function __get($key){
        return isset($this->_data[$key]) ? $this->_data[$key] : null;
    }
    
    public function render($data = []){
    	if($data)
    		$this->_data = array_merge($this->_data, $data);

        ob_start();
        //extract($this->_data, EXTR_SKIP | EXTR_REFS);
        include $this->_view;
        return ob_get_clean();
    }
    
    public function addCss($cssFile){
        self::$_css[] = $cssFile;
    }
    
    public function addJs($jsFile, $after = false){
    	if(!$after)
        	self::$_css[] = $jsFile;
        else
        	self::$_afterJs[] = $jsFile;
    }
    
    public function styles(){
        return self::$_css;
    }
    
    public function javascript($after = false){
    	if(!$after)
        	return self::$_js;
        else
        	return self::$_afterJs;
    }

    public static function setPageTitle($title = ''){
        self::$_page_title = $title;
    }

    public static function setMeta($meta = []){
        self::$_meta = array_merge(self::$_meta, $meta);
    }

    public static function debug(){
        var_dump(self::$_meta);
    }
}