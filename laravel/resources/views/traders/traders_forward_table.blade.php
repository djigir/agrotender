{{--{{dd($traders)}}--}}
<div class="container pb-5 pb-sm-4 pt-4 mb-4 scroll-x">
    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
        <table class="sortTable sortable dTable dataTable no-footer" cellspacing="0" id="DataTables_Table_0"
               role="grid">
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
            @foreach($traders as $index_tr => $trader)
                @foreach($trader['traders_prices'] as $index_price => $price)
                    <tr role="row" class="{{$index_price%2 == 0 ? 'even' : 'odd'}}">
                        <td>
                            <a class="d-flex align-items-center" href="{{route('company.forwards', $trader['id'])}}">
                                <img class="logo mr-3" src="/pics/comp/4964_89599.jpg">
                                <span class="title">{{$trader['title']}}</span>
                            </a>
                        </td>
                        <td class="uah">
                            @if($price['curtype'] == 0)
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class="price">{{round($price['costval'], 1)}}</span>
                                </div>
                            @endif
                        </td>
                        <td class="usd">
                            @if($price['curtype'] == 1)
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class="price">{{round($price['costval'], 1)}}</span>
                                </div>
                            @endif
                        </td>
                        <td data-sorttable-customkey="20201101"><span data-date="20201101">{{mb_convert_case($price['date']->format('F y'), MB_CASE_TITLE, "UTF-8")}}</span></td>
                        <td>
                            <span class="location">{{$price['region']['name'].' обл.'}} </span>
                            <br>
                            <span class="place">{{$price['place']}}</span>
                        </td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center mt-5">
    </div>
</div>
{{--                @if($index_tr < 1)--}}
{{--                    <tr class="t-sub odd" cspan="1" role="row">--}}
{{--                        <td colspan="5">--}}
{{--                            <div class="row align-items-center justify-content-center">--}}
{{--                                <a href="/buyerreg" class="subscribe-table d-flex align-items-center">--}}
{{--                                    <img src="/app/assets/img/envelope.png" class="ml-3 mr-3">--}}
{{--                                    <span class="ml-3">Подписаться на изменения цен: Кукуруза</span>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td style="display: none;">--}}
{{--                            <div class="d-flex align-items-center justify-content-center"><span class="price">0</span>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td style="display: none;">--}}
{{--                            <div class="d-flex align-items-center justify-content-center"><span class="price">0</span>--}}
{{--                            </div>--}}
{{--                        </td>--}}
{{--                        <td style="display: none;"><span data-date="20170802"></span></td>--}}
{{--                        <td style="display: none;"></td>--}}
{{--                    </tr>--}}
{{--                @endif--}}
