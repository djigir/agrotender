<div class="content-block trader-contact mx-sm-5 py-3 px-4">
    <div class="place d-flex justify-content-between">
        <div class="title">
            <span>{{ $contacts->dep_name }}</span>
        </div>
    </div>
    @foreach($contacts as $contact)
    <div class="contact my-3 text-center mx-5 px-4 position-relative">
        <div class="row m-0">
            <div class="col p-0">
                <b>Контакное лицо:</b> &nbsp;<span class="name">{{ $contact->fio }}</span>
            </div>
        </div>
        <div class="row m-0">
            <div class="col pr-2 text-right">
                <b>Телефон:</b> &nbsp;<span class="phone">{{ $contact->phone  }}</span>
            </div>
            <div class="col pl-2 text-left">
                <b>Email:</b> &nbsp;<span class="email">{{ $contact->email }}</span>
            </div>
        </div>
        <div class="row m-0">
            <div class="col p-0">
                <b>Должность:</b> &nbsp;<span class="post">{{ $contact->dolg }}</span>
            </div>
        </div>
        <div class="contact-manage d-flex flex-column">
            <i class="fas fa-pencil-alt edit-contact" contact="2253"></i>
            <i class="fas fa-times remove-contact mt-2" contact="2253"></i>
        </div>
    </div>
    @endforeach
    <div class="text-center mt-4">
        <button class="btn add-contact px-5" data-toggle="modal" data-target="#contact">Добавить контакт</button>
    </div>
</div>
