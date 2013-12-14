@extends('master.tpl')

@block('title')
	Home
@endblock

@block('content')
	Your new name is <b>{{ $name }}</b>!
@endblock