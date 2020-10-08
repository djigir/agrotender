@extends('layout.layout')

@section('content')
{{--    <div class="filters-wrap">--}}
{{--        <div class="filters-inner">--}}
{{--            <div class="filters arrow-t">--}}
{{--                <div class="step-1 stp">--}}
{{--                    <div class="mt-3">--}}
{{--                        <span class="title ml-3 pt-3">Настройте фильтры:</span>--}}
{{--                    </div>--}}
{{--                    <div class="position-relative mt-3">--}}
{{--                        <input type="text" class="pl-4 pr-5 py-4 content-block filter-search" placeholder="Я ищу.." value="{if $query neq null}{$query}{/if}">--}}
{{--                        <i class="far fa-search searchFilterIcon"></i>--}}
{{--                    </div>--}}
{{--                    <a class="mt-4 p-4 content-block filter filter-rubric d-flex justify-content-between" href="#" rubric="{if $rubric eq null}0{else}{$rubric['id']}{/if}">--}}
{{--                        <span>{if $rubric eq null}Выберите рубрику{else}{$rubric['title']}{/if}</span>--}}
{{--                        <span><i class="far fa-chevron-right"></i></span>--}}
{{--                    </a>--}}
{{--                    <a class="mt-4 p-4 content-block filter filter-region d-flex justify-content-between" href="#" region="{if $region['id'] eq null}0{else}{$region['translit']}{/if} ">--}}
{{--                        <span>{if $region['id'] eq null}Вся Украина{elseif $region['id'] eq 1}АР Крым{else}{$region['name']} область{/if}</span>--}}
{{--                        <span><i class="far fa-chevron-right"></i></span>--}}
{{--                    </a>--}}
{{--                    <a class="show showCompanies" href="#">--}}
{{--                        Показать компании--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--                <div class="step-3 stp h-100">--}}
{{--                    <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>--}}
{{--                    <div class="scroll">--}}
{{--                        {foreach from=$rubricsGroup item=group}--}}
{{--                        <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" group="{$group['id']}">--}}
{{--                            <span>{$group['title']}</span>--}}
{{--                            <span><i class="far fa-chevron-right"></i></span>--}}
{{--                        </a>--}}
{{--                        {/foreach}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="step-3-1 stp h-100">--}}
{{--                    <a class="back py-3 px-4 content-block d-block" step="3" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>--}}
{{--                    <div class="scroll">--}}
{{--                        {foreach from=$rubrics item=r key=gid}--}}
{{--                        {foreach from=$r item=rg}--}}
{{--                        {foreach from=$rg item=rgi}--}}
{{--                        <a href="#" class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between group-{$rgi['group_id']}" rubricId="{$rgi['topic_id']}">--}}
{{--                            <span>{$rgi['title']} &nbsp;<span class="companyCount small">({$rgi['count']})</span></span>--}}
{{--                            <span><i class="far fa-chevron-right"></i></span>--}}
{{--                        </a>--}}
{{--                        {/foreach}--}}
{{--                        {/foreach}--}}
{{--                        {/foreach}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="step-4 stp h-100">--}}
{{--                    <a class="back py-3 px-4 content-block d-block" step="1" href="#"><span><i class="far fa-chevron-left mr-1"></i> Назад</span></a>--}}
{{--                    <div class="scroll">--}}
{{--                        <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="0">--}}
{{--                            <span>Вся Украина</span>--}}
{{--                            <span><i class="far fa-chevron-right"></i></span>--}}
{{--                        </a>--}}
{{--                        {foreach from=$regions_list item=col}--}}
{{--                        {foreach from=$col item=region}--}}
{{--                        <a href="#" class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="{$region['translit']}">--}}
{{--                            <span>{$region['name']} область</span>--}}
{{--                            <span><i class="far fa-chevron-right"></i></span>--}}
{{--                        </a>--}}
{{--                        {/foreach}--}}
{{--                        {/foreach}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="d-none d-sm-block container mt-3">
{{--        <ol class="breadcrumbs small p-0">--}}
{{--            <li><a href="/">Главная</a></li>--}}
{{--            {if $rubric neq null}--}}
{{--            <i class="fas fa-chevron-right extra-small"></i>--}}
{{--            <li><a href="{if $region['id'] eq null}/kompanii{else}/kompanii/region_{$region['translit']}/index{/if}">Компании в {if $region['id'] eq null}Украине{else}{$region['parental']} области{/if}</a></li>--}}
{{--            <i class="fas fa-chevron-right extra-small"></i>--}}
{{--            <li><h1>{$h1}</h1></li>--}}
{{--            {else}--}}
{{--            <i class="fas fa-chevron-right extra-small"></i>--}}
{{--            <li><h1>Компании в {if $region['id'] eq null}Украине{else}{$region['parental']} области{/if}</h1></li>--}}
{{--            {/if}--}}
{{--        </ol>--}}
{{--        <div class="content-block mt-3 py-3 px-4">--}}
{{--            <div class="form-row align-items-center position-relative">--}}
{{--                <div class="col-3 mr-2">--}}
{{--                    <button class="btn rubricInput text-center drop-btn">{if $rubric eq null}Все рубрики{else}{$rubric['title']}{/if} <i class="ml-2 small far fa-chevron-down"></i></button>--}}
{{--                </div>--}}
{{--                <div class="dropdown-wrapper position-absolute rubricDrop">--}}
{{--                    <div class="dropdown">--}}
{{--                        <div class="section text-left">--}}
{{--                            <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-auto">--}}
{{--                                    {foreach from=$rubricsGroup item=g}--}}
{{--                                    <a class="rubricLink getRubricGroup" href="#" group="{$g['id']}">--}}
{{--                    <span>--}}
{{--                      {$g['title']}</sp an>--}}
{{--                      <span class="ml-4 float-right right"><i class="far fa-chevron-right"></i></span>--}}
{{--                                    </a>--}}
{{--                                    {/foreach}--}}
{{--                                </div>--}}
{{--                                {foreach from=$rubrics item=r key=gid}--}}
{{--                                {foreach from=$r item=rg}--}}
{{--                                <div class="col-auto rubricGroup pr-0 mr-3 group-{$gid}">--}}
{{--                                    {foreach from=$rg item=rgi}--}}
{{--                                    <a class="regionLink{if $rgi['topic_id'] eq $rubric['id']} active{/if}" href="/kompanii/region_{$region['translit']}/t{$rgi['topic_id']}">--}}
{{--                                        <span{if $rgi['title']|count_characters:true gt 27} data-toggle="tooltip" data-placement="top" title="{$rgi['title']}"{/if}>{$rgi['title']|truncate:27:"..":true}</span>--}}
{{--                                        <span class="companyCount small">({$rgi['count']})</span>--}}
{{--                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                    </a>--}}
{{--                                    {/foreach}--}}
{{--                                </div>--}}
{{--                                {/foreach}--}}
{{--                                {/foreach}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-3 mr-2">--}}
{{--                    <button class="btn regionInput text-center drop-btn">{if $region['id'] eq null}Вся Украина{elseif $region['id'] eq 1}АР Крым{else}{$region['name']} область{/if}<i class="ml-2 small far fa-chevron-down"></i></button>--}}
{{--                </div>--}}
{{--                <div class="dropdown-wrapper position-absolute regionDrop">--}}
{{--                    <div class="dropdown">--}}
{{--            <span class="d-block">--}}
{{--              <a class="regionLink d-inline-block{if $region['id'] eq null} text-muted disabled"{else}"{/if} href="/kompanii/region_ukraine/{if $rubric neq null}t{$rubric['id']}{else}index{/if}">--}}
{{--              <span>Вся Украина</span>--}}
{{--                <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                </a>--}}
{{--                <a class="regionLink d-inline-block{if $region['id'] eq 1} text-muted disabled"{else}"{/if} href="/kompanii/region_crimea/{if $rubric neq null}t{$rubric['id']}{else}index{/if}">--}}
{{--              <span>АР Крым</span>--}}
{{--                <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                </a>--}}
{{--            </span>--}}
{{--                        <hr class="mt-1 mb-2">--}}
{{--                        <div class="section text-left">--}}
{{--                            <!--<div class="spinnerHome"> <div class="bounce1"></div> <div class="bounce2"></div> <div class="bounce3"></div> </div>-->--}}
{{--                            <div class="row">--}}
{{--                                {foreach from=$regions_list item=col}--}}
{{--                                <div class="col">--}}
{{--                                    {foreach from=$col item=c}--}}
{{--                                    <a class="regionLink{if $c['name'] eq $region['name']} active{/if}" href="/kompanii/region_{$c['translit']}/{if $rubric neq null}t{$rubric['id']}{else}index{/if}">--}}
{{--                                        <span>{$c['name']|truncate:22:"..":false} область</span>--}}
{{--                                        <span class="companyCount small">({$c['count']})</span>--}}
{{--                                        <!--<span class="float-right right"><i class="far fa-chevron-right"></i></span>-->--}}
{{--                                    </a>--}}
{{--                                    {/foreach}--}}
{{--                                </div>--}}
{{--                                {/foreach}--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col searchDiv" data-tip="Введите поисковой запрос">--}}
{{--                    <form class="searchForm">--}}
{{--                        <input maxlength="32" type="text" name="text" class="searchInput" placeholder="Я ищу.."{if $query neq null} value="{$query}"{/if}>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--                <div class="col-auto">--}}
{{--                    <i class="far fa-search searchIcon mt-2 ml-2"></i>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="row mt-4 pt-3">
            <div class="col-12 col-sm-4 float-left mt-4 mt-md-0 d-flex d-sm-block">
                <h2 class="d-inline-block text-uppercase">Поиск / Список компаний</h2>
                <a href="/tarif20.html" class="small show-all mb-1 d-inline-block">Как сюда попасть?</a>
            </div>
            <div class="col-12 col-sm-8 float-md-right text-center text-md-right">
                <a id="addCompanny" href="/tarif20.html" class="top-btn btn btn-warning align-items-end" id="addCompanny">
                    <i class="far fa-plus mr-2"></i>
                    <span class="pl-1 pr-1">Разместить компанию</span>
                </a>
                <!-- <a href="{if $user->auth}/u/company{else}/add_buy_trader{/if}" class="top-btn btn btn-warning align-items-end">
                  <span class="pt-1"><i class="far fa-plus mr-2"></i> Разместить компанию</span>
                </a> -->
            </div>
        </div>
    </div>
{{--    {if $region['id'] != null or $rubric['id'] != null}--}}
    <div class="d-sm-none container pt-4">
{{--        {if $region['id'] != null}--}}
        <div><span class="searchTag regionTag d-inline-block">{$region['name']} область <a href="/kompanii{if $rubric neq null}/t{$rubric['id']}{/if}"><i class="far fa-times close ml-3"></i></a></span></div>
{{--        {/if}--}}
{{--        {if $rubric['id'] != null}--}}
        <div><span class="searchTag regionTag d-inline-block">{$rubric['title']} <a href="/kompanii/region_{$region['translit']}/index"><i class="far fa-times close ml-3"></i></a></span></div>
{{--        {/if}--}}
    </div>
{{--    {/if}--}}
    <div class="container pb-4 companies">
        @foreach($companies as $index => $company)

            {if $company['top']==1}companyTop{/if} {if $company['top']==2}companyTop{/if}
            <div class="row content-block companyItem mx-0 mt-4 pt-3 pb-1 py-sm-3 px-1
{{--{{$company['top']==1 || $company['top']==2 ? 'companyTop' : ''}}--}}
                "
{{----}}

{{--            {{$company['top'] == 2 ?? style ="overflow:hidden;"}}--}}
{{--                 {if $company['top'] == 2} {/if}}--}}
            >
{{--                @if($company['top'] == 2)--}}
{{--                    <div class="ribbonComp">VIP</div>--}}
{{--                @endif--}}

        <div class="row mx-0 w-100">
            <div class="col-auto pr-0 pl-2 pl-sm-3">
                <div class="row m-0">
                    <div class="col-12 pl-0 pr-0 pr-sm-2">
                        <a href="/kompanii/comp-{{$company['id']}}"><img class="companyImg"
                          src="{{ $company['logo_file'] ? $company['logo_file'] : '/app/assets/img/no-image.png' }}"/>
                        </a>
                    </div>
                </div>
                <div class="row m-0 pt-3 d-none d-sm-flex">
                    <div class="col-12 pl-0 pr-2 text-center">
                        <span class="date">На сайте с {{$company['add_date']}}</span>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row lh-1">
                    <div class="col">
                        <span class="title"><a href="/kompanii/comp-{{$company['id']}}">{!! $company['title'] !!}</a></span>
                    </div>
                </div>
                <div class="row d-sm-none lh-1">
                    <div class="col">
                        <span class="date mb-2">На сайте с {{$company['add_date']}}</span>
                    </div>
                </div>
                <div class="row d-none d-sm-flex">
                    <div class="col mt-1">
                        <p class="desc">{{$company['short']}}</p>
                    </div>
                </div>
                <div class="row lh-1-2">
                    <div class="col">
                        <span class="a-bold d-none d-sm-inline-block">Виды деятельности:</span>
                        <span class="activities d-none d-sm-block" {if $company['activities']|count_characters:true gt 75} data-toggle="tooltip" data-placement="top" title="{$company['activities']}"{/if}>{$company['activities']|truncate:75:"..":true}</span>
                        <span class="activities d-block d-sm-none" {if $company['activities']|count_characters:true gt 57} data-toggle="tooltip" data-placement="top" title="{$company['activities']}"{/if}>{$company['activities']|truncate:57:"..":true}</span>
                    </div>
                </div>
                <div class="row d-none d-sm-flex">
                    <div class="col pt-2 mt-1">
                        {if $company['trader_price_avail'] eq 1 and $company['trader_price_visible'] eq 1}
                        <a class="link" href="/kompanii/comp-{{$company['id']}}-prices"><span>Цены Трейдера</span></a>
                        {/if}
                        {if $company['purchases'] gt 0}
                        <a class="link" href="/kompanii/comp-{$company['id']}-adverts?type=1"><span>Закупки ({$company['purchases']})</span></a>
                        {/if}
                        {if $company['sales'] gt 0}
                        <a class="link" href="/kompanii/comp-{$company['id']}-adverts?type=2"><span>Товары ({$company['sales']})</span></a>
                        {/if}
                        {if $company['services'] gt 0}
                        <a class="link" href="/kompanii/comp-{$company['id']}-adverts?type=3"><span>Услуги ({$company['services']})</span></a>
                        {/if}
                    </div>
                </div>
            </div>
            <div class="d-none d-md-block col-md-3">
                <div class="companySticker">
                    @if($company['phone'])
                        <span>{{$company['phone']}}</span>
                    @endif
                    @if($company['phone2'])
                        <span>{{$company['phone2']}}</span>
                    @endif
                    @if($company['phone3'])
                        <span>{{$company['phone3']}}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row mx-0 d-sm-none lh-1 w-100">
            <div class="col mt-2 text-center">
                {if $company['trader_price_avail'] eq 1 and $company['trader_price_visible'] eq 1}
                <a class="link" href="/kompanii/comp-{$company['id']}-prices"><span>Цены Трейдера</span></a>
                {/if}
                {if $company['purchases'] gt 0}
                <a class="link" href="/kompanii/comp-{$company['id']}-adverts?type=1"><span>Закупки ({$company['purchases']})</span></a>
                {/if}
                {if $company['sales'] gt 0}
                <a class="link" href="/kompanii/comp-{$company['id']}-adverts?type=2"><span>Товары ({$company['sales']})</span></a>
                {/if}
                {if $company['services'] gt 0}
                <a class="link" href="/kompanii/comp-{$company['id']}-adverts?type=3"><span>Услуги ({$company['services']})</span></a>
                {/if}
            </div>
        </div>
    </div>
    @endforeach
{{--    <div class="container">--}}
{{--        <div class="empty pt-0 pt-md-5">--}}
{{--            <div class="sketch mt-3 mt-md-5">--}}
{{--                <div class="bee-sketch red"></div>--}}
{{--                <div class="bee-sketch blue"></div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    {/foreach}--}}
{{--    <div class="text-center mt-4">--}}
{{--        {foreach $banners['bottom'] as $banner}--}}
{{--        {$banner}--}}
{{--        {/foreach}--}}
{{--    </div>--}}
{{--    {if $companies neq null && $totalPages > 1}--}}
{{--    <div class="row mx-0 mt-4">--}}
{{--        <div class="col-12 pagination d-block text-center">--}}
{{--            {assign "page" $pageNumber}--}}
{{--            {if $page neq 1}--}}
{{--            <a href="{if $query neq null}/kompanii/s/{$query}/p{$page - 1}{else}/kompanii/{if $region neq null}region_{$region['translit']}/{/if}{if $rubric neq null}t{$rubric['id']}_p{else}p{/if}{$page - 1}{/if}"><span class="mr-1"><i class="far fa-chevron-left"></i></span> <span class="d-none d-sm-inline-block">Предыдущая</span></a>--}}
{{--            {/if}--}}
{{--            {if ($page - 3) ge 1}--}}
{{--            <a class="mx-1" href="{if $query neq null}/kompanii/s/{$query}{else}/kompanii/{if $region neq null}region_{$region['translit']}/{/if}{if $rubric neq null}t{$rubric['id']}{else}{/if}{/if}">1</a>--}}
{{--            ..--}}
{{--            {/if}--}}
{{--            {if ($page - 2) gt 0}--}}
{{--            <a class="d-none d-sm-inline-block mx-1" href="{if $query neq null}/kompanii/s/{$query}/p{$page - 2}{else}/kompanii/{if $region neq null}region_{$region['translit']}/{/if}{if $rubric neq null}t{$rubric['id']}_p{else}p{/if}{$page - 2}{/if}">{$page - 2}</a>--}}
{{--            {/if}--}}
{{--            {if ($page - 1) gt 0}--}}
{{--            <a class="d-none d-sm-inline-block mx-1" href="{if $query neq null}/kompanii/s/{$query}/p{$page - 1}{else}/kompanii/{if $region neq null}region_{$region['translit']}/{/if}{if $rubric neq null}t{$rubric['id']}_p{else}p{/if}{$page - 1}{/if}">{$page - 1}</a>--}}
{{--            {/if}--}}
{{--            <a href="#" class="active mx-1">{$page}</a>--}}
{{--            {if ($page + 1) le $totalPages}--}}
{{--            <a class="d-sm-inline-block mx-1" href="{if $query neq null}/kompanii/s/{$query}/p{$page + 1}{else}/kompanii/{if $region neq null}region_{$region['translit']}/{/if}{if $rubric neq null}t{$rubric['id']}_p{else}p{/if}{$page + 1}{/if}">{$page + 1}</a>--}}
{{--            {/if}--}}
{{--            {if ($page + 2) le $totalPages}--}}
{{--            <a class="d-sm-inline-block mx-1" href="{if $query neq null}/kompanii/s/{$query}/p{$page + 2}{else}/kompanii/{if $region neq null}region_{$region['translit']}/{/if}{if $rubric neq null}t{$rubric['id']}_p{else}p{/if}{$page + 2}{/if}">{$page + 2}</a>--}}
{{--            {/if}--}}
{{--            {if ($page + 3) le $totalPages}--}}
{{--            ..--}}
{{--            <a class="mx-1" href="{if $query neq null}/kompanii/s/{$query}/p{$totalPages}{else}/kompanii/{if $region neq null}region_{$region['translit']}/{/if}{if $rubric neq null}t{$rubric['id']}_p{else}p{/if}{$totalPages}{/if}">{$totalPages}</a>--}}
{{--            {/if}--}}
{{--            {if $page neq $totalPages}--}}
{{--            <a href="{if $query neq null}/kompanii/s/{$query}/p{$page + 1}{else}/kompanii/{if $region neq null}region_{$region['translit']}/{/if}{if $rubric neq null}t{$rubric['id']}_p{else}p{/if}{$page + 1}{/if}"><span class="d-none d-sm-inline-block">Следующая</span> <span class="ml-1"><i class="far fa-chevron-right"></i></span></a>--}}
{{--            {/if}--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    {if $text neq ''}--}}
{{--    <br>--}}
{{--    {$text}--}}
{{--    {/if}--}}
{{--    {/if}--}}
@endsection

