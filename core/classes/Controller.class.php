<?php
class Controller {
	
	private $__controller_action = 'index';
		
    function __construct($data = array(), $visible = TRUE) {
		foreach ($data as $classname => $class) {
			$this->{$classname} = $class;
		}
		if (!$visible) return;
		if (method_exists($this, 'init')) $this->init();
		if (isset($_GET['action']) && method_exists($this, "{$_GET['action']}")) {
			$this->__controller_action = $_GET['action'];
			return $this->{$_GET['action']}((object)$_GET,(object)$_POST);
		}
		if (method_exists($this, "index")) return $this->index((object)$_GET,(object)$_POST);
	}
	
	function getActionLink() {
		return 'index.php?page=' . Config::get('in_module') . '&action=' . $this->__controller_action;
	}
	
	function getModuleLink() {
		return 'index.php?page=' . Config::get('in_module');
	}

	function getModulePath() {
		return MODULES_DIR . Config::get('in_module') . '/';
	}
	
}
?>