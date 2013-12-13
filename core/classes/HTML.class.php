<?php
class HTML {
	
	public static function link($url, $title = NULL, $options = array()) {
		$array = explode('/', $url);
		$string = '';
		foreach ($array as $key => $value) {
			$string .= ($key % 2) ? '=' . $value : (($key == 0) ? $value : '&' . $value);
		}
		$url = '<a href="index.php?' . $string . '"' . self::_options($options) . '>' . (is_null($title)?(isset($array[3])?$array[3]:$array[1]):$title) . '</a>';
		return $url;
	}
	
	public static function image($image, $options = array()) {
		return '<img src="themes/' . Config::get('theme') . '/images/' . $image . '"' . self::_options($options) . '>';
	}
	
	public static function style($css, $options = array()) {
		return '<link href="themes/' . Config::get('theme') . '/css/' . $css . '" rel="stylesheet" type="text/css"' . self::_options($options) . '>';
	}
	
	public static function script($script, $options = array()) {
		return '<script src="themes/' . Config::get('theme') . '/scripts/' . $script . '"' . self::_options($options) . '></script>';
	}
	
	public static function theme($file) {
		return 'themes/' . Config::get('theme') . '/' . $file;
	}
	
	public static function redirect($module, $action = NULL) {
		return header('Location: ' . (($action == NULL) ? 'index.php?page=' . $module : 'index.php?page=' . $module . '&action=' . $action));
	}
	
	public static function encode($string) {
	    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
	}
	
	private static function _options($options = array()) {
		$options_string = '';
		foreach ($options as $key => $option) {
			$options_string .= ' ' . $key . '="' . $option . '"';
		}
		return $options_string;
	}
	
}
?>