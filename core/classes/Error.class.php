<?php
Class Error {
	public static function init() {
		error_reporting( E_ALL );
		set_error_handler('Error::handler');
		register_shutdown_function('Error::shutdown_handler');
		if(Config::get('errors.log')) {
			ini_set('log_errors', 1);
			ini_set('error_log', Config::get('errors.log.path'));
		}
	}
	public static function handler($errno, $errstr, $errfile, $errline) {
	    error_log("Error: [$errno] $errstr - $errfile:$errline");
	    if(Config::get('errors.display') == FALSE) {
		    echo 'Looks like something has broke, please contact the Administrator.';
			exit();
		}
		echo "<b>Error:</b> [$errno] $errstr - $errfile:$errline";
		exit();
	}
	public static function shutdown_handler() {
	  	$last_error = error_get_last();
	  	if ($last_error['type'] === E_ERROR) {
	    	self::handler(E_ERROR, $last_error['message'], $last_error['file'], $last_error['line']);
		}
	}
}
?>
