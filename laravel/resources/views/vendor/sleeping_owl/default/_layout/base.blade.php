<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	{!! $template->renderMeta($title) !!}
    <link rel="stylesheet" href="/app/assets/css_admin/admin.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	@stack('scripts')
</head>
<body class="hold-transition sidebar-mini {{ $menu_class }}">
	@yield('content')
	@include(AdminTemplate::getViewPath('helper.scrolltotop'))

	{!! $template->meta()->renderScripts(true) !!}
	@stack('footer-scripts')

	@include(AdminTemplate::getViewPath('helper.autoupdate'))
</body>
</html>
