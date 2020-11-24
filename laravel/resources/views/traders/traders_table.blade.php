@include('traders.block-info.traders')

@if($traders->count() == 0)
    @include('traders.block-info.traders_forwards')
@else
    <?php
        $date_expired_diff = \Carbon\Carbon::now()->subDays(7)->format('Y-m-d');
        if($type_traders != 1){
            foreach ($traders as $index => $trader) {
                if ($traders->where('place_id', $trader->place_id)->count() > 1 && $traders->where('type_id', '=', $trader->type_id))
                {
                    $where_place_id = $traders->where('place_id', $trader->place_id);

                    $key_uah = $where_place_id->where('curtype', 0)->keys();
                    $key_usd = $where_place_id->where('curtype', 1)->keys();

                    if(isset($key_uah[0])){
                        $traders[$key_uah[0]]['costval_usd'] = $where_place_id->where('curtype', 1)->first()->costval;
                        $traders[$key_uah[0]]['costval_old_usd'] = $where_place_id->where('curtype', 1)->first()->costval_old;
                    }

                    if(isset($key_usd[0])){
                        unset($traders[$key_usd[0]]);
                    }
                }

                if(isset($traders[$index]))
                {
                    $change = $date_expired_diff <= $traders[$index]->change_date ? round($traders[$index]->costval - $traders[$index]->costval_old) : 0;
                    $traders[$index]['change_price'] = $change;

                    $traders[$index]['change_price_type'] = $change > 0 ? 'up' : 'down';

                    if(!$traders[$index]->change_date || !$change){
                        $traders[$index]['change_price_type'] = '';
                    }

                    if(isset($traders[$index]['costval_usd']))
                    {
                        $change_usd = $date_expired_diff <= $traders[$index]->change_date ? round($traders[$index]->costval_usd - $traders[$index]->costval_old_usd) : 0;
                        $traders[$index]['change_price_usd'] = $change_usd;

                        if(!$traders[$index]->change_date || !$change_usd){
                            $traders[$index]['change_price_type_usd'] = '';
                        }

                        $traders[$index]['change_price_type_usd'] = $change_usd > 0 ? 'up' : 'down';
                    }
                }
            }
        }
    ?>
    <div class="container pb-5 pb-sm-4 pt-4 mb-4 scroll-x">
        @if(!$isMobile)
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                <table class="sortTable sortable dTable dataTable no-footer"  id="DataTables_Table_0" role="grid">
                    <thead>
                        <tr role="row">
                            <th class="sth sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                aria-label="Компании: activate to sort column ascending" style="width: 249px;">Компании
                            </th>
                            <th class="sth sorting" tabindex="1" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                aria-label="UAH : activate to sort column descending" style="width: 77px;">UAH
                                <i class="fas fa-sort" style="font-size: 12px;"></i>
                            </th>
                            <th class="sth sorting" tabindex="2" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                aria-label="USD : activate to sort column descending" style="width: 76px;">USD
                                <i class="fas fa-sort" style="font-size: 12px;"></i>
                            </th>
                            <th class="sth sorting" tabindex="3" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                aria-label="Дата : activate to sort column descending" style="width: 101px;">Дата
                                <i class="sort-date-icon fas fa-sort" style="font-size: 12px;"></i>
                            </th>
                            <th class="sth sorting" tabindex="4" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                aria-label="Место закупки: activate to sort column ascending" style="width: 195px;">Место закупки
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($traders as $index => $trader)
                        <tr role="row" class="{{$index%2 == 0 ? 'even' : 'odd'}} {{$trader->trader_premium == 1 ? 'vip': ''}}">
                            <td>
                                <a class="d-flex align-items-center" href="{{$type_traders == 1 ? route('company.forwards', $trader->id) : route('company.index', $trader->id)}}">
                                    <img class="logo mr-3" src="/pics/comp/4964_89599.jpg">
                                    <span class="title">{!! $trader->title !!}</span>
                                </a>
                            </td>
                            <td class="uah">
                                @if($trader->curtype == 0)
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="price">{{round($trader->costval, 1)}}</span>
                                         @if($trader->change_price != 0)
                                             <span class="price-{{$trader->change_price_type}}">  &nbsp;
                                                <img src="/app/assets/img/price-{{$trader->change_price_type}}.svg">
                                                <span>{{$trader->change_price}}</span>
                                            </span>
                                         @endif
                                    </div>
                                @endif
                            </td>
                            <td class="usd">
                                @if($trader->curtype == 1 || isset($trader->costval_usd))
                                    <div class="d-flex align-items-center justify-content-center">
                                        @if(isset($trader->costval_usd))
                                            <span class="price">{{round($trader->costval_usd, 1)}}</span>
                                        @else
                                            <span class="price">{{round($trader->costval, 1)}}</span>
                                        @endif
                                        @if(isset($trader->change_price_usd) && $trader->change_price_usd != 0)
                                            <span class="price-{{ $trader->change_price_type_usd}}">  &nbsp;
                                                <img src="/app/assets/img/price-{{ $trader->change_price_type_usd}}.svg">
                                                <span>{{$trader->change_price_usd}}</span>
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td data-sorttable-customkey="20201101">
                        <span class="{{$trader->dt == \Carbon\Carbon::now()->toDateString() ? 'today' : ''}}">
                            @if($type_traders == 1)
                                {{mb_convert_case(\Jenssegers\Date\Date::parse($trader->dt)->format('F Y'), MB_CASE_TITLE, "UTF-8")}}
                            @else
                                {{mb_convert_case(\Jenssegers\Date\Date::parse($trader->change_date)->format('d F'), MB_CASE_TITLE, "UTF-8")}}
                            @endif
                        </span>
                            </td>
                            <td>
                                @if($type_place == 0)
                                    <span class="location">{{$trader->portname != null ? $trader->portname : $trader->region.' обл.'}}</span>
                                @else
                                    <span class="location">{{$trader->portname != null ? $trader->portname : $trader->region.' обл.'}}</span>
                                @endif
                                <br>
                                <span class="place">{!! $trader->place !!}</span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <table class="sortTable sortable">
                <tbody>
                    @foreach($traders as $index => $trader)
                        <tr class="{{$trader->trader_premium == 1 ? 'vip': ''}}">
                            <td>
                                <div class="d-flex align-items-center price-div">
                                    <img class="logo mr-3" src="/pics/c/Y4RqJIw3zNFX.jpg" data-toggle="tooltip" data-placement="top" title="{!! $trader->title !!}">
                                    <a class="flex-1" href="{{$type_traders == 1 ? route('company.forwards', $trader->id) : route('company.index', $trader->id)}}">
                                        @if($trader->curtype == 0)
                                        <span class="m-price">
                                                UAH:
                                                @if($trader->change_price != 0)
                                                    <span class="price-{{$trader->change_price_type}}">{{round($trader->costval, 1)}}  &nbsp;
                                                        <i class="fas fa-chevron-{{$trader->change_price_type}}"></i>{{$trader->change_price}}
                                                    </span>
                                                @else
                                                    <span class="price">
                                                        {{round($trader->costval, 1)}}
                                                    </span>
                                                @endif
                                        </span>
                                        @endif

                                        @if($trader->curtype == 1 || isset($trader->costval_usd))
                                            <span>
                                                USD:
                                                @if(isset($trader->costval_usd))
                                                    @if($trader->change_price != 0)
                                                        <span class="price-{{$trader->change_price_type_usd}}">{{round($trader->costval_usd, 1)}}  &nbsp;
                                                            <i class="fas fa-chevron-{{$trader->change_price_type_usd}}"></i>{{$trader->change_price_usd}}
                                                        </span>
                                                    @else
                                                        <span class="price">{{round($trader->costval_usd, 1)}}</span>
                                                    @endif

                                                @else
                                                    @if($trader->change_price != 0)
                                                        <span class="price-{{$trader->change_price_type}}">{{round($trader->costval, 1)}}  &nbsp;
                                                            <i class="fas fa-chevron-{{$trader->change_price_type}}"></i>{{$trader->change_price}}
                                                        </span>
                                                    @else
                                                        <span class="price">{{round($trader->costval, 1)}}</span>
                                                    @endif
                                                @endif

                                            </span>
                                        @endif

                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr class="t2 {{$trader->trader_premium == 1 ? 'vip': ''}}">
                            <td style="border-bottom: 1px solid #295ca1;">
                                <div class="d-flex align-items-center justify-content-center">
                                <span data-toggle="tooltip" data-placement="top" class="d-block">
                                    {{mb_convert_case(\Jenssegers\Date\Date::parse($trader->dt)->format('d.m.Y'), MB_CASE_TITLE, "UTF-8")}}
                                </span>
                                    <a href="{{$type_traders == 1 ? route('company.forwards', $trader->id) : route('company.index', $trader->id)}}" class="d-block flex-1">
                                        @if($type_place == 0)
                                            <span class="location d-block">{{$trader->portname != null ? $trader->portname : $trader->region.' обл.'}}</span>
                                        @else
                                            <span class="location d-block">{{$trader->portname != null ? $trader->portname : $trader->region.' обл.'}}</span>
                                        @endif
                                        <span class="place d-block">{!! $trader->place !!}</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <div class="text-center mt-5">
        </div>
    </div>
@endif
