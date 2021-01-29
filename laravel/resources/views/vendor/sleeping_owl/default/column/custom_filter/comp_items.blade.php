<?php
    $regions = App\Models\Regions\Regions::select('name', 'id')->get();
?>

<form method="GET">
    <div class="display-filters-top table table-default display-filters">
        <div data-index="0">
            <select data-type="select" name="paginate" class="form-control input-select column-filter">
                <option @if(request('paginate') == 0) selected="selected" @endif value="0">Показать по</option>
                <option @if(request('paginate') == 25) selected="selected" @endif value="25">25</option>
                <option @if(request('paginate') == 50) selected="selected" @endif value="50">50</option>
                <option @if(request('paginate') == 100) selected="selected" @endif value="100">100</option>
            </select>
        </div>

        <div data-index="1">
           <select data-type="select" name="obl_id" class="form-control input-select column-filter">
               <option @if(!request('obl_id')) selected="selected" @endif  value="" >Все области</option>
                   @foreach($regions as $region)
                   <option value="{{$region->id}}" @if(request('obl_id') == $region->id) selected="selected" @endif >{{$region->name}}</option>
               @endforeach
           </select>
        </div>

        <div data-index="2">
            <select data-type="select" name="avail" class="form-control input-select column-filter">
                <option @if(request('avail') == null) selected="selected" @endif value="">Все компании</option>
                <option value="100" @if(request('avail') == 100) selected="selected" @endif >Трейдер (закуп.)</option>
                <option value="200" @if(request('avail') == 200) selected="selected" @endif >Трейдер (продажи.)</option>
            </select>
        </div>

        <div data-index="3">
            <div>
                <input type="text" style="width: 180px" data-type="text" placeholder="Название компании" class="form-control column-filter" name="comp_name" value="{{request('comp_name')}}">
            </div>
        </div>

        <div data-index="4">
            <div>
                <input type="text" style="width: 150px" data-type="text" placeholder="E-mail" class="form-control column-filter" name="email" value="{{request('email')}}">
            </div>
        </div>

{{--        <div data-index="5">--}}
{{--            <div>--}}
{{--                <input type="text" style="width: 100px" data-type="text" placeholder="Тел." class="form-control column-filter" name="phone" value="{{request('phone')}}">--}}
{{--            </div>--}}
{{--        </div>--}}

        <div data-index="6">
            <div>
                <input type="text" style="width: 150px" data-type="text" placeholder="Автор" class="form-control column-filter" name="author" value="{{request('author')}}">
            </div>
        </div>

        <div data-index="7">
            <div>
                <input type="text" style="width: 150px" data-type="text" placeholder="ID" class="form-control column-filter" name="id" value="{{request('id')}}">
            </div>
        </div>

        <div data-index="8">
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


