<?php
class View {
		
	public static function make($file, $data = array()) {
		Template::compile($file, $data);
    }
	
	public static function html($content) {
		$cache_location = CACHE_DIR . 'simple.tpl';		
	    if (!file_exists($cache_location) || Template::_glob_cache(THEMES_DIR . Config::get('theme') . '/*.*', $cache_location)) {
	    	$code = "@block('content'){{\$content}}@endblock";
			$code .= file_get_contents(THEMES_DIR . Config::get('theme') . '/master.tpl');
			$code = Template::compile_code($code);
			file_put_contents($cache_location, $code);
	    }
		include_once $cache_location;
	}
	
}
?>