<?php
class Config {

    public static $config = array();

    public static function load()
    {
        self::$config = include_once(ROOT_DIR . '/core/config.php');
    }

    public static function get($key)
    {
    	return self::$config[$key];
    }
	
    public static function set($key, $value)
    {

    	self::$config[$key] = $value;
    }

}