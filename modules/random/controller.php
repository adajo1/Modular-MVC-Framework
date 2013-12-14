<?php
class RandomController extends Controller {
	
	function index() {
		View::make('random.tpl', array('name' => Random::text(), 'name2' => random()));
	}
	
}
?>