{{--{{dd($traders->toArray()[0])}}--}}
@if($traders->count() == 0)
    @include('traders.block-info.traders_forwards')
@else
    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer pb-5">
        <table class="sortTable sortable dTable dataTable no-footer"  id="DataTables_Table_0" role="grid">
            <thead>
            <tr role="row">
                <th class="sth table_haeder_th_cell" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                    aria-label="Компании: activate to sort column ascending" style="width: 350px;text-align: left;">Компании
                </th>
                <th class="sth sorting table_haeder_th_cell" tabindex="1" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                    aria-label="UAH : activate to sort column descending" style="width: auto;">UAH
                    <i class="fas fa-sort" style="font-size: 12px;"></i>
                </th>
                <th class="sth sorting table_haeder_th_cell" tabindex="2" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                    aria-label="USD : activate to sort column descending" style="width: auto;">USD
                    <i class="fas fa-sort" style="font-size: 12px;"></i>
                </th>
                <th class="sth sorting table_haeder_th_cell" tabindex="3" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                    aria-label="Дата : activate to sort column descending" style="width: auto;">Дата
                    <i class="sort-date-icon fas fa-sort" style="font-size: 12px;"></i>
                </th>
                <th class="sth table_haeder_th_cell" tabindex="4" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                    aria-label="Место закупки: activate to sort column ascending" style="text-align: left;min-width: 260px;">Место закупки
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($traders as $index_tr => $trader)
                @foreach($trader->places as $index => $place)
                    @if($currency != null)
                    <tr role="row" class="{{$index%2 == 0 ? 'even' : 'odd'}} {{$trader->trader_premium == 1 ? 'vip': ''}}">
                        <td class="text-left">
                            <div class="d-flex align-items-center">
                                <a href="{{$type_traders == 1 ? route('company.forwards', $trader->id) : route('company.index', $trader->id)}}">
                                    <img class="logo mr-3" src="/pics/comp/4964_89599.jpg">
                                </a>
                                <a  href="{{$type_traders == 1 ? route('company.forwards', $trader->id) : route('company.index', $trader->id)}}">
                                    <span class="title">{!! $trader->title !!}</span>
                                </a>
                            </div>
                        </td>
                        <td class="uah">
                            @if($place->pivot->curtype == 0)
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class="price table_price">{{round($place->pivot->costval, 1)}}</span>
                                </div>
                            @endif
                        </td>
                        <td class="usd">
                            @if($place->pivot->curtype == 1)
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class="price table_price">{{round($place->pivot->costval, 1)}}</span>
                                </div>
                            @endif
                        </td>
                        <td data-sorttable-customkey="20201101">
                            <span data-date="20201101">
                                {{mb_convert_case(\Jenssegers\Date\Date::parse($place->pivot->dt)->format('F y'), MB_CASE_TITLE, "UTF-8")}}
                            </span>
                        </td>
                        <td>
                           <span class="location">{{$type_place == 0 ? $place['regions'][0]['name'].' обл.' : $place['traders_ports'][0]['lang']['portname']}}</span>
                           <br>
                           <span class="place">{!! $place->place !!}</span>
                        </td>
                    </tr>
                    @else
                        @if($place->pivot->curtype == $currency)
                        <tr role="row" class="{{$index%2 == 0 ? 'even' : 'odd'}} {{$trader->trader_premium == 1 ? 'vip': ''}}">
                            <td class="text-left">
                                <div class="d-flex align-items-center">
                                    <a href="{{$type_traders == 1 ? route('company.forwards', $trader->id) : route('company.index', $trader->id)}}">
                                        <img class="logo mr-3" src="/pics/comp/4964_89599.jpg">
                                    </a>
                                    <a  href="{{$type_traders == 1 ? route('company.forwards', $trader->id) : route('company.index', $trader->id)}}">
                                        <span class="title">{!! $trader->title !!}</span>
                                    </a>
                                </div>
                            </td>
                            <td class="uah">
                                @if($place->pivot->curtype == 0)
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="price table_price">{{round($place->pivot->costval, 1)}}</span>
                                    </div>
                                @endif
                            </td>
                            <td class="usd">
                                @if($place->pivot->curtype == 1)
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="price table_price">{{round($place->pivot->costval, 1)}}</span>
                                    </div>
                                @endif
                            </td>
                            <td data-sorttable-customkey="20201101">
                            <span data-date="20201101">
                                {{mb_convert_case(\Jenssegers\Date\Date::parse($place->pivot->dt)->format('F y'), MB_CASE_TITLE, "UTF-8")}}
                            </span>
                            </td>
                            <td>
                                <span class="location">{{$type_place == 0 ? $place['regions'][0]['name'].' обл.' : $place['traders_ports'][0]['lang']['portname']}}</span>
                                <br>
                                <span class="place">{!! $place->place !!}</span>
                            </td>
                        </tr>
                        @endif
                    @endif
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
    <!--
        <table class="sortTable sortable">
            <tbody>
            @foreach($traders as $index_tr => $trader)
                @foreach($trader->places as $index => $place)
                    <tr class="{{$trader->trader_premium == 1 ? 'vip': ''}}">
                        <td>
                            <div class="d-flex align-items-center price-div">
                                <img class="logo mr-3" src="/pics/c/Y4RqJIw3zNFX.jpg" data-toggle="tooltip" data-placement="top" title="{!! $trader->title !!}">
                                <a class="flex-1" href="{{$type_traders == 1 ? route('company.forwards', $trader->id) : route('company.index', $trader->id)}}">
                                    <span class="m-price">{{$place->pivot->curtype == 1 ? 'USD: ' : 'UAH: '}}
                                        <span class="price table_price">
                                            {{round($place->pivot->costval, 1)}}
                                        </span>
                                    </span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr class="t2 {{$trader->trader_premium == 1 ? 'vip': ''}}">
                        <td style="border-bottom: 1px solid #295ca1;">
                            <div class="d-flex align-items-center justify-content-center">
                                <span data-toggle="tooltip" data-placement="top" class="d-block">
                                    {{mb_convert_case(\Jenssegers\Date\Date::parse($place->pivot->dt)->format('F y'), MB_CASE_TITLE, "UTF-8")}}
                                </span>
                                <a href="{{$type_traders == 1 ? route('company.forwards', $trader->id) : route('company.index', $trader->id)}}" class="d-block flex-1">
                                    <span class="location d-block">{{$type_place == 0 ? $place['region'][0]['name'].' обл.' : $place['traders_ports'][0]['lang']['portname']}}</span>
                                    <span class="place d-block">{!! $place->place !!}</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table> -->
@endif
