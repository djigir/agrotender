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
                            <span style="color: #1e56b2">Закупки</span>
                            <span><i class="far fa-chevron-right"></i></span>
                        </span>
                        <span class="mt-4 p-4 content-block filter filter-rubric d-flex justify-content-between"  rubric="0" id='mobile-rubric'>
                            <input type="text" id='input-mobile-rubric' name="rubric" value="{{!empty($culture_translit) ? $culture_translit : ''}}"  class="remove-input">
                            <span style="color: #1e56b2" id="span-mobile-rubric">{{$culture_name}}</span>
                            <span><i class="far fa-chevron-right"></i></span>
                        </span>
                        <span class="mt-4 p-4 content-block filter filter-region d-flex justify-content-between"  region="0" port="0" id='mobile-region'>
                            <input type="text" id='input-mobile-region-t' name="region" value="{{!empty($region) ? $region: ''}}"  class="remove-input">
                            <input type="text" id='input-mobile-port-t' name="port" value="{{!empty($port) ? $port: ''}}"  class="remove-input">
                            <span style="color: #1e56b2" id="span-mobile-region">{{$region_port_name}}</span>
                            <span><i class="far fa-chevron-right"></i></span>
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
                        <span class="mt-4 p-4 content-block filter filter-viewmod d-flex justify-content-between">
                            <span class="text-muted">Показать:</span>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-radio">
                                    <input type="radio" id='show-type-list' name="viewmod" value="list" autocomplete="off"> Списком
                                </label>
                                <label class="btn btn-radio active">
                                    <input type="radio" id='show-type-table' name="viewmod" value="table" autocomplete="off" checked=""> Таблицей
                                </label>
                            </div>
                        </span>

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
                    @if($culture_id && $region)
                        <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="{{route('traders_forwards_culture', [$region , $culture_translit])}}">
                            <span>Форварды</span>
                            <span><i class="far fa-chevron-right"></i></span>
                        </a>
                    @endif
                    <a class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between" href="{{route('traders_sell',  $region)}}">
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
                            @foreach($rubricGroups[$group]["products"] as $index => $item_culture)
                                <span class="culture px-4 py-3 my-3 content-block d-flex justify-content-between"  group="{{$item['id']}}" rubric="{{$item_culture['url']}}">
                                    <span style="color: #1e56b2">{{ $item_culture['culture']['name']}}</span>
                                    <span><i class="far fa-chevron-right"></i></span>
                                </span>
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
                        <span class="region px-4 py-1 my-2 d-flex justify-content-between" style="color: #1e56b2" region="{{$region['translit']}}">
                            <span style="{{$index_region < 1 ? 'font-weight: 600;' : ''}}">{{$region['name']}}</span>
                            <span><i class="far fa-chevron-right"></i></span>
                        </span>
                    @endforeach

                    @foreach(array_reverse($onlyPorts) as $index_port  => $port)
                        <span  class="region px-4 py-1 my-2 d-flex justify-content-between port" style="color: #1e56b2" port="{{$port['url']}}">
                            <span style="{{$index_port < 1 ? 'font-weight: 600;' : ''}}">{{$port['portname']}}</span>
                            <span><i class="far fa-chevron-right"></i></span>
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
