<?php
class HomeController extends Controller {
	
	function init() {
		
	}
	
	function index() {
		View::make('index.tpl', array('name' => 'Dave'));
	}
	
}
?>