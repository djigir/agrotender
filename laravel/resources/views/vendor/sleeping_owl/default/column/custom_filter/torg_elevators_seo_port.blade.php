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
                <option @if(!request('obl_id')) selected="selected" @endif  value="" >Все области</option>
                @foreach($regions as $region)
                    <option value="{{$region->id}}" @if(request('obl_id') == $region->id) selected="selected" @endif >{{$region->name}}</option>
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


