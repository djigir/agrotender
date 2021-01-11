<?php
    $banner_rotate = \App\Models\Banner\BannerRotate::where('place_id', \request()->get('id'))->get();
    $banner_rotate_confirmed = $banner_rotate->where('archive', 0)->where('inrotate', 1);
    $banner_rotate_applications = $banner_rotate->where('archive', 0)->where('inrotate', 0);
    $banner_info = \App\Models\Banner\BannerPlaces::find(\request()->get('id'));

    $PAGE = [
        0 => 'Все страницы',
        1 => 'Главная',
        2 => 'Торги по регионам',
        3 => 'Остальные страницы',
    ];
    $TYPE_PAY = [
        0 => 'Подарок',
        1 => 'Наличными',
        2 => 'Безнал',
        3 => 'Webmoney',
    ];

?>

<div class="card-heading card-header" style="margin-bottom: 25px">
    <a href="{{Request::url()}}/create?place_id={{\request()->get('id')}}" class="btn btn-primary btn-create" target="_blank">
        <i class="fas fa-plus"></i> Новая запись
    </a>
    <div class="pull-right block-actions"></div>
</div>

<div class="content body">
    <div class="links-row"></div>
    <div class="card card-default">
        <div class="card-heading card-header" style="margin-bottom: 25px">
            <div class="block-actions text-center">
                <span>Список подтвержденных ротаций - {{$PAGE[$banner_info->page_type]}} - позиция № {{$banner_info->position}} ({{$banner_info->name}})</span>
            </div>
        </div>
        <div class="panel-table card-body pt-0 pl-0 pr-0">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="">
                    <div id="DataTables_Table_0_processing" class="dataTables_processing panel panel-default"
                         style="display: none;"><i class="fas fa-spinner fa-5x fa-spin"></i></div>
                </div>
                <table data-id="i5aACgpnkj" data-order="[[0,&quot;asc&quot;]]"
                       data-url="{{Request::url().'/async/firstdatatables'}}"
                       data-payload="[]"
                       class="table-primary table-hover th-center table datatables dataTable no-footer"
                       style="width: 100%;" id="DataTables_Table_0" role="grid"
                       aria-describedby="DataTables_Table_0_info">
                    <colgroup>
                        <col width="250px">
                        <col width="150px">
                        <col width="150px">
                        <col width="350px">
                        <col width="350px">
                        <col width="300px">
                    </colgroup>
                    <thead>

                    <tr role="row">
                        <th class="row-header" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Дата заявки">
                            Дата заявки
                        </th>

                        <th class="row-header " tabindex="1" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Отправитель">
                            Отправитель
                        </th>

                        <th class="row-header " tabindex="2" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Тип оплаты">
                            Тип оплаты
                        </th>

                        <th class="row-header" tabindex="3" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Желаемый период">
                            Желаемый период
                        </th>

                        <th class="row-header" tabindex="4" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Назначенный период">
                            Назначенный период
                        </th>

                        <th class="row-header" tabindex="5" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Файл">
                            Файл
                        </th>
                    </tr>
                    </thead>
                    <thead class="table-hover table-hover">
                    <tr></tr>
                    </thead>
                    <tbody>
                    @foreach($banner_rotate_confirmed as $confirmed)
                        <?php

                            $url_edit = Request::url() . '/' . $confirmed->id . '/edit?id='.\request()->get('id');
                            $url_delete = Request::url() . '/' . $confirmed->id . '/delete';
                        ?>
                        <tr role="row" class="odd">
                            <td><div class="row-text text-center">{{$confirmed->add_date}}</div></td>
                            <td><div class="row-text text-center">{{$confirmed->cont_name}} <a href="mailto:{{$confirmed->cont_mail}}">{{$confirmed->cont_mail}}</a></div></td>
                            <td><div class="row-text text-center">{{$TYPE_PAY[$confirmed->pay_type]}}</div></td>
                            <td><div class="row-text text-center">{{$confirmed->dt_start_req}} - {{$confirmed->dt_end_req}}</div></td>
                            <td><div class="row-text text-center">{{$confirmed->dt_start}} - {{$confirmed->dt_end}}</div></td>
                            <td><div class="row-text text-center">{{$confirmed->ban_file}}</div></td>
                            <td>
                                <div class="table-control-btn">
                                    <a href="{{$url_edit}}"
                                       class="btn-primary btn btn-xs" title="" data-toggle="tooltip" data-original-title="Редактировать">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{$url_delete}}" method="POST"
                                          style="display:inline-block;">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <input type="hidden" name="_method" value="delete">
                                        <button class="btn-danger btn-delete btn btn-xs" title="" data-toggle="tooltip" data-original-title="Удалить">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="content body">
    <div class="links-row"></div>
    <div class="card card-default">
        <div class="card-heading card-header" style="margin-bottom: 25px">
            <div class="block-actions text-center">
                <span>Список заявок на ротацию - {{$PAGE[$banner_info->page_type]}} - позиция № {{$banner_info->position}} ({{$banner_info->name}})</span>
            </div>
        </div>
        <div class="panel-table card-body pt-0 pl-0 pr-0">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="">
                    <div id="DataTables_Table_0_processing" class="dataTables_processing panel panel-default"
                         style="display: none;"><i class="fas fa-spinner fa-5x fa-spin"></i></div>
                </div>
                <table data-id="i5aACgpnkj" data-order="[[0,&quot;asc&quot;]]"
                       data-url="{{Request::url().'/async/firstdatatables'}}"
                       data-payload="[]"
                       class="table-primary table-hover th-center table datatables dataTable no-footer"
                       style="width: 100%;" id="DataTables_Table_0" role="grid"
                       aria-describedby="DataTables_Table_0_info">
                    <colgroup>
                        <col width="250px">
                        <col width="250px">
                        <col width="350px">
                        <col width="250px">
                        <col width="350px">
                        <col width="200px">
                    </colgroup>
                    <thead>

                    <tr role="row">
                        <th class="row-header" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Дата заявки">
                            Дата заявки
                        </th>

                        <th class="row-header " tabindex="1" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Отправитель">
                            Отправитель
                        </th>

                        <th class="row-header " tabindex="2" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Тип оплаты">
                            Желаемый период
                        </th>

                        <th class="row-header" tabindex="3" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Желаемый период">
                            Доступно
                        </th>

                        <th class="row-header" tabindex="4" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="Назначенный период">
                            Тип оплаты
                        </th>
                    </tr>
                    </thead>
                    <thead class="table-hover table-hover">
                    <tr></tr>
                    </thead>
                    <tbody>
                    @foreach($banner_rotate_applications as $applications)
                        <?php
                            $is_busy = false;

                            if(($applications->dt_start < $applications->dt_start_req && $applications->dt_end >= $applications->dt_start_req)
                                || ($applications->dt_start < $applications->dt_end_req && $applications->dt_end >= $applications->dt_end_req)){
                                $is_busy = true;
                            }

                            $url_edit = Request::url() . '/' . $applications->id . '/edit?id='.\request()->get('id');
                            $url_delete = Request::url() . '/' . $applications->id . '/delete';
                        ?>

                        <tr role="row" class="odd">
                            <td><div class="row-text text-center">{{$applications->add_date}}</div></td>
                            <td><div class="row-text text-center">{{$applications->cont_name}} <a href="mailto:{{$applications->cont_mail}}">{{$applications->cont_mail}}</a></div></td>
                            <td><div class="row-text text-center">{{$applications->dt_start_req}} - {{$applications->dt_end_req}}</div></td>
                            <td><div class="row-text text-center"></div>{{$is_busy ? "период занят" : 'размещение доступно'}}</td>
                            <td><div class="row-text text-center">{{$TYPE_PAY[$applications->pay_type]}}</div></td>
                            <td>
                                <div class="table-control-btn">
                                    <a href="{{$url_edit}}"
                                       class="btn-primary btn btn-xs" title="" data-toggle="tooltip" data-original-title="Редактировать">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{$url_delete}}" method="POST"
                                          style="display:inline-block;">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <input type="hidden" name="_method" value="delete">
                                        <button class="btn-danger btn-delete btn btn-xs" title="" data-toggle="tooltip" data-original-title="Удалить">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

