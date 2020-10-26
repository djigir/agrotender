
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
                        <span id="span-mobile-rubric">{{$culture_name}}</span>
                        <span><i class="far fa-chevron-right"></i></span>
                    </span>
                    <span id="mobile-region" class="mt-4 p-4 content-block filter filter-region d-flex justify-content-between">
                        <input type="text" class="remove-input" id='input-mobile-region' name="region" value='{{isset($region) ? $region: ''}}'>
                        <span id="span-mobile-region">{{$region_name}}</span>
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
                                <span class="culture px-4 py-3 my-3 content-block d-flex justify-content-between " group="{{$rubricGroup['id']}}" rubric="{{$culture['id']}}">
                                    <span>{{$culture['title']}} &nbsp;
    {{--                                            <span class="companyCount small">({$rgi['count']})</span>--}}
                                    </span>
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
                                    <span>{{$region['name']}}</span>
                                @else
                                    <span>{{$region['name']}} область</span>
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
