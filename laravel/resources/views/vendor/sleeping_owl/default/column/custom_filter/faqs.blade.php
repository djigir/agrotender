<?php
    $groups = \App\Models\Faq\FaqGroup::join('faq_group_lang', 'faq_group.id', '=', 'faq_group_lang.group_id')->select('faq_group.id', 'type_name')->orderBy('type_name')->get();
?>

<form method="GET">
    <div class="display-filters-top table table-default display-filters">
        <div data-index="2">
            <a href="{{Request::url().'/create'}}" class="btn btn-primary btn-create"><i class="fas fa-plus"></i> Новая запись</a>
        </div>
        <div data-index="1">
            <select style="width:180px;" data-type="select" name="group_id" class="form-control input-select column-filter">
                <option @if(!request('group_id')) selected="selected" @endif  value="" >Все группы</option>
                @foreach($groups as $group)
                    <option value="{{$group->id}}" @if(request('group_id') == $group->id) selected="selected" @endif >{{$group->type_name}}</option>
                @endforeach
            </select>
        </div>
        <div data-index="6">
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


