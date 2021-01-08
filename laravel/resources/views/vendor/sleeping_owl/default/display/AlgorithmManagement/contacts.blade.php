<?php
    $contacts = \App\Models\Contact\ContactOptions::select('value', 'id')->get();
    $LABELS = [
        1 => 'Контактный E-Mail',
        2 => 'E-Mail Службы Поддержки',
        3 => 'Телефон 1',
        4 => 'Телефон 2',
        5 => 'Телефон 3',
        6 => 'Адрес',
        7 => 'Skype',
        8 => 'ICQ',
    ];
?>
<div class="content body">
    <div class="card form-elements w-100">
        <div class="card-body">
            <div class="form-elements w-100"><div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3"></div>
                    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-6">
                        <div class="form-elements">
                            @foreach($contacts as $contact)
                                <?php
                                    $url = Request::url() . '/' . $contact->id . '/edit';
                                ?>
                                <div class="form-group form-element-text ">
                                    <label for="cost" class="control-label required">
                                        {{$LABELS[$contact->id]}}
                                    </label>
                                    <div style="display: flex">
                                        <input style="margin-right: 25px;" class="form-control" type="text"  value="{{$contact->value}}">
                                        <div class="table-control-btn" style="margin-top: 4px">
                                            <a href="{{$url}}" class="btn-primary btn btn-xs" title="" data-toggle="tooltip"
                                               data-original-title="Редактировать">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
