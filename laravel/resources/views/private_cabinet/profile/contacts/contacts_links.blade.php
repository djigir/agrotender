<div class="dep mx-sm-5 text-center text-sm-left">
    <a href="{{ route('user.profile.contacts') }}" @if(!isset($type)) class="active" @endif>Главный офис</a>
    <a href="{{ route('user.profile.contacts', "dep=1") }}" @if($type == 1) class="active" @endif>Отдел закупок</a>
    <a href="{{ route('user.profile.contacts', "dep=2") }}" @if($type == 2) class="active" @endif>Отдел продаж</a>
    <a href="{{ route('user.profile.contacts', "dep=3") }}" @if($type == 3) class="active" @endif>Отдел услуг</a>
    <a href="{{ route('user.profile.contacts', "dep=999") }}" @if($type == 999) class="active" @endif>Telegram/Viber</a>
</div>
