<?php
class db {
	
	public static $connection;
	public static $query_count = 0;
	
	public static function connect() {
		self::$connection = new mysqli(Config::get('connection.host'), Config::get('connection.username'), Config::get('connection.password'), Config::get('connection.database'));
		if (self::$connection->connect_errno > 0) {
		    die('Unable to connect to database!');
		}
	}
	
	public static function query() {
		$args = func_get_args();
		$stmt = self::$connection->stmt_init();
		$stmt->prepare($args[0]) or die ('Unable to prepare statement!');
		if (count($args) > 1) {
			$bind = array();
			$types = '';
			for ($arg=0;$arg<count($args);$arg++) {
				if ($arg == 0) continue;	
				$types .= self::_gettype($args[$arg]);
				array_push($bind, $args[$arg]);
			}			
			array_unshift($bind, $types);
			call_user_func_array(array($stmt,'bind_param'), self::_pass_by_reference($bind));
		}
		if ($stmt->execute()) {
			self::$query_count++;
			return $stmt;
		} else {
			die ('Unable to prepare statement!');
		}
	}
	
	private static function _gettype($var) {
	    if(is_string($var)) return 's'; 
	    if(is_double($var)) return 'd'; 
	    if(is_int($var)) return 'i'; 
	    return 'b'; 
	}
	
	private static function _pass_by_reference($arr) {
	    $refs = array();
	    foreach($arr as $key => $value) {
	        $refs[$key] = &$arr[$key];
		}
	    return $refs;	
	}
	
}
?>