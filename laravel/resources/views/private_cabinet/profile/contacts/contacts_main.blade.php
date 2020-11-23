<div class="content-block trader-contact mx-sm-5 py-3 px-4">
    <div class="place d-flex justify-content-between">
        <div class="title">
            <span>{{ $contacts->dep_name }}</span>
        </div>
    </div>
    <div class="contacts mt-4">
        <form class="main-dep" novalidate="novalidate" method="POST" action="{{ route('user.profile.change_contacts') }}">
            @csrf
            <div class="form-group row mb-4 pb-1">
                <label class="col-sm-4 col-form-label text-left text-sm-right">Контактное лицо:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" placeholder="Контактное лицо" name="name" value="{{ $contacts->name }}">
                </div>
            </div>
            <div class="form-group row mb-4 pb-1">
                <label class="col-sm-4 col-form-label text-left text-sm-right">Телефон:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" placeholder="+38 000 000 00 00" name="phone" value="{{ $contacts->phone }}" disabled="" maxlength="18"> <a href="#" class="changePhone" data-toggle="modal" data-target="#changePhone"><i class="fas fa-pencil"></i></a>
                </div>
            </div>
            <hr>
            <div class="form-group row mb-4 pb-1">
                <label class="col-sm-4 col-form-label text-left text-sm-right">Контактное лицо:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" placeholder="Контактное лицо" name="name2" value="{{ $contacts->name2 }}">
                </div>
            </div>
            <div class="form-group row mb-4 pb-1">
                <label class="col-sm-4 col-form-label text-left text-sm-right">Телефон:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" placeholder="+38 000 000 00 00" name="phone2" value="{{ $contacts->phone2 }}" maxlength="18">
                </div>
            </div>
            <hr>
            <div class="form-group row mb-4 pb-1">
                <label class="col-sm-4 col-form-label text-left text-sm-right">Контактное лицо:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" placeholder="Контактное лицо" name="name3" value="{{ $contacts->name3 }}">
                </div>
            </div>
            <div class="form-group row mb-4 pb-1">
                <label class="col-sm-4 col-form-label text-left text-sm-right">Телефон:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" placeholder="+38 000 000 00 00" name="phone3" value="{{ $contacts->phone3 }}" maxlength="18">
                </div>
            </div>
            <hr>
            <div class="form-group row mb-4 pb-1">
                <label class="col-sm-4 col-form-label text-left text-sm-right">Email для публикаций:</label>
                <div class="col-sm-5">
                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $contacts->email }}">
                </div>
            </div>
            <div class="form-group row mb-4 pb-1">
                <label class="col-sm-4 col-form-label text-left text-sm-right">Область:</label>
                <div class="col-sm-5">
                    <select class="form-control" name="obl_id">
                        @foreach($regions as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row mb-4 pb-1">
                <label class="col-sm-4 col-form-label text-left text-sm-right">Населённый пункт:</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" placeholder="Населённый пункт" name="city" value="{{ $contacts->city }}">
                </div>
            </div>
    </div>
</div>
<div class="mt-4 text-center">
    <button class="btn btn-primary save px-5">Сохранить</button>
</div>
</form>

@if($errors->any() || session('success'))
    <div id="noty_layout__bottomLeft" role="alert" aria-live="polite"
         class="noty_bar noty_type__info noty_theme__nest noty_close_with_click noty_has_timeout noty_has_progressbar noty_effects_close animate__animated animate__fadeInRightBig animate__faster"
         style="display: block">
        <div class="noty_body">{{ $errors->first() ? $errors->first() :  session('success') }}</div>
        <div class="noty_progressbar" style="transition: width 4000ms linear 0s; width: 0%;"></div>
    </div>
@endif
