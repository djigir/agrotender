<div class="overlay"></div>
<div class="mobileMenu">
    <div class="container p-0">
        <div class="mobileHeader row mx-0 px-3">
            <a class="col-9" href="/u/">
                {{--{if $user->company neq null}{$user->company['title']}{else}{$user->name}{/if}--}}
            </a>
            <a href="/logout" class="right float-right logout col-3">Выход</a>
        </div>
        <div class="links">
            <a href="#">Обьявления</a>
            <a href="{{route('company.companies')}}">Компании</a>
            <a href="{{route('traders.')}}">Цены Трейдеров</a>
            <a href="#">Элеваторы</a>
            <a href="#">Форварды</a>
        </div>
    </div>
</div>
<div class="userMobileMenu" style="display: none">
    <div class="d-flex head py-2 px-4 align-items-center justify-content-between">
        <a class="back main" href="#">< Назад</a>
        <img class="avatar" src="{if $company['logo_file'] neq null}/{$company['logo_file']}{else}/app/assets/img/noavatar.png{/if}">
    </div>
    <div class="items d-flex flex-column justify-content-between">
        @if(isset($id))
            <a href="{{route('company.company', $id)}}" class="" >Главная</a>
            <a href="{{route('company.company_reviews', $id)}}" class="">Отзывы</a>
            <a href="{{route('company.company_cont', $id)}}" class="">Контакты</a>
        @endif
    </div>
</div>
<style>

</style>
<script>
    console.log('mobile-menu');
    console.log(window.jQuery);
    window.onload = function() {
        console.log($('.burger'));
    }

</script>
