<div class="submenu d-none d-sm-block text-center">
    <a href="{{route('user.profile.profile')}}" class="{{$type_page_profile == 'profile' ? 'active' : ''}}">Авторизация</a>
    <a href="{{route('user.profile.contacts')}}" class="{{$type_page_profile == 'contacts' ? 'active' : ''}}">Контакты</a>
    <a href="{{route('user.profile.notify')}}" class="{{$type_page_profile == 'notify' ? 'active' : ''}}">Уведомления</a>
    <a href="{{route('user.profile.reviews')}}" class="{{$type_page_profile == 'reviews' ? 'active' : ''}}">Отзывы</a>
    <a href="{{route('user.profile.company')}}" class="{{$type_page_profile == 'company' ? 'active' : ''}}">Компания</a>
    <?php
        $user = auth()->user();
        $company = $user && $user->company;
    ?>
    @if($company)
        <a href="{{route('user.profile.news')}}" class="{{$type_page_profile == 'news' ? 'active' : ''}}">Новости</a>
        <a href="{{route('user.profile.vacancy')}}" class="{{$type_page_profile == 'vacancy' ? 'active' : ''}}">Вакансии</a>
    @endif

</div>


