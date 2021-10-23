<div>
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
                @if($answer['user_id'] == auth()->user()->id || $user_editor->user_id == auth()->user()->id)
                <div class="d-flex align-items-center demo-h-spacing py-3">
                    @if($user_editor->user_id == auth()->user()->id)
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

</div>
