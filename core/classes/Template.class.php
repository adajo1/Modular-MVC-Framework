<?php
class Template {
	
	private static $blocks = array();
	
	public static function compile($file, $data) {
		$cached = self::cache(MODULES_DIR . Config::get('in_module') . '/views/' . $file, 'modules.' . Config::get('in_module'), $data);
	    extract($data, EXTR_SKIP);
	    include_once $cached;
	}	
	
	public static function cache($file, $prefix = '', $data = NULL) {
	    $file_info = pathinfo($file);
	    $cache_location = CACHE_DIR . $prefix . '.' . $file_info['basename'];		
	    if (	
    		!file_exists($cache_location) || 
    		filemtime($cache_location) < filemtime($file) || 
    		self::_glob_cache(THEMES_DIR . Config::get('theme') . '/*.*', $cache_location) ||
    		self::_glob_cache(MODULES_DIR . Config::get('in_module') . '/views/*.*', $cache_location)
		) {
			$list = self::__include_files($file);
			$code = self::merge($list);		
			$code = self::compile_code($code, $data);
	        file_put_contents($cache_location, $code);
	    }
		return $cache_location;		
	}
	
	public static function merge($files) {
		$code = '';
		foreach ($files as $file) {
			$code .= file_get_contents($file);
		}
		return $code;
	} 
	
	public static function compile_code($code, $data = NULL) {
		$code = trim(preg_replace('/\s+/S', ' ', $code));
		$code = self::_compile_section($code, $data);
		$code = self::_compile_block($code);
		$code = self::_compile_yield($code);
		$code = self::_compile_escaped_echos($code);
		$code = self::_compile_echos($code);
		$code = self::_compile_php($code);
		$code = self::_compile_remove($code);
		return $code;		
	}
	
	public static function _glob_cache($dir, $file_cache) {
		foreach (glob($dir) as $file) {
		    if(filemtime($file_cache) < filemtime($file)) {
		    	return TRUE;
		    }
		}
		return FALSE;
	}

	private static function __include_files($file) {
		$files = array();
		$code = file_get_contents($file);
		preg_match_all('/@extends\(\'(.*?)\'\)/i', $code, $matches, PREG_SET_ORDER);
		preg_match_all('/@include\(\'(.*?)\'\)/i', $code, $matches2, PREG_SET_ORDER);
		foreach ($matches as $value) {
			array_push($files, THEMES_DIR . Config::get('theme') . '/' . $value[1]);
		}
		foreach ($matches2 as $value) {
			array_push($files, MODULES_DIR . Config::get('in_module') . '/views/' . $value[1]);
		}
		array_push($files, $file);
		return $files;		
	}
	
	private static function _compile_remove($code) {
		$code = preg_replace('/@extends\(\'(.*?)\'\)/i', '', $code);
		$code = preg_replace('/@include\(\'(.*?)\'\)/i', '', $code);
		$code = preg_replace('/@yield( |)\((\'|")(.*?)(\'|")\)/i', '', $code);			
		return $code;
	}
	
	private static function _compile_php($code) {
		$code = preg_replace('~\{%\s*(.+?)\s*\%}~', '<?php $1 ?>', $code);	
		return $code;
	}
	
	private static function _compile_echos($code) {
		$code = preg_replace('~\{{\s*(.+?)\s*\}}~', '<?php echo $1 ?>', $code);	
		return $code;
	}

	private static function _compile_escaped_echos($code) {
		$code = preg_replace('~\{{{\s*(.+?)\s*\}}}~', '<?php echo HTML::encode($1, ENT_QUOTES) ?>', $code);	
		return $code;
	}
	
	private static function _compile_block($code) {
		preg_match_all('/@block\(\'(.*?)\'\)(.*?)@endblock/is', $code, $matches, PREG_SET_ORDER);
		foreach ($matches as $value) {
			if (!array_key_exists($value[1], self::$blocks)) self::$blocks[$value[1]] = '';
			if (strpos($value[2], '@parent') === false) {			
				self::$blocks[$value[1]] = $value[2];
			} else {
				self::$blocks[$value[1]] = str_replace('@parent', self::$blocks[$value[1]], $value[2]);
			}
			$code = str_replace($value[0], '', $code);
		}	
		return $code;	
	}
	
	private static function _compile_section($code, $data = NULL) {
		$php = '<?php if(isset($section)&&$section==\'$1\'): ?>$2<?php endif; ?>';
		$code = preg_replace('/@section\(\'(.*?)\'\)(.*?)@endsection/is', $php, $code);
		return $code;	
	}
	
	private static function _compile_yield($code) {
		foreach(self::$blocks as $block => $value) {
			$code = preg_replace('/@yield( |)\((\'|")' . $block . '(\'|")\)/', $value, $code);	
		}
		return $code;	
	}
	
}
?>