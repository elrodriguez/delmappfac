<div>
    <div class="card mb-g">
        <div class="card-body pb-0 px-4" wire:ignore>
            <div class="d-flex flex-row pb-3 pt-2  border-top-0 border-left-0 border-right-0">
                <div class="d-inline-block align-middle status status-success mr-3">
                    @if($activity->profile_photo_path)
                    <span class="profile-image rounded-circle d-block" style="background-image:url('{{ asset('storage/'.$activity->profile_photo_path) }}'); background-size: cover;"></span>
                    @else
                    <span class="profile-image rounded-circle d-block" style="background-image:url('{{ ui_avatars_url($activity->name,60,'none',false) }}'); background-size: cover;"></span>
                    @endif
                </div>
                <h5 class="mb-0 flex-1 text-dark fw-500">
                    {{ $activity->name }}
                    <small class="m-0 l-h-n">
                        {{ $activity->email }}
                    </small>
                </h5>
                <span class="text-muted fs-xs opacity-70">
                    {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                </span>
            </div>
            <div class="pb-3 pt-2 border-top-0 border-left-0 border-right-0 text-muted">
                {!! htmlspecialchars_decode($activity->body, ENT_QUOTES) !!}
            </div>
        </div>
    </div>
    @if(count($answers)>0)
        @foreach ($answers as $c => $answer)
        <div class="card mb-g">
            <div class="card-body pb-0 px-4">
                <div class="d-flex flex-row pb-3 pt-2  border-top-0 border-left-0 border-right-0">
                    <div class="d-inline-block align-middle status status-success mr-3">
                        @if($answer['profile_photo_path'])
                        <span class="profile-image rounded-circle d-block" style="background-image:url('{{ asset('storage/'.$answer['profile_photo_path']) }}'); background-size: cover;"></span>
                        @else
                        <span class="profile-image rounded-circle d-block" style="background-image:url('{{ ui_avatars_url($answer['name'],60,'none',false) }}'); background-size: cover;"></span>
                        @endif
                    </div>
                    <h5 class="mb-0 flex-1 text-dark fw-500">
                        {{ $answer['trade_name'] }}
                        <small class="m-0 l-h-n">
                        {{ $answer['email'] }}
                        </small>
                    </h5>
                    <span class="text-muted fs-xs opacity-70">
                        {{ \Carbon\Carbon::parse($answer['created_at'])->diffForHumans() }}
                    </span>
                </div>
                <div class="pb-3 pt-2 border-top-0 border-left-0 border-right-0 text-muted">
                    <p>{!! htmlspecialchars_decode($answer['answer_text'], ENT_QUOTES) !!}</p>
                </div>
                @if($answer['user_id'] == auth()->user()->id || $activity->user_id == auth()->user()->id)
                <div class="d-flex align-items-center demo-h-spacing py-3">
                    @if($activity->user_id == auth()->user()->id)
                    <label for="example-input-small" class="form-label">{{ __('messages.points') }}</label>
                    <input type="text" class="form-control text-center form-control-sm rounded-0 border-top-0 border-left-0 border-right-0 px-0 bg-transparent" wire:model.defer="answers.{{ $c }}.points" name="answers[{{ $c }}].points" style="width: 25px">
                    @else
                    <span class="d-inline-flex align-items-center text-dark">
                        <span>{{ $answer['points'] }} puntos</span>
                    </span>
                    @endif
                </div>
                @endif
            </div>
            <div class="card-body py-0 px-4 border-faded border-right-0 border-bottom-0 border-left-0">
                @foreach ($answer['answers'] as $i => $item)
                    @if($item['answers_new'] == false)
                    <div class="d-flex flex-column align-items-center">
                        <div class="d-flex flex-row w-100 py-4">
                            <div class="d-inline-block align-middle status status-sm status-success mr-3">
                                @if($item['avatar'])
                                <span class="profile-image profile-image-md rounded-circle d-block mt-1" style="background-image:url('{{ asset('storage/'.$item['avatar']) }}'); background-size: cover;width:32px"></span>
                                @else
                                <span class="profile-image profile-image-md rounded-circle d-block mt-1" style="background-image:url('{{ ui_avatars_url($item['name'],32,'none',false) }}'); background-size: cover;width:32px"></span>
                                @endif
                            </div>
                            <div class="mb-0 flex-1 text-dark">
                                <div class="d-flex">
                                    <a href="javascript:void(0);" class="text-dark fw-500">
                                    {{ $item['name'] }}
                                    </a><span class="text-muted fs-xs opacity-70 ml-auto">
                                    {{ \Carbon\Carbon::parse($item['created_at'])->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="mb-0">
                                    {{ $item['answer_text'] }}
                                </p>
                            </div>
                        </div>
                        <hr class="m-0 w-100">
                    </div>
                    @else
                    <div class="d-flex flex-column align-items-center">
                        <div class="py-3 w-100">
                            <textarea wire:keydown.enter="answerStore('{{ $c }}','{{ $i }}')" wire:model.defer="answers.{{ $c }}.answers.{{ $i }}.answer_text" name="answers[{{ $c }}].answers.[{{ $i }}].answer_text" class="form-control border-0 p-0 bg-transparent" rows="2" placeholder="Agregar una respuesta"></textarea>
                        </div>
                    </div>
                     @endif
                @endforeach
            </div>
        </div>
        @endforeach
    @endif
    <div class="card border mb-g">
        <div class="card-body pl-4 pt-4 pr-4 pb-0">
            <div class="d-flex flex-column">
                <div class="border-0 flex-1 position-relative shadow-top">
                    <div class="pt-2 pb-1 pr-0 pl-0 rounded-0 position-relative" tabindex="-1">
                        @if(auth()->user()->profile_photo_path)
                        <span class="profile-image rounded-circle d-block position-absolute" style="background-image:url('{{ asset('storage/'.auth()->user()->profile_photo_path) }}'); background-size: cover;"></span>
                        @else
                        <span class="profile-image rounded-circle d-block position-absolute" style="background-image:url('{{ ui_avatars_url(auth()->user()->name,60,'none',false) }}'); background-size: cover;"></span>
                        @endif
                        <div class="pl-5 ml-5">
                            <textarea class="form-control border-0 p-0 fs-xl bg-transparent" rows="4" placeholder="Escribe tu respuesta" wire:model.defer="answer_text" name="answer_text"></textarea>
                        </div>

                    </div>
                </div>
                <div class="height-8 d-flex flex-row align-items-center flex-wrap flex-shrink-0">
                    @error('answer_text') <span class="error">{{ $message }}</span> @enderror
                    <button wire:click="storeQuestion" wire:loading.attr="disabled" class="btn btn-primary ml-auto">
                        <span wire:loading wire:target="store" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-share" wire:loading.attr="disabled" class="fal fa-share mr-2" role="status" aria-hidden="true"></span>
                        <span>@lang('messages.to_post')</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
