<div>
    <div class="card-body">
        <div class="custom-scroll-two pr-2" style="height: 260px" id="chat-container-text">
            @if(is_array($messages))
            @php
                $date_message = '';
            @endphp
            @foreach($messages as $message)
                @if($date_message != \Carbon\Carbon::parse($message['created_at'])->format('d-m-Y'))
                    @if(\Carbon\Carbon::parse($message['created_at'])->format('d-m-Y')==date('d-m-Y'))
                        <div class="chat-segment">
                            <div class="time-stamp text-center mb-2 fw-400">
                                Hoy
                            </div>
                        </div>
                    @else
                        <div class="chat-segment">
                            <div class="time-stamp text-center mb-2 fw-400">
                                {{ \Carbon\Carbon::parse($message['created_at'])->format('d/m/Y') }}
                            </div>
                        </div>
                    @endif
                @endif
                @if($message['from_user_id']== Auth::user()->id)
                    <div class="chat-segment chat-segment-sent">
                        <div class="chat-message">
                            <p>{{ $message['content'] }}</p>
                        </div>
                        <div class="text-right fw-300 text-muted mt-1 fs-xs">
                            {{ \Carbon\Carbon::parse($message['created_at'])->format('H:m A') }}
                        </div>
                    </div>
                @else
                    <div class="chat-segment chat-segment-get">
                        <div class="chat-message">
                            <p>{{ $message['content'] }}</p>
                        </div>
                        <div class="fw-300 text-muted mt-1 fs-xs">
                            {{ \Carbon\Carbon::parse($message['created_at'])->format('H:m A')}}
                        </div>
                    </div>
                @endif
                @php
                    $date_message = \Carbon\Carbon::parse($message['created_at'])->format('d-m-Y');
                @endphp
            @endforeach
            @endif
        </div>
    </div>
    <div class="card-footer">
        <textarea wire:keydown.enter="sendMessage()"  wire:model="content" onkeyup="textareaEnter(event.keyCode, event.which, 'content-text');" data-placeholder="Type your message here..." class="form-control"></textarea>
        <div class="py-2 pr-2 d-flex align-items-center flex-wrap">
            <a href="javascript:void(0);" class="btn btn-icon fs-xl width-1 mr-1" data-toggle="tooltip" data-original-title="More options" data-placement="top">
                <i class="fal fa-ellipsis-v-alt color-fusion-300"></i>
            </a>
            <a href="javascript:void(0);" class="btn btn-icon fs-xl mr-1" data-toggle="tooltip" data-original-title="Attach files" data-placement="top">
                <i class="fal fa-paperclip color-fusion-300"></i>
            </a>
            <a href="javascript:void(0);" class="btn btn-icon fs-xl mr-1" data-toggle="tooltip" data-original-title="Insert photo" data-placement="top">
                <i class="fal fa-camera color-fusion-300"></i>
            </a>
            <div class="ml-auto">
                <a href="javascript:void(0);" wire:click="sendMessage()" class="btn btn-info">Send</a>
            </div>
        </div>
    </div>
    <script defer>
        let element = document.getElementById('chat-container-text');
        element.scrollTop = element.scrollHeight;
    </script>
    <script>
        Pusher.logToConsole = true;
        var pusher = new Pusher('328ae80ed0e357798ddd', {
          cluster: 'us2'
        });
        var channel = pusher.subscribe('chat-side-channel');
        channel.bind('chat-side-event', function(data) {
            let to_user_id = {{ Auth::user()->id }};
            if(data.to_user_id == to_user_id || data.from_user_id == to_user_id){
                let element = document.getElementById('chat-container-text');
                $('#chat-container-text').animate({scrollTop: element.scrollHeight}, '500');
                window.livewire.emit('messages-refresh',data);
            }
            if(data.to_user_id == to_user_id){
                initApp.playSound("{{ url('theme/media/sound') }}", 'bigbox');
                window.livewire.emit('notification-chat-refresh',data);
            }
        });
        function textareaEnter(char, mozChar, id){
            textarea = document.getElementById(id);
            niveles = -1;

            if(mozChar != null) {
                if(mozChar == 13){
                    if(navigator.appName == "Opera") niveles = -2;
                    textarea.value = textarea.value.slice(0, niveles);
                }
            } else if(char == 13) textarea.value = textarea.value.slice(0,-2);
        }
      </script>
</div>
