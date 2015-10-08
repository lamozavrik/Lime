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

class Language{

	private $langs_dir;

	public $installed_langs;
	public $cur_lang = [];
	public $def_lang;

	use traits\Singleton;

	private function __construct(){
		$this->langs_dir = DIR_CMS . '/languages';
		$this->def_lang = config('cms.def_lang');
		$this->installed_langs = config('cms.langs');

		if(!isset($this->installed_langs[$this->def_lang['id']])){
			$this->createLanguage($this->def_lang['id'], $this->def_lang['locale'], $this->def_lang['name']);
		}

	}

	public function setLanguage($id){

		if(!isset($this->installed_langs[$id])){
			$this->cur_lang = [
				'id' => $this->def_lang['id'],
				'locale' => $this->installed_langs[$this->def_lang['id']]['locale'],
				'domain' => $this->installed_langs[$this->def_lang['id']]['domain'],
				'name' => $this->installed_langs[$this->def_lang['id']]['name']
			];
		} else {
			$this->cur_lang = [
				'id' => $id,
				'locale' => $this->installed_langs[$id]['locale'],
				'domain' => $this->installed_langs[$id]['domain'],
				'name' => $this->installed_langs[$id]['name']
			];
		}

		$this->setDomain();
	}

	private function setDomain(){
		if (!$locale = setlocale(LC_ALL, $this->cur_lang['locale'] . '.utf8', $this->cur_lang['locale'] . '.utf-8', $this->cur_lang['locale'] . '.UTF8', $this->cur_lang['locale'] . '.UTF-8', $this->cur_lang['locale'] . '.utf-8', $this->cur_lang['locale'] . '.UTF-8', $this->cur_lang['locale'])) {
            setlocale(LC_ALL, '');
        }
        
        putenv('LC_ALL=' . $this->cur_lang['locale']);
        putenv('LANG=' . $this->cur_lang['locale']);
        putenv('LANGUAGE=' . $this->cur_lang['locale']);

		bindtextdomain ($this->cur_lang['domain'], $this->langs_dir);
		textdomain ($this->cur_lang['domain']);
		bind_textdomain_codeset($this->cur_lang['domain'], 'UTF-8');
	}

	/**
	 * Create language
	 * 
	 * @param string id
	 * @param string locale
	 * @param string name
	 * */
	public function createLanguage($id, $locale, $name){
		
		$po_file = $this->langs_dir . '/' . $locale . '/LC_MESSAGES/' . $id . '_' . $this->def_lang['domain'] . '.po';
		$mo_file = $this->langs_dir . '/' . $locale . '/LC_MESSAGES/' . $id . '_' . $this->def_lang['domain'] . '.mo';
		
		$dir = $this->langs_dir . '/' . $locale . '/LC_MESSAGES/';

		if(!is_dir($dir))
			$this->createLanguageDir($dir);

		$files = $this->filesSearch(DIR_CMS, '/.*php/');
		$messages = $this->checkFiles($files);

		if(!file_exists($po_file)){
			$this->createPoFile($po_file, $messages, $locale);
			$lang_domen = $this->compileMo($po_file, $mo_file, $locale, $id);
			$this->saveLanguageToConfig($id, $locale, $name, $lang_domen);
		} else {
			$this->updateLanguage($id, $locale, $name);
		}

	}

	public function updateLanguage($id, $locale, $name = null){
		$lang_dir = $this->langs_dir . '/' . $locale . '/LC_MESSAGES';

		$po_file = $lang_dir . '/' . $id . '_' . $this->def_lang['domain'] . '.po';
		$mo_file = $lang_dir . '/' . $id . '_' . $this->def_lang['domain'] . '.mo';

		if(file_exists($po_file)){
			$files = $this->filesSearch(DIR_CMS, '/.*php/');
			$messages = $this->checkFiles($files);
			$isset_ids = $this->poToArray($po_file);
			foreach($isset_ids as $lang_id => $translate){
				if(isset($messages[$lang_id]))
					$messages[$lang_id]['translate'] = $translate;

			}
			$this->createPoFile($po_file, $messages, $locale);
			$lang_domen = $this->compileMo($po_file, $mo_file, $locale, $id);

			$this->saveLanguageToConfig($id, $locale, $name, $lang_domen);
		}

	}

	private function saveLanguageToConfig($id, $locale, $name, $lang_domen){
		if($locale)
			config()->set("cms.langs.{$id}.locale", $locale);

		if($name)
			config()->set("cms.langs.{$id}.name", $name);

		if($lang_domen)
			config()->set("cms.langs.{$id}.domain", "{$lang_domen}");

		config()->save();
	}

	public function deleteLanguage($id){

		if(!$lang = config()->get('cms.langs.' . $id))
			return false;

		$locale = isset($lang['locale']) ? $lang['locale'] : null;
		if(!$locale)
			return false;

		lime()->deleteDir($this->langs_dir . '/' . $locale);
		config()->delete('cms.langs.' . $id);
		config()->save('config.cms');
	}	

	private function createLanguageDir($dir){
		if(!is_dir($dir)){
			mkdir($dir, 0775, true);
		}
	}

	private function filesSearch($folder, $pattern){
		$dir = new \RecursiveDirectoryIterator($folder);
	    $ite = new \RecursiveIteratorIterator($dir);
	    $files = new \RegexIterator($ite, $pattern, \RegexIterator::GET_MATCH);
	    $fileList = array();
	    foreach($files as $file) {
	        $fileList = array_merge($fileList, $file);
	    }
	    return $fileList;
	}

	private function checkFiles($files){
		$return  = [];
		$pattern = "/.*(?:_\([\'\"]{1}(.*)[\'\"]{1}\)).*/iuU";

		foreach ($files as $file) {
			$line = 1;
			$search_file = $file;
			$file = str_replace(DIR_ROOT . '/', '', $file);
			$fh = fopen($search_file, 'r');
			while(!feof($fh)){
				$string = fgets($fh);
				if(preg_match_all($pattern, $string, $matches)){
					if(!$matches)
						continue;
					foreach($matches[1] as $id){
						if(!isset($return[$id])){
							$return[$id]['files'][$file][] = $line;
						}
						elseif(isset($return[$id])){
							if(isset($return[$id]['files'][$file])){
								if(!in_array($line, $return[$id]['files'][$file])){
									$return[$id]['files'][$file][] = $line;
								}
							} else {
								$return[$id]['files'][$file][] = $line;
							}
						}
						$return[$id]['translate'] = "";
					}
				}
				$line++;
			}
			fclose($fh);
		}
		return $return;
	}

	private function chekTranslates($po_file){
		$translates = $this->poToArray($po_file);
		return $translates;
	}

	private function createPoFile($file_name, $data, $locale){
		$fh = fopen($file_name, 'w+');
		$meta = file_get_contents(DIR_ROOT . '/core/templates/po.template');
		$meta = str_replace(['{date}', '{locale}'], [date("Y-m-d H:iO"), $locale], $meta);

		fwrite($fh, $meta);

		foreach($data as $id => $v){
			foreach($v['files'] as $file => $strings){
				fwrite($fh, '#: ' . $file . ':' . implode(', ', $strings) . PHP_EOL);
			}
			fwrite($fh, 'msgid "' . $id . '"' . PHP_EOL);
			fwrite($fh, 'msgstr "' . $v['translate'] . '"' . PHP_EOL . PHP_EOL);
		}

		fclose($fh);
	}

	private function compileMo($po_file, $mo_file, $locale, $id){
		
		$domain = $this->def_lang['domain'];
		//$filename = DIR_CMS . '/languages/' . $locale . '/LC_MESSAGES/' . $domain . '.mo';
		$filename = $mo_file;

		require_once DIR_LIBS . '/msgfmt/msgfmt-functions.php';
		$hash = parse_po_file($po_file);
		write_mo_file($hash, $filename);

		if (file_exists($filename)){
			$mtime = filemtime($filename); 
			$new_revision = $id . '_' . $domain . '_' . $mtime;
			$filename_new = DIR_CMS . '/languages/' . $locale . '/LC_MESSAGES/' . $new_revision . '.mo'; 
		} 

		if(!file_exists($filename_new)) {
			array_map("unlink", glob(DIR_CMS . '/languages/' . $locale . '/LC_MESSAGES/*_' . $domain . '_' . '*.mo'));
			copy($filename, $filename_new); 
		}
		unlink($filename);
		return $new_revision;
	}

	private function poToArray($po_file){
		require_once DIR_LIBS . '/File/Gettext.php';
		$po = \File_Gettext::factory('PO');
		$po->load($po_file);
		return $po->toArray()['strings'];
	}

}