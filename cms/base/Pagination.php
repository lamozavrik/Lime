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

    public $links = 5;
    public $per_page = 10;
    public $total = 0;
    public $template;
    public $link = '';
    public $cur_page = 1;
    public $first_page = "&laquo;";
    public $last_page = "&raquo;";
    public $prev_page = "&larr;";
    public $next_page = "&rarr;";
    public $delimiter = ' ... ';

    protected $total_pages;
    protected $pagination = [];

    protected $prev_pagination = [];
    protected $next_pagination =[];

    public function __construct($view = 'pagination.tpl.php'){
        $this->template  = DIR_CMS . '/templates/' . $view;
    }

    public function render(){
        $this->link = urldecode($this->link);
        $this->total_pages = ceil($this->total/$this->per_page);

        if(!$this->cur_page || $this->cur_page < 1)
            $this->cur_page = 1;

        for($i=$this->cur_page-1; $i >= $this->cur_page-$this->links && $i > 0; $i--){
            array_unshift($this->pagination, [
                'link' => $i > 1 ? str_replace('{page}', $i, $this->link) : str_replace(['&page={page}', '?page={page}'], '', $this->link),
                'page' => $i,
                'cur_page' => false
            ]);
        }

        $this->pagination[] = [
            'link' => str_replace('{page}', $this->cur_page, $this->link),
            'page' => $this->cur_page,
            'cur_page' => true
        ];

        for($i=$this->cur_page+1; $i<=$this->cur_page+$this->links && $i <= $this->total_pages; $i++){
            $this->pagination[] = [
                'link' => str_replace('{page}', $i, $this->link),
                'page' => $i,
                'cur_page' => false
            ];
        }

        
        if($this->cur_page > 1 && $this->first_page){
            $this->prev_pagination[] = [
                'link' => str_replace(['&page={page}', '?page={page}'], '', $this->link),
                'page' => $this->first_page,
                'cur_page' => false
            ];
        }

        if($this->cur_page > 1 && $this->prev_page){
            $this->prev_pagination[] = [
                'link' => $this->cur_page-1 <= 1 ? str_replace(['&page={page}', '?page={page}'], '', $this->link) : str_replace('{page}', $this->cur_page-1, $this->link),
                'page' => $this->prev_page,
                'cur_page' => false
            ];
        }

        if($this->cur_page < $this->total_pages && $this->next_page){
            $this->next_pagination[] = [
                'link' => str_replace('{page}', $this->cur_page+1, $this->link),
                'page' => $this->next_page,
                'cur_page' => false
            ];
        }

        if($this->cur_page < $this->total_pages && $this->last_page){
            $this->next_pagination[] = [
                'link' => str_replace('{page}', $this->total_pages, $this->link),
                'page' => $this->last_page,
                'cur_page' => false
            ];
        }

        ob_start();
        include $this->template;
        return ob_get_clean();
    }

}