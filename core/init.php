<?php

$profiler_start = microtime(true);
$profiler_memory = memory_get_usage();

defined('IN_MVC') or exit;

include_once CORE_DIR . 'funcs.php';
include_once CORE_DIR . 'classes/Config.class.php';
Config::load();

include_once CORE_DIR . 'classes/Error.class.php';
Error::init();

session_start();

include_once CORE_DIR . 'classes/Autoload.class.php';
include_once CORE_DIR . 'classes/Database.class.php';

Autoload::register(array(
	'core' 		=> CORE_DIR . 'classes/',
	'module' 	=> MODULES_DIR . '{config.in_module}' .  '/models/'
));

Modules::include_libs();

if(isset($_GET['page'])) {
	Modules::load($_GET['page']);
} else {
	Modules::load('home');	
}

$profiler_end = microtime(true);
$profiler_time = round($profiler_end * 1000) - round($profiler_start * 1000);
$profiler_memory =  determine_memory_size(memory_get_usage()-$profiler_memory);

if (Config::get('profiler') == true) {
	echo profiler(array( 
		'Page load time:' 	=> $profiler_time . 'ms', 
		'Memory Usage:' 	=> $profiler_memory
	));
}

?>