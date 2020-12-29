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
                    $traders[$key_uah[0]]['date_change'] = $where_place_id->where('curtype', 1)->first()->change_date;
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
                    $change_usd = $date_expired_diff <= $traders[$index]['date_change'] ? round($traders[$index]->costval_usd - $traders[$index]->costval_old_usd) : 0;

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
    <div class="new_container pb-5 pb-sm-4 pt-4 mb-4 scroll-x" port="{{$port_translit}}" region="{{$region_translit}}" culture="{{$culture_translit}}" id="traders_table_param">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
            <table class="sortTable sortable dTable dataTable no-footer"  id="DataTables_Table_0" role="grid">
                <thead>
                <tr role="row">
                    <th tabindex="0" rowspan="1" colspan="1" style="min-width: 258px;" class="traders_table_company_th">Компании</th>
                    <th class="sth sorting sort_hover" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="UAH : activate to sort column descending" style="min-width: 110px;">UAH <i class="fas fa-sort" style="font-size: 12px;"></i></th>
                    <th class="sth sorting sort_hover" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="USD : activate to sort column descending" style="min-width: 110px;">USD <i class="fas fa-sort" style="font-size: 12px;"></i></th>
                    <th class="sth sorting sort_hover" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Дата : activate to sort column descending" style="min-width: 110px;">Дата <i class="sort-date-icon fas fa-sort" style="font-size: 12px;"></i></th>
                    <th tabindex="0" rowspan="1" colspan="1" style="min-width: 222px;text-align: left">Место закупки</th>
                </tr>
                </thead>
                <tbody id="traders_table">
                @foreach($traders as $index => $trader)
                    <tr role="row" class="{{$index%2 == 0 ? 'even' : 'odd'}} {{$trader->trader_premium == 1 || $trader->trader_premium == 2 ? 'vip': 'default'}}">
                        <td>
                            <a class="d-flex align-items-center" href="{{$type_traders == 1 ? route('company.forwards', $trader->id) : route('company.index', $trader->id)}}">
                                <img class="logo mr-3" src="https://agrotender.com.ua/pics/comp/4964_89599.jpg">
                                <span class="title">{!! $trader->title !!}</span>
                            </a>
                        </td>
                        <td class="uah">
                            @if($trader->curtype == 0)
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class="price replace_numbers_js">{{round($trader->costval, 1)}}</span>
                                    @if($trader->change_price != 0)
                                        <span class="price-{{$trader->change_price_type}}">  &nbsp;
                                                <img src="/app/assets/img/price-{{$trader->change_price_type}}.svg">
                                                <span class="replace_numbers_js">{{$trader->change_price}}</span>
                                            </span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="usd">
                            @if($trader->curtype == 1 || isset($trader->costval_usd))
                                <div class="d-flex align-items-center justify-content-center">
                                    @if(isset($trader->costval_usd))
                                        <span class="price replace_numbers_js">{{round($trader->costval_usd, 1)}}</span>
                                    @else
                                        <span class="price replace_numbers_js" >{{round($trader->costval, 1)}}</span>
                                    @endif
                                    @if(isset($trader->change_price_usd) && $trader->change_price_usd != 0)
                                        <span class="price-{{ $trader->change_price_type_usd}}">  &nbsp;
                                                <img src="/app/assets/img/price-{{ $trader->change_price_type_usd}}.svg">
                                                <span  class="replace_numbers_js">{{$trader->change_price_usd}}</span>
                                            </span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td data-sorttable-customkey="20201101">
                            <?php
                                $class = '';

                                if(Carbon\Carbon::parse($trader->change_date)->toDateString() == Carbon\Carbon::now()->toDateString() && $type_traders == 0){
                                    $class = 'today';
                                }

                                if(Carbon\Carbon::parse($trader->dt)->toDateString() == Carbon\Carbon::now()->toDateString() && $type_traders == 0){
                                    $class = 'today';
                                }

                                $day = mb_convert_case(\Jenssegers\Date\Date::parse($trader->change_date)->format('d'), MB_CASE_TITLE, "UTF-8");
                                $month = mb_convert_case(\Jenssegers\Date\Date::parse($trader->change_date)->format('F'), MB_CASE_TITLE, "UTF-8");

                                if($type_traders == 1){
                                    $day = mb_convert_case(\Jenssegers\Date\Date::parse($trader->dt)->format('F'), MB_CASE_TITLE, "UTF-8");
                                    $month = mb_convert_case(\Jenssegers\Date\Date::parse($trader->dt)->format('Y'), MB_CASE_TITLE, "UTF-8");
                                }
                            ?>

                            @if($type_traders == 0)
                                <span class="desktop-table-month {{$class}}">{{$day}} {{$month}}</span>
                                <span class="tablet-table-month {{$class}}">{{$day}} {{\Illuminate\Support\Str::limit($month, 3, $end='')}}</span>
                            @else
                                <span class="desktop-table-month {{$class}}">{{$day}} {{$month}}</span>
                                <span class="tablet-table-month {{$class}}">{{ \Illuminate\Support\Str::limit($day, 3, $end='')}} {{$month}}</span>
                            @endif
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
        <div class="text-center mt-5">
        </div>
    </div>

    @if($seo_text && $type_traders == 0)
        <div class="container mt-4 mb-5">
            {!! $seo_text !!}
        </div>
    @endif
@endif

@if($type_traders == 0)
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var add_count_item = 30;
        var count = 0;
        var start = add_count_item;
        var execute_request = true;

        var region = $('#traders_table_param').attr('region');
        var port = $('#traders_table_param').attr('port');
        var culture = $('#traders_table_param').attr('culture');

        $(window).scroll(function () {
            if (execute_request && document.documentElement.scrollHeight - document.documentElement.scrollTop < document.documentElement.clientHeight + 3000 && count < 1) {
                count++;
                $.ajax({
                    url: window.location.origin + '/traders/get_traders_table',
                    method: 'GET',
                    data: {
                        region: region,
                        port: port,
                        culture: culture,
                        start: start,
                    },
                    success: function (data) {
                        $('#traders_table').append(data);
                        count = 0;
                        start += add_count_item;

                        if (data == '') {
                            execute_request = false;
                        }
                    }
                });
            }
        });

    </script>
@endif
