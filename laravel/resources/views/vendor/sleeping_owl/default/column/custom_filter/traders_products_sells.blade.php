<?php
    $groups = \App\Models\Traders\TradersProductGroups::get();
    $groups_lang = \App\Models\Traders\TradersProductGroupLanguage::whereIn('item_id', $groups->pluck('id'))->get();
?>

<form method="GET">
    <div class="display-filters-top table table-default display-filters">
        <div data-index="2">
            <a href="{{Request::url().'/create'}}" class="btn btn-primary btn-create"><i class="fas fa-plus"></i>
                Новая запись
            </a>
        </div>

        <div data-index="1">
            <select data-type="select" name="group_id" class="form-control input-select column-filter">
                <option @if(!request('group_id')) selected="selected" @endif value="" >Все группы</option>
                @foreach($groups_lang as $group)
                    <option value="{{$group->item_id}}" @if(request('group_id') == $group->item_id) selected="selected" @endif >{{$group->name}}</option>
                @endforeach
            </select>
        </div>

        <div data-index="2">
            <div>
                <input type="text" style="width: 180px" data-type="text" placeholder="По названию" class="form-control column-filter" name="name" value="{{request('name')}}">
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


