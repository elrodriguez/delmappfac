<div class="d-flex flex-column flex-grow-1 bg-white">
    <!-- inbox header -->
    <div class="flex-grow-0">
        <!-- inbox title -->
        <div class="d-flex align-items-center pl-2 pr-3 py-3 pl-sm-3 pr-sm-4 py-sm-4 px-lg-5 py-lg-4  border-faded border-top-0 border-left-0 border-right-0 flex-shrink-0">
            <!-- button for mobile -->
            <a href="javascript:void(0);" class="pl-3 pr-3 py-2 d-flex d-lg-none align-items-center justify-content-center mr-2 btn" data-action="toggle" data-class="slide-on-mobile-left-show" data-target="#js-inbox-menu">
                <i class="fal fa-ellipsis-v h1 mb-0 "></i>
            </a>
            <!-- end button for mobile -->
            <h1 class="subheader-title ml-1 ml-lg-0">
                <i class="fas fa-folder-open mr-2 hidden-lg-down"></i>
                {{ __('messages.inbox') }}
            </h1>
            <div class="d-flex position-relative ml-auto" style="max-width: 23rem;">
                <i class="fas fa-search position-absolute pos-left fs-lg px-3 py-2 mt-1"></i>
                <input wire:model.defer="search" type="text" class="form-control bg-subtlelight pl-6" placeholder="{{ __('messages.filter_emails') }}" wire:keydown.enter="messagesSearch">
            </div>
        </div>
        <!-- end inbox title -->
        <!-- inbox button shortcut -->
        <div class="d-flex flex-wrap align-items-center pl-3 pr-1 py-2 px-sm-4 px-lg-5 border-faded border-top-0 border-left-0 border-right-0">
            <div class="flex-1 d-flex align-items-center">
                <div class="custom-control custom-checkbox mr-2 mr-lg-2 d-inline-block">
                    <input type="checkbox" class="custom-control-input" id="js-msg-select-all">
                    <label class="custom-control-label bolder" for="js-msg-select-all"></label>
                </div>
                <button wire:click="messagesSearch" class="btn btn-icon rounded-circle mr-1" data-toggle="tooltip" data-placement="right" data-original-title="{{ __('messages.refresh') }}">
                    <i class="fas fa-redo fs-md"></i>
                </button>
                {{-- <a href="javascript:void(0);" class="btn btn-icon rounded-circle mr-1">
                    <i class="fas fa-exclamation-circle fs-md"></i>
                </a> --}}
                <button wire:click="deleteMessage" class="btn btn-icon rounded-circle mr-1" data-toggle="tooltip" data-placement="right" data-original-title="{{ __('messages.delete') }}">
                    <i class="fas fa-trash fs-md"></i>
                </button>
            </div>
            {{ $messages->links() }}
        </div>
        <!-- end inbox button shortcut -->
    </div>
    <!-- end inbox header -->
    <!-- inbox message -->
    <div class="flex-wrap align-items-center flex-grow-1 position-relative bg-gray-50">
        <div class="pos-top pos-bottom">
            <div class="d-flex h-100 flex-column">
                <!-- message list (the part that scrolls) -->
                <ul class="notification notification-layout-2">
                    @foreach($messages as $k => $message)
                    <li class="{{ $message->status == 'rg' ? 'unread' : '' }}">
                        <div class="d-flex align-items-center px-3 px-sm-4 px-lg-5 py-1 py-lg-0 height-4 height-mobile-auto">
                            <div class="custom-control custom-checkbox mr-3 order-1">
                                <input type="checkbox" class="custom-control-input msg-delete" wire:model="items.{{ $k }}" id="msg-{{ $k }}" value="{{ $message->id }}">
                                <label class="custom-control-label" for="msg-{{ $k }}"></label>
                            </div>
                            {{-- <a href="#" title="starred" class="d-flex align-items-center py-1 ml-2 mt-4 mt-lg-0 ml-lg-0 mr-lg-4 fs-lg color-warning-500 order-3 order-lg-2"><i class="fas fa-star"></i></a> --}}
                            <div class="d-flex flex-row flex-wrap flex-1 align-items-stretch align-self-stretch order-2 order-lg-3">
                                <div class="row w-100">
                                    <a href="{{ route('onlineshop_attention_read_message',$message->message_id) }}" class="name d-flex width-sm align-items-center pt-1 pb-0 py-lg-1 col-12 col-lg-auto">{{ $message->name }}</a>
                                    <a href="{{ route('onlineshop_attention_read_message',$message->message_id) }}" class="name d-flex align-items-center pt-0 pb-1 py-lg-1 flex-1 col-12 col-lg-auto">{{ $message->subject }}</a>
                                </div>
                            </div>
                            <div class="fs-sm text-muted ml-auto hide-on-hover-parent order-4 position-on-mobile-absolute pos-top pos-right mt-2 mr-3 mr-sm-4 mt-lg-0 mr-lg-0">{{ \Carbon\Carbon::parse($message->created_at)->format('d/m/Y H:i') }}</div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <!-- end message list -->
            </div>
        </div>
    </div>
    <!-- end inbox message -->
    <script>
        document.getElementById("js-msg-select-all").onchange = function( event ) {
            let cbo = document.getElementsByClassName('msg-delete');
            for(i=0;i<cbo.length;i++){
                cbo[i].checked = event.target.checked;
                if(event.target.checked){
                    @this.set('items.'+i,cbo[i].value)
                }else{
                    @this.set('items.'+i,false)
                }
            }
        }
    </script>
</div>

