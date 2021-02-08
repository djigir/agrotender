<?php
    $tgroups = \App\Models\ADV\AdvTorgTgroups::orderBy('sort_num')->get();
    $topics = \App\Models\ADV\AdvTorgTopic::orderBy('sort_num')->orderBy('title')->get();
?>

<div class="card-heading card-header">
    <a href="{{Request::url().'/create'}}" class="btn btn-primary btn-create">
        <i class="fas fa-plus"></i> Новая запись
    </a>
    <div class="pull-right block-actions"></div>
</div>
@foreach($tgroups as $tgroup)
    <div class="content body">
        <div class="card form-elements w-100">
            <div class="card-body">
                <div class="form-elements w-100">
                    <details>
                    <summary style="font-size: 25px; font-weight: bold">{{$tgroup->title}}</summary>
                    @foreach($topics->where('menu_group_id', $tgroup->id)->where('parent_id', 0) as $topic)
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-6">
                            <table data-id="T3o01Ek6qt" data-order="[[0,&quot;asc&quot;]]"
                                   data-url="{{Request::url().'/async/firstdatatables'}}"
                                   data-payload="[]"
                                   class="table-primary table-hover th-center table datatables dataTable no-footer"
                                   style="width: 100%;" id="DataTables_Table_0" role="grid"
                                   aria-describedby="DataTables_Table_0_info">
                                <colgroup>
                                    <col width="400px">
                                    <col width="280px">
                                </colgroup>
                                <thead></thead>
                                <tbody>
                                    <tr role="row">
                                        <td>
                                            <div class="row-text text-center">
                                                <span style="font-size: 18px;">{{$topic->title}}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="table-control-btn">
                                                <a href="{{Request::url().'/'.$topic->id.'/edit'}}" class="btn-primary btn btn-xs"
                                                   title="" data-toggle="tooltip"
                                                   data-original-title="Редактировать">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{Request::url().'/'.$topic->id.'/delete'}}" method="POST" style="display:inline-block;">
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <input type="hidden" name="_method" value="delete">
                                                <button class="btn-danger btn-delete btn btn-xs" title="" data-toggle="tooltip" data-original-title="Удалить">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="panel-table card-body pt-0 pl-0 pr-0">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer" style="margin-bottom: 30px;">
                                    <table data-id="T3o01Ek6qt" data-order="[[0,&quot;asc&quot;]]"
                                           data-url="{{Request::url().'/async/firstdatatables'}}"
                                           data-payload="[]"
                                           class="table-primary table-hover th-center table datatables dataTable no-footer"
                                           style="width: 100%;" id="DataTables_Table_0" role="grid"
                                           aria-describedby="DataTables_Table_0_info">
                                        <colgroup>
                                            <col width="350px">
                                            <col width="250px">
                                        </colgroup>
                                        <thead>
                                        <tr role="row">
                                            <th class="row-header" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" style="width: 133.32px;" aria-sort="ascending" aria-label="Название: activate to sort column descending">
                                                Название
                                            </th>
                                            <th class="row-header" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" style="width: 101.32px;" aria-label="Значения: activate to sort column ascending">
                                                Количество
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($topics->where('parent_id', $topic->id) as $topic_cult)
                                            <tr role="row" class="odd">
                                                <td >
                                                    <div class="row-text text-center">
                                                        {{$topic_cult->title}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="row-text text-center">
                                                        {{\App\Models\ADV\AdvTorgPost::where(['topic_id' => $topic_cult->id, 'archive' => 0, 'active' => 1])->count()}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="table-control-btn">
                                                        <a href="{{Request::url().'/'.$topic_cult->id.'/edit'}}" class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                                           data-original-title="Редактировать">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <form action="{{Request::url().'/'.$topic_cult->id.'/delete'}}" method="POST" style="display:inline-block;">
                                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                        <input type="hidden" name="_method" value="delete">
                                                        <button class="btn-danger btn-delete btn btn-xs" title="" data-toggle="tooltip" data-original-title="Удалить">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </details>
                </div>
            </div>
        </div>
    </div>
@endforeach

