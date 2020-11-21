{{--<div class="container traders mt-3 mt-sm-5">--}}
{{--    <div class="row mt-sm-0 pt-sm-0 mb-sm-4">--}}
{{--        <div class="position-relative w-100">--}}
{{--            <div class="col-12 col-md-9 float-md-right text-center text-md-right">--}}
{{--                <a id="addCompanny" href="/tarif20.html" class="top-btn btn btn-warning align-items-end d-none d-sm-inline-block">--}}
{{--                    <i class="far fa-plus mr-2"></i>--}}
{{--                    <span class="pl-1 pr-1">Разместить компанию</span>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--            <div class="col-12 col-md-3 float-left mt-sm-0 d-flex justify-content-between d-sm-block">--}}
{{--                <div class="col-6 col-sm-12 pl-0">--}}
{{--                    <h2 class="d-inline-block text-uppercase">Все компании</h2>--}}
{{--                    <div class="lh-1">--}}
{{--                        <a href="/tarif20.html" class="small show-all mb-1 d-inline-block">Как сюда попасть?</a>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="col-6 pr-0 text-right d-sm-none">--}}
{{--                    <a href="/tarif20.html" class="btn btn-warning align-items-end add-trader">--}}
{{--                        <span class="pl-1 pr-1">Стать трейдером</span>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<div class="filters-wrap mobile-filters" style="display: none;">
    <div class="filters-inner">
        <div class="filters arrow-t">
            <div class="step-1 stp" style="">
                <div class="mt-3">
                    <span class="title ml-3 pt-3">Настройте фильтры:</span>
                </div>
                <form>
                    <div class="position-relative mt-3">
                        <input name='query' type="text" class="pl-4 pr-5 py-4 content-block filter-search" placeholder="Я ищу.." value="{{isset($query) && $query != null ? $query : ''}}">
                        <i class="far fa-search searchFilterIcon"></i>
                    </div>
                    <span id="mobile-rubric" class="mt-4 p-4 content-block filter filter-rubric d-flex justify-content-between">
                        <input type="text" class="remove-input" id='input-mobile-rubric' name="rubric" value='{{isset($rubric_id) ? $rubric_id : ''}}'>
                        <span style="color: #1e56b2" id="span-mobile-rubric">{{isset($culture_name) ? $culture_name : ''}}</span>
                        <span><i class="far fa-chevron-right"></i></span>
                    </span>
                    <span id="mobile-region" class="mt-4 p-4 content-block filter filter-region d-flex justify-content-between">
                        <input type="text" class="remove-input" id='input-mobile-region' name="region" value='{{isset($region) ? $region: ''}}'>
                        <span style="color: #1e56b2"  id="span-mobile-region">{{isset($region_name) ? $region_name : ''}}</span>
                        <span><i class="far fa-chevron-right"></i></span>
                    </span>
                    <button class="remove-style-btn show showCompanies" type="submit">Показать компании</button>
                </form>
            </div>

            <div class="step-3 stp h-100" style="display: none;">
                <span class="back py-3 px-4 content-block d-block" step="1">
                    <span class="back" id="back">
                        <i class="far fa-chevron-left mr-1"></i>
                        Назад
                    </span>
                </span>

                <div class="scroll">
                    @if(isset($rubricGroups))
                        @foreach($rubricGroups as $index_group => $rubricGroup)
                            <span class="rubric px-4 py-3 my-3 content-block d-flex justify-content-between"  group="{{$rubricGroup['id']}}">
                                <span>{{$rubricGroup['title']}}</span>
                                <span><i class="far fa-chevron-right"></i></span>
                            </span>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="step-3-1 stp h-100" style="display: none;">
                <span class="back py-3 px-4 content-block d-block" step="3">
                    <span id="back3">
                        <i class="far fa-chevron-left mr-1"></i>
                        Назад
                    </span>
                </span>
                <div class="scroll">
                    @if(isset($rubricGroups))
                        @foreach($rubricGroups as $index_group => $rubricGroup)
                            @foreach($rubricGroup['comp_topic'] as $index_culture => $culture)
                                <span class="culture px-4 py-3 my-3 content-block d-flex justify-content-between" group="{{$rubricGroup['id']}}" rubric="{{$culture['id']}}">
                                    <span style="color: #1e56b2">{{$culture['title']}} &nbsp;</span>
                                    @if($culture['cnt'] > 0)
                                        <span class="companyCount small">({{$culture['cnt']}})</span>
                                    @endif
                                    <span><i class="far fa-chevron-right"></i></span>
                                </span>
                            @endforeach
                        @endforeach
                    @endif
                </div>

            </div>
            <div class="step-4 stp h-100" style="display: none;">
                <span class="back py-3 px-4 content-block d-block">
                  <span id="back2">
                      <i class="far fa-chevron-left mr-1"></i>
                      Назад
                  </span>
                </span>
                <div class="scroll">
                    @if(isset($regions))
                        @foreach($regions as $index_region => $region)
                            <span class="region px-4 py-3 my-3 content-block d-flex justify-content-between" region="{{ $region['translit'] }}">
                                @if($region['name'] == 'Вся Украина' or $region['name'] == 'АР Крым')
                                    <span style="color: #1e56b2">{{$region['name']}}</span>
                                    <span class="companyCount small">({{$region['count_items']}})</span>
                                @else
                                    <span style="color: #1e56b2">{{$region['name']}} область</span>
                                    <span class="companyCount small">({{$region['count_items']}})</span>
                                @endif
                                <span>
                                    <i class="far fa-chevron-right"></i>
                                 </span>
                            </span>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
