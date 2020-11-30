<div class="filters-wrap mobile-filters"  style="display: none;">
    <div class="filters-inner">
        <div class="filters arrow-t">
            <div class="step-1 stp" style="">
                <form>
                <div class="position-relative scroll-wrap">
                    <div class="mt-3">
                        <span class="title ml-3 pt-3">Настройте фильтры:</span>
                    </div>
                        <span class="mt-3 p-4 content-block filter filter-type d-flex justify-content-between"  type="" id='type-page'>
                            <input type="text"  value="" class="remove-input">
                            @if($type_traders == 0)
                                <span style="color: #1e56b2">Закупки</span>
                            @elseif($type_traders == 1)
                                <span style="color: #1e56b2">Форварды</span>
                            @endif
                            <span><i style="color: #1e56b2;" class="far fa-chevron-right"></i></span>
                        </span>
                        <span class="mt-4 p-4 content-block filter filter-rubric d-flex justify-content-between"  rubric="0" id='mobile-rubric'>
                            <input type="text" id='input-mobile-rubric' name="rubric" value="{{!empty($culture_translit) ? $culture_translit : ''}}"  class="remove-input">
                            <span style="color: #1e56b2" id="span-mobile-rubric">{{$culture_name}}</span>
                            <span><i style="color: #1e56b2;" class="far fa-chevron-right"></i></span>
                        </span>
                        <span class="mt-4 p-4 content-block filter filter-region d-flex justify-content-between"  region="0" port="0" id='mobile-region'>
                            <input type="text" id='input-mobile-region-t' name="region" value="{{!empty($region) ? $region: ''}}"  class="remove-input">
                            <input type="text" id='input-mobile-port-t' name="port" value="{{!empty($port) ? $port: ''}}"  class="remove-input">
                            <span style="color: #1e56b2" id="span-mobile-region">{{$region_port_name}}</span>
                            <span><i style="color: #1e56b2;" class="far fa-chevron-right"></i></span>
                        </span>
                        <span class="mt-4 p-4 content-block filter filter-currency d-flex justify-content-between" >
                            <span class="text-muted">Валюта:</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-radio {{$currency == null ? 'active' : ''}}">
                                    <input type="radio" id='currency-all'> Любая
                                </label>
                                <label class="btn btn-radio {{$currency == 0 && $currency != null ? 'active' : ''}}">
                                    <input type="radio" id="currency-uah" name="currency"  value="0"> Гривна
                                </label>
                                <label class="btn btn-radio {{$currency == 1 && $currency != null ? 'active' : ''}}">
                                    <input type="radio"  id="currency-usd" name="currency"  value="1"> Доллар
                                </label>
                            </div>
                        </span>
{{--                        <span class="mt-4 p-4 content-block filter filter-viewmod d-flex justify-content-between">--}}
{{--                            <span class="text-muted">Показать:</span>--}}
{{--                            <div class="btn-group btn-group-toggle" data-toggle="buttons">--}}
{{--                                <label class="btn btn-radio">--}}
{{--                                    <input type="radio" id='show-type-list' name="viewmod" value="list" autocomplete="off"> Списком--}}
{{--                                </label>--}}
{{--                                <label class="btn btn-radio active">--}}
{{--                                    <input type="radio" id='show-type-table' name="viewmod" value="table" autocomplete="off" checked=""> Таблицей--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                        </span>--}}

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
                    @if($region)
                        @if($type_traders != 1)
                            <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="{{$culture_translit ? route('traders_forward.region_culture', [$region , $culture_translit]) :  route('traders_forward.region',  $region)}}">
                                <span>Форварды</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                        @endif
                        @if($type_traders != 0)
                            <a class="px-4 py-3 my-3 content-block d-flex justify-content-between" href="{{$culture_translit ? route('traders.region_culture',  [$region , $culture_translit]) : route('traders.region',  $region)}}">
                                <span>Закупки</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                        @endif
                    @endif
                    @if($port)
                        @if($type_traders != 1)
                            <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="{{$culture_translit ? route('traders_forward.port_culture', [$port , $culture_translit]) : route('traders_forward.port',  $port)}}">
                                <span>Форварды</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                        @endif
                        @if($type_traders != 0)
                            <a class="px-4 py-3 my-3 content-block d-flex justify-content-between" href="{{$culture_translit ? route('traders.port_culture',  [$port, $culture_translit]) : route('traders.port',  $port)}}">
                                <span>Закупки</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </a>
                        @endif
                    @endif
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
                            <span class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between"  group="{{$item['id']}}">
                                <span style="color: #1e56b2">{{$item['groups']['name']}}</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </span>
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
                            @foreach($rubricGroups[$group]['groups']["products"] as $index => $item_culture)
                                @if($item_culture['count_item'] > 0)
                                    <span class="culture px-4 py-3 my-3 content-block d-flex justify-content-between"  group="{{$item['id']}}" rubric="{{$item_culture['url']}}">
                                        <span style="color: #1e56b2">{{ $item_culture['traders_product_lang'][0]['name']}}
                                                <span style="pointer-events:none" class="companyCount small">({{$item_culture['count_item']}})</span>
                                        </span>
                                        <span style="pointer-events: none">
                                            <i style="color: #1e56b2;" class="far fa-chevron-right"></i>
                                        </span>
                                    </span>
                                @endif
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
                    @foreach($regions as $index_region  => $region)
                        @if($index_region == 0)
                            <span class="region px-4 py-1 my-2 d-flex justify-content-between" style="color: #1e56b2" region="{{ 'ukraine' }}" region_name="Вся Украина">
                                <span style="color: #1e56b2; font-weight: 600;">Вся Украина</span>
                                <span style="pointer-events: none;">
                                   <i style="color: #1e56b2;" class="far fa-chevron-right"></i>
                                </span>
                            </span>
                        @endif
                        <span class="region px-4 py-1 my-2 d-flex justify-content-between" style="color: #1e56b2" region="{{$region['translit']}}" region_name="{{$region['name']}}">
                            <span style="{{$region['translit'] == 'ukraine' ? 'font-weight: 600;' : ''}}">
                                @if($region['name'] == 'Вся Украина' or $region['name'] == 'АР Крым')
                                    <span style="color: #1e56b2">{{$region['name']}}</span>
                                @else
                                    <span style="color: #1e56b2">{{$region['name']}} область</span>
                                @endif
                            </span>
                            <span style="pointer-events: none">
                                <i style="color: #1e56b2;" class="far fa-chevron-right"></i>
                            </span>
                        </span>
                    @endforeach
                    @foreach($onlyPorts as $index_port  => $port)
                        <span  class="port region px-4 py-1 my-2 d-flex justify-content-between" style="color: #1e56b2" port="{{$port['url']}}" port_name="{{$port['url'] == 'all' ? 'Все порты' : $port['lang']['portname']}}">
                            <span style="{{$index_port < 1 ? 'font-weight: 600;' : ''}}">{{$port['lang']['portname']}}</span>
                            <span style="pointer-events: none">
                                <i style="color: #1e56b2;" class="far fa-chevron-right"></i>
                            </span>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
