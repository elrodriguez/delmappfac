<div>
    <div id="js-inbox-menu" class="flex-wrap position-relative bg-white slide-on-mobile slide-on-mobile-left">
        <div class="pos-top pos-bottom w-100">
            <div class="d-flex h-100 flex-column">
                <div class="px-3 px-sm-4 px-lg-5 py-4 align-items-center">
                    <div class="btn-group btn-block" role="group" aria-label="Button group with nested dropdown ">
                        <button id="btnNewCompose" type="button" class="btn btn-danger btn-block fs-md" data-action="toggle" data-class="d-flex" data-target="#panel-compose" data-focus="message-to">{{ __('messages.compose') }}</button>
                    </div>
                </div>
                <div class="flex-1 pr-3">
                    <a href="{{ route('onlineshop_attention_customer_messages') }}" class="dropdown-item px-3 px-sm-4 pr-lg-3 pl-lg-5 py-2 fs-md d-flex justify-content-between rounded-pill border-top-left-radius-0 border-bottom-left-radius-0 {{ request()->segment(3) == 'customer_messages' ? 'active font-weight-bold' : '' }}">
                        <div>
                            <i class="fas fa-folder-open width-1"></i>{{ __('messages.received') }}
                        </div>
                        <div class="fw-400 fs-xs js-unread-emails-count"></div>
                    </a>
                    <a href="{{ route('onlineshop_attention_sent_messages') }}" class="dropdown-item px-3 px-sm-4 pr-lg-3 pl-lg-5 py-2 fs-md d-flex justify-content-between rounded-pill border-top-left-radius-0 border-bottom-left-radius-0 {{ request()->segment(3) == 'sent_messages' ? 'active font-weight-bold' : '' }}">
                        <div>
                            <i class="fas fa-paper-plane width-1"></i>{{ __('messages.sho_sent') }}
                        </div>
                    </a>
                    <a href="{{ route('onlineshop_attention_trash_messages') }}" class="dropdown-item px-3 px-sm-4 pr-lg-3 pl-lg-5 py-2 fs-md d-flex justify-content-between rounded-pill border-top-left-radius-0 border-bottom-left-radius-0 {{ request()->segment(3) == 'trash_messages' ? 'active font-weight-bold' : '' }}">
                        <div>
                            <i class="fas fa-trash width-1"></i>{{ __('messages.trash') }}
                        </div>
                    </a>
                </div>
                {{-- <div class="px-5 py-3 fs-nano fw-500">
                    1.5 GB (10%) of 15 GB used
                    <div class="progress mt-1" style="height: 7px;">
                        <div class="progress-bar" role="progressbar" style="width: 11%;" aria-valuenow="11" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="slide-backdrop" data-action="toggle" data-class="slide-on-mobile-left-show" data-target="#js-inbox-menu"></div> <!-- end left slider -->
    <script defer>
        document.getElementById("btnNewCompose").onclick = function() {
            $(".js-summernote").summernote('code', "");
            Livewire.emit('customer-messages-compose-new');
        }
    </script>
</div>
