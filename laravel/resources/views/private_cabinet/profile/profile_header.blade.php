<div class="submenu d-none d-sm-block text-center">
    <a href="{{route('user.profile.profile')}}" class="{{$type_page_profile == 'profile' ? 'active' : ''}}">Авторизация</a>
    <a href="{{route('user.profile.contacts')}}" class="{{$type_page_profile == 'contacts' ? 'active' : ''}}">Контакты</a>
    <a href="{{route('user.profile.notify')}}" class="{{$type_page_profile == 'notify' ? 'active' : ''}}">Уведомления</a>
    <a href="{{route('user.profile.reviews')}}" class="{{$type_page_profile == 'reviews' ? 'active' : ''}}">Отзывы</a>
    <a href="{{route('user.profile.company')}}" class="{{$type_page_profile == 'company' ? 'active' : ''}}">Компания</a>
</div>


