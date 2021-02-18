<style>
    #section:focus {
        box-shadow: 0 0 0 12px red !important;;

    }

    #section {
        width: 900px;
    }

    .form-control:focus {
        border-color: red;
    }

</style>

<form method="GET">
    <div class="display-filters-top table table-default display-filters">
        <div data-index="0">
            <select data-type="select" name="paginate" class="form-control  column-filter">
                <option @if(request('paginate') == 0) selected="selected" @endif value="0">Показать по</option>
                <option @if(request('paginate') == 25) selected="selected" @endif value="25">25</option>
                <option @if(request('paginate') == 50) selected="selected" @endif value="50">50</option>
                <option @if(request('paginate') == 100) selected="selected" @endif value="100">100</option>
            </select>
        </div>

        <div data-index="1">
            <div>
                <input style="width: 160px" type="text" data-type="text" placeholder="E-mail" class="form-control column-filter" name="email" value="{{request('email')}}">
            </div>
        </div>
        <div data-index="3">
            <div>
                <input type="text" data-type="text" placeholder="Название" class="form-control column-filter" name="title"  value="{{request('title')}}">
            </div>
        </div>
        <div data-index="4">
            <div>
                <input style="width: 80px" type="text" data-type="text" placeholder="ID" class="form-control column-filter" name="id"  value="{{request('id')}}">
            </div>
        </div>
        <div data-index="5">
            <div class="btn-group">
                <button data-type="control" id="bntSub" class="btn btn-sm btn-primary column-filter" onclick="localStorage.clear()">
                    Фильтр
                </button>
                <a href="{{url()->current()}}" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
            </div>
        </div>
    </div>
</form>


