<div class="content-block trader-contact mx-sm-5 py-3 px-4">
    <div class="place d-flex justify-content-between">
        <div class="title">
            <span>{{ $contacts->dep_name }}</span>
        </div>
    </div>
    <div class="contacts mt-4">
        <form class="im-dep" novalidate="novalidate" method="POST" action="{{ route('user.profile.change_contacts', ['type_id' => $type]) }}">
            @csrf
            <div class="form-group row mb-4 pb-1">
                <label class="col-sm-4 col-form-label text-left text-sm-right" style="color: #1EACF8">Ники Telegram:<br><span class="small">формат: <b>@nickname1</b><br><b>@nickname2</b></span></label>
                <div class="col-sm-5">
                    <textarea class="form-control" name="telegram" rows="6">{{ $contacts->telegram }}</textarea>
                </div>
            </div>

            <div class="form-group row mb-4 pb-1">
                <label class="col-sm-4 col-form-label text-left text-sm-right" style="color: #7d50a2">Номера Viber:<br><span class="small">формат: <b>380501112233</b><br><b>380670001122</b></span></label>
                <div class="col-sm-5">
                    <textarea class="form-control" name="viber" rows="6">{{ $contacts->viber }}</textarea>
                </div>
            </div>

    </div>
</div>
<div class="mt-4 text-center">
    <button class="btn btn-primary save-im px-5">Сохранить</button>
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
