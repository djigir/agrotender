<?php
    $packs = \App\Models\Buyer\BuyerTarifPacks::select('title', 'id')->get();
?>

<form method="GET">
    <div class="display-filters-top table table-default display-filters">
        <div data-index="2">
            <a href="{{Request::url().'/create'}}" class="btn btn-primary btn-create"><i class="fas fa-plus"></i> Новая запись</a>
        </div>
        <div data-index="1">
            <select style="width:180px;" data-type="select" name="pack_id" class="form-control input-select column-filter">
                <option @if(!request('pack_id')) selected="selected" @endif  value="" >Типы объявления</option>
                @foreach($packs as $pack)
                    <option value="{{$pack->id}}" @if(request('pack_id') == $pack->id) selected="selected" @endif >{{$pack->title}}</option>
                @endforeach
            </select>
        </div>
        <div data-index="2">
            <div>
                <input type="text" style="width: 80px" data-type="text" placeholder="ID" class="form-control column-filter" name="id" value="{{request('id')}}">
            </div>
        </div>

        <div data-index="3">
            <div>
                <input type="text" style="width: 120px" data-type="text" placeholder="ID объявления" class="form-control column-filter" name="post_id" value="{{request('post_id')}}">
            </div>
        </div>

        <div data-index="4">
            <div>
                <input type="text" style="width: 120px" data-type="text" placeholder="Объявление" class="form-control column-filter" name="title" value="{{request('title')}}">
            </div>
        </div>

        <div data-index="5">
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


