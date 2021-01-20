<ul class="nav navbar-nav ">
	<li class="nav-item">
		<a class="nav-link" data-widget="pushmenu"><i class="fas fa-bars"></i></a>
	</li>
	@if (config('sleeping_owl.state_datatables') || config('sleeping_owl.state_tabs') || config('sleeping_owl.state_filters'))
		<li class="nav-item">
			<a class="nav-link" href="javascript:localStorage.clear()" data-toggle="tooltip" title="{{ trans('sleeping_owl::lang.button.clear') }} LocalStorage">
				<i class="fas fa-eraser"></i>
			</a>
		</li>
	@endif

	@stack('navbar.left')
    <li class="nav-item">
        <a style="margin-left: 10px" class="nav-link link-page" href="/admin_dev/comp_items_traders">Трейдеры</a>
    </li>

    <li class="nav-item">
        <a class="nav-link link-page" href="/admin_dev/comp_items_actives">Активные трейды</a>
    </li>

    <li class="nav-item">
        <a class="nav-link link-page" href="/admin_dev/comp_items">Редактор компаний</a>
    </li>

    <li class="nav-item">
        <a class="nav-link link-page" href="/admin_dev/torg_elevators">Элеваторы</a>
    </li>

    <li class="nav-item">
        <a class="nav-link link-page" href="/admin_dev/adv_torg_posts">Объявления</a>
    </li>
	@stack('navbar')
</ul>

<ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <a href="/file_manager/tinyfilemanager.php" class="nav-link" target="_blank"><i class="fas fa-user-shield"></i></a>
    </li>
	@stack('navbar.right')
</ul>
