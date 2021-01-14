<div class="new_container mb-5">
    <div class="company">
        <h2 class="mt-4 d-none d-md-block">Контакты</h2>
    </div>
    <div class="content-block trader-contact py-3 px-4">
        <div class="place d-flex justify-content-between">
            <div class="title">
                <span>Главный офис</span>
            </div>
        </div>
        <div class="contacts mt-4">
            @if($company->city !== null)
                <div class="contact my-3 mx-sm-5 px-sm-4 px-2 position-relative">
                    <div class="row">
                        <div class="col-12 col-sm text-left">
                            <span class="name">{{ $company->city }}</span>
                        </div>
                    </div>
                </div>
            @endif
            <div class="contact my-3 mx-sm-5 px-sm-4 px-2 position-relative">
                @if(!is_null($creator['name']) && $creator['name'] !== '' && !is_null($creator['phone']) && $creator['phone'] !== '')
                    <div class="row">
                        <div class="col-12 col-sm text-left">
                            <b class="name"> {{ $creator['name'] }} :</b><span class="phone"> {{ $creator['phone'] }}</span>
                        </div>
                    </div>
                @endif
                @if(!is_null($creator['name2']) && $creator['name2'] !== '' && !is_null($creator['phone2']) && $creator['phone2'] !== '')
                    <div class="row">
                        <div class="col-12 col-sm text-left">
                            <b class="name">{{ $creator['name2'] }} :</b><span class="phone"> {{ $creator['phone2'] }}</span>
                        </div>
                    </div>
                @endif
                @if(!is_null($creator['name3']) && $creator['name3'] !== '' && !is_null($creator['phone3']) && $creator['phone3']  !== '')
                    <div class="row">
                        <div class="col-12 col-sm text-left">
                            <b class="name">{{ $creator['name3'] }} :</b><span class="phone"> {{ $creator['phone3'] }}</span>
                        </div>
                    </div>
                @endif
            </div>
            <div class="contact my-3 mx-sm-5 px-sm-4 px-2 position-relative">
                <div class="row">
                    <div class="col-12 col-sm text-left">
                        <b>Email :</b><span class="email"> {{ $creator['email'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($departament_name as  $dep_name)
        <div class="content-block trader-contact py-3 px-4">
            <div class="place d-flex justify-content-between">
                <div class="title">
                    <span>{{ $dep_name }}</span>
                </div>
            </div>
            <div class="contacts mt-4">
                @foreach($company_contacts as $contact)
                    <div class="contact my-3 mx-sm-5 px-sm-4 px-2 position-relative">
                        <div class="row px-3">
                            <div class="col p-0">
                                @if($contact['dolg'] !== null)<b>{{ $contact['dolg'] }} </b>@endif<span class="name">@if($contact['fio'] !== null ) {!! $contact['fio'] !!} @else - @endif</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-auto">
                                <b>Телефон:</b> <span class="phone">@if($contact['phone'] !== null) {!! $contact['phone'] !!} @else - @endif</span>
                            </div>
                            @if($contact['email'] !== null)
                                <div class="col-auto">
                                    <b>Email:</b> <span class="email">@if($contact['email'] !== null) {!! $contact['email'] !!} @else - @endif</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
