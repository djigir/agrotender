<div class="filters-wrap mobile-filters"  style="display: none;">
    <div class="filters-inner">
        <div class="filters arrow-t">
            <div class="step-1 stp" style="">
                <form>
                <div class="position-relative scroll-wrap">

                    <div class="mt-3">
                        <span class="title ml-3 pt-3">Настройте фильтры:</span>
                    </div>

                        <a class="mt-3 p-4 content-block filter filter-type d-flex justify-content-between" href="#" type="" id='type-page'>
                            <input type="text"  value="" class="remove-input">
                            <span>Закупки</span>
                            <span><i class="far fa-chevron-right"></i></span>
                        </a>
                        <a class="mt-4 p-4 content-block filter filter-rubric d-flex justify-content-between" href="#" rubric="0" id='mobile-rubric'>
                            <input type="text" id='input-mobile-rubric' name="rubric" value=""  class="remove-input">
                            <span id="span-mobile-rubric">{{isset($culture_name) ? $culture_name : 'Выбрать продукцию'}}</span>
                            <span><i class="far fa-chevron-right"></i></span>
                        </a>
                        <a class="mt-4 p-4 content-block filter filter-region d-flex justify-content-between" href="#" region="0" port="0" id='mobile-region'>
                            <input type="text" id='input-mobile-region-t' name="region" value=""  class="remove-input">
                            <input type="text" id='input-mobile-port-t' name="port" value=""  class="remove-input">
                            <span id="span-mobile-region">{{isset($currently_obl) ? $currently_obl : 'Вся Украина'}}</span>
                            <span><i class="far fa-chevron-right"></i></span>
                        </a>
                        <a class="mt-4 p-4 content-block filter filter-currency d-flex justify-content-between" href="#">
                            <span class="text-muted">Валюта:</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-radio active">
                                    <input type="radio" id='currency-all' currency="null" name="currency" value="2" autocomplete="off" checked=""> Любая
                                </label>
                                <label class="btn btn-radio">
                                    <input type="radio" id='currency-uah' name="currency" currency="0" value="0" autocomplete="off"> Гривна
                                </label>
                                <label class="btn btn-radio">
                                    <input type="radio" id='currency-usd' name="currency" currency="1" value="1" autocomplete="off"> Доллар
                                </label>
                            </div>
                        </a>
                        <a class="mt-4 p-4 content-block filter filter-viewmod d-flex justify-content-between" href="#">
                            <span class="text-muted">Показать:</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-radio">
                                    <input type="radio" id='show-type-list' name="viewmod" value="list" autocomplete="off"> Списком
                                </label>
                                <label class="btn btn-radio active">
                                    <input type="radio" id='show-type-table' name="viewmod" value="table" autocomplete="off" checked=""> Таблицей
                                </label>
                            </div>
                        </a>

                    <div class="error-text mt-3 text-center">
                        <span>Для сравнения цен выберите продукцию</span>
                    </div>
                </div>
                <button class="remove-style-btn show" type="submit">Показать трейдеров</button>
                </form>
            </div>
            <div class="step-2 stp h-100" style="display: none;">
                <a class="back py-3 px-4 content-block d-block" step="1" href="#" id="back-page-type">
                    <span>
                        <i class="far fa-chevron-left mr-1"></i>
                        Назад
                    </span>
                </a>
                <div class="scroll">
                    <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="/traders_forwards/region_ukraine">
                        <span>Форварды</span>
                        <span><i class="far fa-chevron-right"></i></span>
                    </a>
                    <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="/traders_sell">
                        <span>Продажи</span>
                        <span><i class="far fa-chevron-right"></i></span>
                    </a>
                </div>
            </div>

            <div class="step-3 stp h-100" style="display: none;">
                <a class="back py-3 px-4 content-block d-block" step="1" href="#" id="back">
                    <span>
                        <i class="far fa-chevron-left mr-1"></i>
                        Назад
                    </span>
                </a>
                <div class="scroll">
                    @if(isset($rubricGroups))
                        @foreach($rubricGroups as $group => $item)
                            <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="#" group="{{$item['id']}}">
                                <span>{{$item['groups']['name']}}</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="step-3-1 stp h-100" style="display: none;">
                <a class="back py-3 px-4 content-block d-block" step="3" href="#" id="back3" >
                    <span>
                        <i class="far fa-chevron-left mr-1"></i>
                        Назад
                    </span>
                </a>
                <div class="scroll">
                    @if(isset($rubricGroups))
                        @foreach($rubricGroups as $group => $item)
                            @foreach($rubricGroups[$group]["products"] as $index => $item_culture)
                                <a href="#" class="culture px-4 py-3 my-3 content-block d-flex justify-content-between " group="{{$item['id']}}" rubricId="{{$item_culture['url']}}">
                                    <span>{{ $item_culture['culture']['name']}}</span>
                                    <span><i class="far fa-chevron-right"></i></span>
                                </a>
                            @endforeach
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="step-4 stp h-100" style="display: none;">
                <a class="back py-3 px-4 content-block d-block" step="1" href="#" id="back2">
                    <span>
                        <i class="far fa-chevron-left mr-1"></i>
                        Назад
                    </span>
                </a>
                <div class="scroll">
                    @foreach(array_reverse($regions) as $index_region  => $region)
                        <a href="#" class="region px-4 py-1 my-2 d-flex justify-content-between" region="{{$region['translit']}}">
                            <span style="{{$index_region < 1 ? 'font-weight: 600;' : ''}}">{{$region['name']}}</span>
                            <span><i class="far fa-chevron-right"></i></span>
                        </a>
                    @endforeach

                    @foreach(array_reverse($onlyPorts) as $index_port  => $port)

                        <a href="#" class="region px-4 py-1 my-2 d-flex justify-content-between port" port="{{$port['url']}}">
                            <span style="{{$index_port < 1 ? 'font-weight: 600;' : ''}}">{{$port['portname']}}</span>
                            <span><i class="far fa-chevron-right"></i></span>
                        </a>
                    @endforeach
{{--                    <a href="#" class="region px-4 py-1 my-2 d-flex justify-content-between" port="all">--}}
{{--                        <span style="font-weight: 600;">Все порты</span>--}}
{{--                        <span><i class="far fa-chevron-right"></i></span>--}}
{{--                    </a>--}}
                </div>
            </div>
        </div>
    </div>
</div>
