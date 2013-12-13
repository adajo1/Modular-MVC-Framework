<?php
class Modules {
	
	public static $list = array();
	
	public static function init() {
		foreach (glob(MODULES_DIR . '*', GLOB_ONLYDIR) as $mod) {
			array_push(self::$list, preg_replace('/(.*)modules\/(.*)/', '$2', $mod));
		}
	}
	
	public static function include_libs() {
		foreach (glob(MODULES_DIR . '*/lib/*.php') as $mod) {
			$module = preg_replace('/(.*)modules\/(.*)\/lib\/(.*)/', '$2', $mod);
			if (strpos($mod,'.class.php') == FALSE) {			
				include_once $mod;
			}
		}	
	}
	
	public static function module_exists($module) {
		return in_array($module, self::$list);
	}
	
	public static function load($module, $data = array(), $visible = TRUE) {
		if(!self::module_exists($module) || !file_exists(MODULES_DIR . $module . '/controller.php')) {
			self::load('home', $data, $visible);
			return;
		}
		if($visible) Config::set('in_module', $module);	
		include_once MODULES_DIR . $module . '/controller.php';
		if(class_exists(ucfirst($module) . 'Controller')) {
			$module_controller = ucfirst($module) . 'Controller';
			$controller = new $module_controller($data, $visible);
		}
		return $controller;
	}
	
}
?>