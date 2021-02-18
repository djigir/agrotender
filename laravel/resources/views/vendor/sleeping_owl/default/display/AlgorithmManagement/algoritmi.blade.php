<?php
    $algoritmi = \App\Models\Preferences\Preferences::select('value', 'id')->get();
    $LABELS = [
        13 => 'Макс. кол-во предложений',
        14 => 'Макс. кол-во объявлений',
        15 => 'Публиковать объяв. без премодер',
        16 => 'Мин. сумма пополнения',
        17 => 'Время между беспл. апом',
        18 => 'Время до деактивации объявл',
    ];
?>

<div class="content body">
    <div class="links-row"></div>
    <div class="card card-default">
        <div class="panel-table card-body pt-0 pl-0 pr-0">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <table data-id="T3o01Ek6qt" data-order="[[0,&quot;asc&quot;]]"
                       data-url="{{Request::url().'/async/firstdatatables'}}"
                       data-payload="[]"
                       class="table-primary table-hover th-center table datatables dataTable no-footer"
                       style="width: 100%;" id="DataTables_Table_0" role="grid"
                       aria-describedby="DataTables_Table_0_info">
                    <colgroup>
                        <col width="850px">
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
                            Значения
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($algoritmi as $algoritm)
                        @if(isset($LABELS[$algoritm->id]))
                        <?php
                            $url = Request::url() . '/' . $algoritm->id . '/edit';
                        ?>
                        <tr role="row" class="odd">
                            <td >
                                <div class="row-text text-center">
                                    {{$LABELS[$algoritm->id]}}
                                </div>
                            </td>
                            <td>
                                <div class="row-text text-center">
                                    {{$algoritm->value}}
                                </div>
                            </td>
                            <td>
                                <div class="table-control-btn">
                                    <a href="{{$url}}" class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                       data-original-title="Редактировать">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
