<!DOCTYPE html>  
<html>
	<head>  
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>@yield('title')</title>
		{{ HTML::style('style.css') }}			
		{{ HTML::script('script.js') }}	
		@yield('head')
	</head> 
	<body>
		<br /><br />
		<table border="1" cellspacing="0" cellpadding="20" align="center" width="80%">
			<tr>
				<td colspan="2"><h2>Modular MVC Framework</h2></td>
			</tr>
			<tr>
				<td valign="top">
					{{ HTML::link("page/home", "Home") }}<br />
					{{ HTML::link("page/about", "About") }}
				</td>
				<td valign="top">
					@yield('content')
				</td>
			</tr>
		</table>
	</body>
</html>