<?php

if (isset ($_SERVER['ORIG_PATH_INFO']) && $_SERVER['ORIG_PATH_INFO'] != $_SERVER['PHP_SELF']) {
	$_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'];
}

if (!empty ($_SERVER['PATH_INFO']) && strrpos ($_SERVER['PHP_SELF'], $_SERVER['PATH_INFO'])) {
	$_SERVER['PHP_SELF'] = substr ($_SERVER['PHP_SELF'], 0, -(strlen ($_SERVER['PATH_INFO'])));
}

define('IN_MVC', true);
define('ROOT_DIR', realpath(dirname(__FILE__)));
define('CORE_DIR', ROOT_DIR . '/core/');
define('THEMES_DIR', ROOT_DIR . '/themes/');
define('CACHE_DIR', ROOT_DIR . '/cache/');
define('MODULES_DIR', ROOT_DIR . '/modules/');

include_once CORE_DIR . 'init.php';

?>