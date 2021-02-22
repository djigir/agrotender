<?php
$regions = App\Models\Regions\Regions::select('name', 'id')->orderBy('id', 'desc')->get();
?>
<div >
<form action="{{ route('admin.download_users') }}" class="export-form" style="margin-right: 15px; margin-bottom: 25px" autocomplete="off">
    <input type="hidden" name="obl_id" class="export-input_obl" value="">
    <input type="hidden" name="section_id" class="export-input_section" value="">
    <input type="hidden" name="email_filter" class="export-input_email_filter" value="">
    <input type="hidden" name="phone_filter" class="export-input_phone_filter" value="">
    <input type="hidden" name="name_filter" class="export-input_name_filter" value="">
    <input type="hidden" name="id_filter" class="export-input_id_filter" value="">
    <input type="hidden" name="ip_filter" class="export-input_ip_filter" value="">
    <input type="submit" value="Выгрузить csv" class="export-btn btn btn-warning btn-create export-btn">
</form>

<form method="GET" style="margin-left: 130px; margin-top: -55px">
    <div class="display-filters-top table table-default display-filters">
        <div data-index="1">
            <select style="width: 160px;" data-type="select" name="obl_id" class="form-control input-select column-filter">
                <option @if(!request('obl_id')) selected="selected" @endif  value="">Все области</option>
                @foreach($regions as $region)
                    <option value="{{$region->id}}"
                            @if(request('obl_id') == $region->id) selected="selected" @endif >{{$region->name}}</option>
                @endforeach
            </select>
        </div>

        <div data-index="3">
            <div>
                <input type="text" style="width: 130px" data-type="text" placeholder="Имя" class="form-control column-filter" name="name" value="{{request('name')}}">
            </div>
        </div>

        <div data-index="4">
            <div>
                <input type="text" style="width: 140px" data-type="text" placeholder="E-mail" class="form-control column-filter" name="email" value="{{request('email')}}">
            </div>
        </div>
        <div data-index="5">
            <div>
                <input type="text" style="width: 140px" data-type="text" placeholder="Тел." class="form-control column-filter" name="phone" value="{{request('phone')}}">
            </div>
        </div>
        <div data-index="5">
            <div>
                <input type="text" style="width: 80px" data-type="text" placeholder="ID" class="form-control column-filter" name="id" value="{{request('id')}}">
            </div>
        </div>

        <div data-index="5">
            <div>
                <input type="text" style="width: 80px" data-type="text" placeholder="IP" class="form-control column-filter" name="ip" value="{{request('ip')}}">
            </div>
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
</div>
