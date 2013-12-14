<?php
class PostgetController extends Controller {
	
	function init() {
		
	}
	
	function index($get) {
		$user = isset($get->name) ? $get->name : 'Unknown';
		View::make('index.tpl', array('name' => $user));
	}
	
	function submitnewname($get, $post) {
		$user = isset($post->name) ? $post->name : 'Unknown';
		View::make('newname.tpl', array('name' => $user));
	}
	
}
?>