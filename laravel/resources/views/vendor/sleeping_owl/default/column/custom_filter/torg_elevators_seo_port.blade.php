<?php
    $regions = App\Models\Regions\Regions::select('name', 'id')->orderBy('id', 'desc')->get();
?>

<form method="GET">
    <div class="display-filters-top table table-default display-filters">
        <div data-index="2">
            <a href="{{Request::url().'/create'}}" class="btn btn-primary btn-create"><i class="fas fa-plus"></i> Новая запись</a>
        </div>
        <div data-index="1">
            <select style="width:180px;" data-type="select" name="obl_id" class="form-control input-select column-filter">
                <option @if(!request('obl_id')) selected="selected" @endif  value="">Все области</option>
                @foreach($regions as $region)
                    <option value="{{$region->id}}" @if(request('obl_id') == $region->id) selected="selected" @endif >{{$region->name}}</option>
                @endforeach
            </select>
        </div>
        <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer" style="min-height: 0">
            <div id="DataTables_Table_1_filter" class="dataTables_filter" style="margin-bottom: 0">
                <input id="search" type="search" class="form-control input-sm" placeholder="Поиск" aria-controls="DataTables_Table_0">
            </div>
            <div id="DataTables_Table_1_processing" class="dataTables_processing panel panel-default" style="display: none;">
                <i class="fas fa-spinner fa-5x fa-spin"></i>
            </div>
        </div>
        <div data-index="3">
            <div class="btn-group">
                <button data-type="control" id="bntSub" class="btn btn-sm btn-primary column-filter" onclick="localStorage.clear()">
                    Фильтр
                </button>
                <a href="{{url()->current()}}" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
            </div>
        </div>

    </div>
</form>

