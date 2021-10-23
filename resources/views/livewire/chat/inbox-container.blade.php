<div class="row">
    <div class="col-xs-6 col-md-4">
        @livewire('chat.contact-list')
    </div>
    <div class="col-xs-12 col-sm-12 col-md-8">
        <div class="card border">
            @livewire('chat.chat-header',['data_inbox'=>$data_inbox])
            @livewire('chat.chat-messages',['data_inbox'=>$data_inbox])
        </div>
    </div>
</div>
