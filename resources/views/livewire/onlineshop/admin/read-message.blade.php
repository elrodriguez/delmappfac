<div class="flex-wrap align-items-center flex-grow-1 bg-white">
    <div class="pos-top pos-bottom">
        <div class="d-flex flex-column">
            <!-- inbox title -->
            <div class="d-flex align-items-center pl-2 pr-3 py-3 pl-sm-3 pr-sm-4 py-sm-4 px-lg-5 py-lg-3 flex-shrink-0">
                <!-- button for mobile -->
                <a href="javascript:void(0);" class="pl-3 pr-3 py-2 d-flex d-lg-none align-items-center justify-content-center mr-2 btn" data-action="toggle" data-class="slide-on-mobile-left-show" data-target="#js-inbox-menu">
                    <i class="fal fa-ellipsis-v h1 mb-0 "></i>
                </a>
                <!-- end button for mobile -->
                <h1 class="subheader-title mb-0 ml-2 ml-lg-5">
                    {{ $message->subject }}
                </h1>
            </div>
            <!-- end inbox title -->
            <!-- message -->
            <div id="msg-01" class="d-flex flex-column border-faded border-top-0 border-left-0 border-right-0 py-3 px-3 px-sm-4 px-lg-0 mr-0 mr-lg-5 flex-shrink-0">
                <div class="d-flex align-items-center flex-row">
                    <div class="ml-0 mr-3 mx-lg-3 width-2">
                        @if($message->profile_photo_path)
                        <img src="{{ asset('storage/'.$message->profile_photo_path) }}" style="width:32px;height: 32px;" class="profile-image profile-image-md rounded-circle" alt="{{ $message->name }}">
                        @else
                        <img src="{{ ui_avatars_url($message->name,32,'none') }}" class="profile-image profile-image-md rounded-circle" alt="{{ $message->name }}">
                        @endif
                    </div>
                    <div class="fw-500 flex-1 d-flex flex-column cursor-pointer" data-toggle="collapse" data-target="#msg-01 > .js-collapse">
                        <div class="fs-lg">
                            {{ $message->name }}
                            <span class="fs-nano fw-400 ml-2">{{ $message->email }}</span>
                        </div>
                        <div class="fs-nano">
                            Tel. {{ $message->phone }}
                        </div>
                    </div>
                    <div class="color-fusion-200 fs-sm">
                        {{ \Carbon\Carbon::parse($message->created_at)->format('d/m/Y H:i') }} <span class="hidden-sm-down">({{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }})</span>
                    </div>
                    <div class="collapsed-reveal">
                        <button wire:click="$emit('customer-messages-compose-for','{{ $message->message_id }}')" type="button" data-action="toggle" data-class="d-flex" data-target="#panel-compose" data-focus="message-to" class="btn btn-icon ml-1 fs-lg rounded-circle">
                            <i class="fal fa-reply"></i>
                        </button>
                    </div>
                </div>
                <div class="js-collapse">
                    <div class="pl-lg-5 ml-lg-5 pt-3 pb-4 ">
                        {!! $message->message !!}
                    </div>
                </div>
            </div>
            <!-- end message -->
            @if($answers)
                @php
                    $k = 2;
                @endphp
                @foreach($answers as $answer)
                <!-- message me-->
                <div id="msg-0{{ $k }}" class="d-flex flex-column border-faded border-top-0 border-left-0 border-right-0 py-3 px-3 px-sm-4 px-lg-0 mr-0 mr-lg-5 flex-shrink-0">
                    <div class="d-flex align-items-center flex-row">
                        <div class="ml-0 mr-3 mx-lg-3">
                            @if($answer->profile_photo_path)
                            <img src="{{ asset('storage/'.$answer->profile_photo_path) }}" style="width:32px;height: 32px;" class="profile-image profile-image-md rounded-circle" alt="{{ $answer->name }}">
                            @else
                            <img src="{{ ui_avatars_url($answer->name,32,'none') }}" class="profile-image profile-image-md rounded-circle" alt="{{ $answer->name }}">
                            @endif
                        </div>
                        <div class="fw-500 flex-1 d-flex flex-column cursor-pointer" data-toggle="collapse" data-target="#msg-0{{ $k }} > .js-collapse">
                            <div class="fs-lg">
                                {{ $answer->name }}
                                <span class="fs-nano fw-400 ml-2">{{ $answer->email }}</span>
                            </div>
                            <div class="fs-nano">
                                {{ $answer->phone }}
                            </div>
                        </div>
                        <div class="color-fusion-200 fs-sm">
                            {{ \Carbon\Carbon::parse($answer->created_at)->format('d/m/Y H:i') }} <span class="hidden-sm-down">({{ \Carbon\Carbon::parse($answer->created_at)->diffForHumans() }})</span>
                        </div>
                        {{-- <div class="collapsed-reveal">
                            <a href="javascript:void(0);" class="btn btn-icon ml-1 fs-lg rounded-circle">
                                <i class="fal fa-reply"></i>
                            </a>
                        </div> --}}
                    </div>
                    <div class="collapse js-collapse show">
                        <div class="pl-lg-5 ml-lg-5 pt-3 pb-4 ">
                            {!! $answer->message !!}
                        </div>
                    </div>
                </div>
                <!-- end message me-->
                @php
                    $k++;
                @endphp
                @endforeach
            @endif
        </div>
    </div>
</div>