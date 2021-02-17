<?php
    $tgroups = \App\Models\Comp\CompTgroups::orderBy('title', 'asc')->get();
?>

<form method="GET">
    <div class="display-filters-top table table-default display-filters">
        <div data-index="2">
            <a href="{{Request::url().'/create'}}" class="btn btn-primary btn-create"><i class="fas fa-plus"></i> Новая запись</a>
        </div>

        <div data-index="1">
            <select data-type="select" name="group_id" class="form-control input-select column-filter">
                <option @if(!request('obl_id')) selected="selected" @endif  value="" >Все рубрики</option>
                @foreach($tgroups as $group)
                    <option value="{{$group->id}}" @if(request('group_id') == $group->id) selected="selected" @endif >{{$group->title}}</option>
                @endforeach
            </select>
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
