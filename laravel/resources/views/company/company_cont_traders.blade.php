<div class="container mb-5">
    <h2 class="mt-4">Контакты трейдера</h2>
    @foreach($traders_contacts as $trader_contact)
        @if($trader_contact['traders_contacts']->count() != 0)
            <div class="content-block trader-contact py-3 px-4">
                <div class="place d-flex justify-content-between">
                    <div class="title">
                        <span>{{ $trader_contact['name'] }}</span>
                    </div>
                </div>
                <div class="contacts mt-4">
                    @foreach($trader_contact['traders_contacts'] as $contact_trader)
                        <div class="contact my-3 text-center mx-sm-5 px-sm-4 position-relative">
                            @if(!is_null($contact_trader['dolg']) || !is_null($contact_trader['fio']))
                                <div class="row m-0 px-3 px-sm-0">
                                    <div class="col p-0">
                                        @if(!is_null($contact_trader['dolg']))
                                            <b>{{ $contact_trader['dolg'] }}</b>
                                        @endif
                                        <span class="name" {{--style="white-space: pre-line"--}}>
                                @if(!is_null($contact_trader['fio']))
                                                {{strip_tags($contact_trader['fio']) }}
                                            @endif
                                </span>
                                    </div>
                                </div>
                            @endif
                            <div class="row m-0 justify-content-center">
                                <div class="col-auto pr-2 text-center">
                                    <b>Телефон:</b>
                                    <span class="phone"{{-- style="white-space: pre-line"--}}>
                                    @if(!is_null($contact_trader['phone']))
                                            {{ strip_tags($contact_trader['phone']) }}
                                        @endif
                                </span>
                                </div>
                                @if( !empty($contact_trader['email'] && !is_null($contact_trader['email'])))
                                    <div class="col-auto pl-2 text-center">
                                        <b>Email:</b> &nbsp;<span class="email">@if(!is_null($contact_trader['email'])) {{ $contact_trader['email'] }} @endif</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
</div>
