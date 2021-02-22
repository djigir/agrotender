<?php
    $groups = collect([
        0 => ['id' => 0, 'title' => 'Новости Украины'],
        1 => ['id' => 1, 'title' => 'Новости мира'],
        2 => ['id' => 2, 'title' => 'Другие новости'],
        3 => ['id' => 3, 'title' => 'Новости сайта'],
    ]);
?>

<form method="GET">
    <div class="display-filters-top table table-default display-filters">
        <div data-index="0">
            <a href="{{Request::url().'/create'}}" class="btn btn-primary btn-create"><i class="fas fa-plus"></i> Новая запись</a>
        </div>
        <div data-index="1">
            <select data-type="select" name="ngroup" class="form-control  column-filter">
                <option @if(request('ngroup') == null) selected="selected" @endif value="">Все группы</option>
                @foreach($groups as  $group)
                    <option @if(request('ngroup') == $group['id'] && request('ngroup') != null) selected="selected" @endif value="{{$group['id']}}">{{$group['title']}}</option>
                @endforeach
            </select>
        </div>
        <div data-index="2">
            <div>
                <input type="text"  data-type="text" placeholder="Название" class="form-control column-filter" name="title" value="{{request('title')}}">
            </div>
        </div>
        <div data-index="3">
            <div class="btn-group">
                <button data-type="control" id="bntSub" class="btn btn-sm btn-primary column-filter"
                        onclick="localStorage.clear()">
                    Фильтр
                </button>
                <a href="{{url()->current()}}" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
            </div>
        </div>
    </div>
</form>


