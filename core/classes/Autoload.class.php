<?php
class Autoload {
		
	public static $directories = array();
		
	public static function register($files) {
		self::$directories = array_merge($files, self::$directories);
		spl_autoload_register('self::load');
	}

	public static function load($class) {
		foreach (self::$directories as $path) {
			preg_match_all('/{config.(.*?)}/', $path, $matches, PREG_SET_ORDER);
			foreach ($matches as $value) {
				$path = str_replace($value[0], Config::get($value[1]), $path);
			}
			if (file_exists($path . $class . '.class.php')) {	
				include_once $path . $class . '.class.php';
				if (method_exists($class, 'init')) $class::init();
				return TRUE;
			}
		}
		foreach (glob(MODULES_DIR . '*/lib/' . $class . '.class.php') as $mod) {
			$module = preg_replace('/(.*)modules\/(.*)\/lib\/(.*)/', '$2', $mod);
			if (!Modules::is_active($module)) continue;		
			include_once $mod;
			if (method_exists($class, 'init')) $class::init();
			return TRUE;
		}
		return FALSE;
	}
	
}
?>