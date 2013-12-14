@extends('master.tpl')

@block('title')
	Home
@endblock

@block('content')
	Text called from class: {{ $name }}<br /><br />
	Text called from function: {{ $name }}<br /><br />
	Template code test: 
	{% for ($i = 0; $i < 10; $i++): %}
		{{ $i }}, 
	{% endfor; %}
@endblock