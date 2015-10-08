<?php
namespace core;

//Проверка на прямое обращение к файлу
if(!defined('LIMECMS'))
	exit("no LimeCMS!");

/**
* Lime CMS
* 
* Класс на основе Singleton
* 
* @author Сердюк Кирилл
* @since 0.1b
* @copyright Copyright (c) 2015 Сердюк Кирилл
*/

class Config{

	use traits\Singleton;

	/**
	 * @var private Array Масиив с конфигурационными данными
	 */
	public $config = [];

	public function __construct(){}

	/**
	 * Публичный метод для загрузки файлов конфигурации
	 * Синтаксис: $obj->load('config.cms');
	 * При успешном выполнении добавляет в массив с конф. данными значения
	 * с ключем названия файла, в данном примере ключем будет "cms".
	 * 
	 * @param string Строка ключ к конф. файла, например: $obj->load('config.cms');
	 * @return object $this
	 */
	public function load($config){
		//Получить ключ для записи в массив конф. данных, и путь к файлу с конф данными
		$path = str_replace('.', '/', $config);
		$config_key = basename($path);
		$config_file = DIR_CMS . '/' . $path . '.php';

		//Подключить конф. файл, если он существует. Иначе бросить исключение
		if(!file_exists($config_file))
			throw new \Exception("Файл " . $config_file . " не найден!");

		//Записать конф данные в переменную $config
		$config = include_once $config_file;

		//Если есть массив данных, то записать их в конф. массив с ключем $config_key
		if(is_array($config))
			$this->config[$config_key] = $config;

		return $this;
	}

	/**
	 * Публичный метод для загрузки значений конфигурации
	 * Синтаксис: $obj->get('cms.lang');
	 * 
	 * @param string Строка ключ к конф. файла: $obj->get('cms.lang');
	 * @return value значение
	 * */
	public function get($key){
		//Последовательность ключей конф массива
		$path = explode('.', $key);
		$value = null;
		
		//Получить конф данные по последовательности ключей. Если какой то ключ не существует, вернет null
		array_map(function($key) use(&$value){
			$find = false;
			if(isset($this->config[$key])){
				$value = $this->config[$key];
				$find = true;
			} 

			if(!$find){
				if(isset($value[$key])){
					$value = $value[$key];
				} else {
					$value = null;
					return;
				}
			}
			
			
		}, $path);
		
		return $value;
	}

	/**
	 * Публичный метод для установки значений конфигурации
	 * Синтаксис: $obj->get('cms.lang', $value);
	 * 
	 * @param string Строка ключ к конф. файла: $obj->get('cms.lang');
	 * @param mixed новое значения конфигурации
	 * @return boolean
	 * */
	public function set($key, $val){
		//Получить последовательность ключей для записи в массив конф. данных
		$path = explode('.', $key);
		$config = null;

		//Если последовательность ключей правильная, то пометь конф значение, иначе добавить новые значения
		foreach($path as $key){
			if(isset($this->config[$key])){
				$config = &$this->config[$key];
				$find = true;
				continue;
			} else {
				$config = &$config[$key];
				continue;
			}

		}

		$config = $val;

	}

	public function delete($key){
		$path = explode('.', $key);
		$config = null;
		$find = false;

		//Если последовательность ключей правильная, то пометь конф значение, иначе нет
		foreach($path as $key => $val){

			if(!isset($path[++$key]))
				break;

			if(isset($this->config[$val])){
				$config = &$this->config[$val];
				continue;
			} else {
				$config = &$config[$val];
				continue;
			}

			$config = null;
			break;

		}

		if($config)
			unset($config[$val]);

	}

	/**
	 * Публичный метод для сохранения конфигураций
	 * Синтаксис: $obj->save('cms.lang', $value);
	 * 
	 * @param string Строка ключ (путь) к конф. файла: $obj->get('config.cms');
	 * @return boolean
	 * */
	public function save($config){
		//Получить ключ для записи в массив конф. данных, и путь к файлу с конф данными
		$path = str_replace('.', '/', $config);
		$config_key = basename($path);
		$config_file = DIR_CMS . '/' . $path . '.php';

		//Получить данные для записи по ключу
		$config = $this->config[$config_key];

		//Загрузить шаблон конф файла
		$config_template = file_get_contents(DIR_ROOT . '/core/templates/config.template');

		//Формирование данных для записи в файл
		$new_config = "[" . PHP_EOL;
		$new_config .= $this->configWalk($config, 4, 1);
		$new_config .= "];" . PHP_EOL;

		//Замена тега шаблона на данные для записи
		$config_data = str_replace('{config}', $new_config, $config_template);

		//Записать файл
		if($config_data)
			file_put_contents($config_file, $config_data);
	}

	/**
	 * Приватный метод для формирования даныых, для записи в конф. файл
	 * 
	 * @param array массив с конф. данными
	 * @param int кол-во пробелов в табуляции изначально
	 * @param int кол-во рекурсивных прохождений метода
	 * @return string сформировання строка для записи в конф. файл
	 * */
	private function configWalk($config, $i, $s){

		//Строка для данных
		$string = null;

		//Пройтись в цикле по массиву конф. данных и сформировать строку
		//Конструкция str_repeat(" ", $i*$s) устанавливает табуляцию на основе кол-ва рекурсивных прохождений
		foreach($config as $key => $val){
			if(!is_array($val)) {
				if(!is_int($key))
					$string .= str_repeat(" ", $i*$s) . "'{$key}' => {$this->checkType($val)}," . PHP_EOL;
				else
					$string .= str_repeat(" ", $i*$s) . "{$this->checkType($val)}," . PHP_EOL;
			}

			//Если значение массив, то запустить метод рекурсивно
			if(is_array($val)){
				$string .= str_repeat(" ", $i*$s) . "'{$key}' => [" . PHP_EOL;

				$s++;
				foreach ($val as $k => $v) {
					
					if(is_array($v)){
						if(!is_int($k))
							$string .= str_repeat(" ", $i*$s) . "'{$k}' => [" . PHP_EOL;
						else
							$string .= str_repeat(" ", $i*$s) . "[" . PHP_EOL;

						//Рекурсивное прохождение
						$string .= $this->configWalk($v, $i, $s+1);
						$string .= str_repeat(" ", $i*$s) . "]," . PHP_EOL;
					} else {
						if(!is_int($k))
							$string .= str_repeat(" ", $i*$s) . "'{$k}' => {$this->checkType($v)}," . PHP_EOL;
						else
							$string .= str_repeat(" ", $i*$s) . "{$this->checkType($v)}," . PHP_EOL;
					}
					
				}
				$s--;
				$string .= str_repeat(" ", $i*$s) . "]," . PHP_EOL;
			}
		}
		
		return $string;
	}

	/**
	 * Приватный метод для проверки типа данных, для записи
	 * в конф файл
	 * 
	 * @param mixed данные для проверки
	 * @return mixed приведенные к нужному типу данные
	 * */
	private function checkType($val){

		if(is_array($val))
			return $val;

		if(is_int($val))
			return (int)$val;
		elseif(is_bool($val)){
			return $val ? 'true' : 'false';
		}
		else
			return "'{$val}'";

	}

}
