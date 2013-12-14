@extends('master.tpl')

@block('title')
	Home
@endblock

@block('content')
	Your name is <b>{{ $name }}</b>!<br /><br />
	<form action="index.php?page=postget&action=submitnewname" method="POST">
		Name: <input type="text" name="name"><br />
		<input type="submit" value="Submit">
	</form>
@endblock