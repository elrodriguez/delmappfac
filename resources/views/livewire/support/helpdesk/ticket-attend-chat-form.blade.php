<div>
    <div id="panel-2" class="panel panel-sortable" data-panel-fullscreen="false" role="widget">
        <div class="panel-hdr" role="heading">
            <h2 class="ui-sortable-handle">{{ __('messages.helpdesk_answer') }}</h2>
        </div>
        <div class="panel-container show" role="content"><div class="loader"><i class="fal fa-spinner-third fa-spin-4x fs-xxl"></i></div>
            <div class="panel-content p-0">
                <div class="d-flex flex-column">
                    <div class="bg-subtlelight-fade custom-scroll" style="height: 244px">
                        <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;">
                            <div id="chat-attend-ticket" class="h-100" style="overflow: auto; width: auto; height: 100%;">
                                <div class="px-3 pt-3 pb-2">
                                    @foreach ($chat as $message)
                                        @if($message['user_id'] != auth()->user()->id)
                                            <div class="chat-segment chat-segment-get">
                                                <div class="d-flex flex-row px-3 pt-3 pb-2">
                                                    <span class="status status-danger">
                                                        @if(json_decode($message['user'])->profile_photo_path)
                                                            <span class="profile-image rounded-circle d-inline-block" style="background-image:url('{{ asset('storage/'.json_decode($message['user'])->profile_photo_path) }}')"></span>
                                                        @else
                                                            <span class="profile-image rounded-circle d-inline-block" style="background-image:url('{{ ui_avatars_url(json_decode($message['user'])->name,50,'none') }}')"></span>
                                                        @endif
                                                    </span>
                                                    <div class="ml-3">
                                                        <a href="javascript:void(0);" title="Lisa Hatchensen" class="d-block fw-700 text-dark">{{ json_decode($message['user'])->name }}</a>
                                                        @if($message['html'])
                                                            {!! html_entity_decode( $message['message'], ENT_QUOTES) !!}
                                                        @else
                                                            <div class="chat-message">
                                                                <p>{{ $message['message'] }}</p>
                                                            </div>
                                                        @endif
                                                        <div class="fw-300 text-muted mt-1 fs-xs">
                                                            {{ \Carbon\Carbon::parse($message['created_at'])->diffForHumans() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="chat-segment chat-segment-sent chat-end">
                                            @if($message['html'])
                                                {!! html_entity_decode( $message['message'], ENT_QUOTES) !!}
                                            @else
                                                <div class="chat-message">
                                                    <p>{{ $message['message'] }}</p>
                                                </div>
                                            @endif
                                                <div class="text-right fw-300 text-muted mt-1 fs-xs">
                                                    {{ \Carbon\Carbon::parse($message['created_at'])->diffForHumans() }}
                                                </div>
                                            </div>
                                        @endif

                                    @endforeach
                                </div>
                            </div>
                            <div class="slimScrollBar" style="background: rgba(0, 0, 0, 0.6); width: 4px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 4px; height: 244px;"></div>
                            <div class="slimScrollRail" style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(250, 250, 250); opacity: 0.2; z-index: 90; right: 4px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            @if(in_array($ticket_state, $states_not))
                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 bg-faded">
                    <textarea rows="3" class="form-control rounded-top border-bottom-left-radius-0 border-bottom-right-radius-0 border" wire:model.defer="msg" placeholder="{{ __('messages.write_reply') }}"></textarea>
                    <div class="d-flex align-items-center py-2 px-2 bg-white border border-top-0 rounded-bottom">
                        <div class="btn-group dropup">
                            <button type="button" class="btn btn-icon fs-lg dropdown-toggle no-arrow waves-effect waves-themed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fal fa-smile"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-animated text-center rounded-pill overflow-hidden" style="width: 280px">
                                <div class="px-1 py-0">
                                    <a wire:click="sendEmoji(1)" href="javascript:void(0);" class="emoji emoji--like" data-toggle="tooltip" data-placement="top" title="" data-original-title="Like">
                                        <div class="emoji__hand">
                                            <div class="emoji__thumb"></div>
                                        </div>
                                    </a>
                                    <a wire:click="sendEmoji(2)" href="javascript:void(0);" class="emoji emoji--love" data-toggle="tooltip" data-placement="top" title="" data-original-title="Love">
                                        <div class="emoji__heart"></div>
                                    </a>
                                    <a wire:click="sendEmoji(3)" href="javascript:void(0);" class="emoji emoji--haha" data-toggle="tooltip" data-placement="top" title="" data-original-title="Haha">
                                        <div class="emoji__face">
                                            <div class="emoji__eyes"></div>
                                            <div class="emoji__mouth">
                                                <div class="emoji__tongue"></div>
                                            </div>
                                        </div>
                                    </a>
                                    <a wire:click="sendEmoji(4)" href="javascript:void(0);" class="emoji emoji--yay" data-toggle="tooltip" data-placement="top" title="" data-original-title="Yay">
                                        <div class="emoji__face">
                                            <div class="emoji__eyebrows"></div>
                                            <div class="emoji__mouth"></div>
                                        </div>
                                    </a>
                                    <a wire:click="sendEmoji(5)" href="javascript:void(0);" class="emoji emoji--wow" data-toggle="tooltip" data-placement="top" title="" data-original-title="Wow">
                                        <div class="emoji__face">
                                            <div class="emoji__eyebrows"></div>
                                            <div class="emoji__eyes"></div>
                                            <div class="emoji__mouth"></div>
                                        </div>
                                    </a>
                                    <a wire:click="sendEmoji(6)" href="javascript:void(0);" class="emoji emoji--sad" data-toggle="tooltip" data-placement="top" title="" data-original-title="Sad">
                                        <div class="emoji__face">
                                            <div class="emoji__eyebrows"></div>
                                            <div class="emoji__eyes"></div>
                                            <div class="emoji__mouth"></div>
                                        </div>
                                    </a>
                                    <a wire:click="sendEmoji(7)" href="javascript:void(0);" class="emoji emoji--angry" data-toggle="tooltip" data-placement="top" title="" data-original-title="Angry">
                                        <div class="emoji__face">
                                            <div class="emoji__eyebrows"></div>
                                            <div class="emoji__eyes"></div>
                                            <div class="emoji__mouth"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--button type="button" class="btn btn-icon fs-lg waves-effect waves-themed">
                            <i class="fal fa-paperclip"></i>
                        </button-->
                        <div class="custom-control custom-checkbox custom-control-inline ml-auto hidden-sm-down">

                        </div>
                        <button wire:click="store" wire:loading.attr="disabled" class="btn btn-primary btn-sm ml-auto ml-sm-0 waves-effect waves-themed">
                            {{ __('messages.reply') }}
                        </button>
                    </div>
                </div>
            @else
                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 bg-faded">
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ __('messages.closed') }}</strong> {{ __('messages.you_can_no_longer_send_messages') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script>
        window.addEventListener('response_success_ticket_chat_store', event => {
            scrollAnimate();
        });
        function scrollAnimate(){
            $('#chat-attend-ticket').scrollTop( $('#chat-attend-ticket').prop('scrollHeight') );
        }
    </script>
</div>
