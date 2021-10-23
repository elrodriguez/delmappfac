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
    <div class="card mb-g border shadow-0">
        <div class="card-header p-0">
            <div class="p-3 d-flex flex-row">
                <div class="d-block flex-shrink-0">
                    @if(auth()->user()->profile_photo_path)
                    <img src="{{ asset('storage/'.auth()->user()->profile_photo_path) }}" class="img-fluid img-thumbnail" alt="{{ auth()->user()->name }}">
                    @else
                    <img src="{{ ui_avatars_url(auth()->user()->name,60,'none',false) }}" class="img-fluid img-thumbnail" alt="{{ auth()->user()->name }}">
                    @endif
                </div>
                <div class="d-block ml-2">
                    <span class="h6 font-weight-bold text-uppercase d-block m-0">{{ auth()->user()->name }}</span>
                    <a href="javascript:void(0);" class="fs-sm text-info h6 fw-500 mb-0 d-block">{{ auth()->user()->email }}</a>
                    <div class="d-flex mt-1 text-warning align-items-center">
                        <i class="fal fa-thumbs-up mr-1"></i>
                        <span class="text-muted fs-xs font-italic">
                            (0 votes)
                        </span>
                    </div>
                </div>
                <a href="javascript:void(0);" wire:click="heartChecked()" class="width-3 height-2 d-inline-flex align-items-center justify-content-center position-relative h3 text-primary ml-auto">
                    @if($heart == 1)
                        @if(auth()->user()->profile_photo_path)
                        <img src="{{ asset('storage/'.auth()->user()->profile_photo_path) }}" class="profile-image profile-image-md rounded-circle" alt="{{ auth()->user()->name }}">
                        @else
                        <img src="{{ ui_avatars_url(auth()->user()->name,32,'none',false) }}" class="profile-image profile-image-md rounded-circle" alt="{{ auth()->user()->name }}">
                        @endif
                        <span class="badge badge-icon pos-top pos-right"><i class="fal fa-heart"></i></span>
                    @else
                        <i class="fal fa-heart ml-1 text-muted"></i>
                    @endif
                </a>
            </div>
        </div>
        <div class="card-body" wire:ignore>
            <textarea id="ckeditorcomment">
            </textarea>
        </div>
        <div class="card-footer d-flex flex-row align-items-center">
            <button onclick="storeComment()" wire:loading.attr="disabled" class="btn btn-primary ml-auto">
                <span wire:loading wire:target="store" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-share" wire:loading.attr="disabled" class="fal fa-share mr-2" role="status" aria-hidden="true"></span>
                <span>@lang('messages.to_post')</span>
            </button>
        </div>
    </div>
    @if (count($comments)>0)
        @foreach ($comments as $comment)
        <div class="card mb-g">
			<div class="card-body pb-0 px-4">
				<div class="d-flex flex-row pb-3 pt-2  border-top-0 border-left-0 border-right-0">
					<div class="d-inline-block align-middle status status-success mr-3">
                        @if($comment->profile_photo_path)
                        <span class="profile-image rounded-circle d-block" style="background-image:url('{{ asset('storage/'.$comment->profile_photo_path) }}'); background-size: cover;width: 60px"></span>
                        @else
                        <span class="profile-image rounded-circle d-block" style="background-image:url('{{ ui_avatars_url($comment->name,60,'none',false) }}'); background-size: cover;"></span>
                        @endif
					</div>
					<h5 class="mb-0 flex-1 text-dark fw-500">
						{{ $comment->trade_name }}
						<small class="m-0 l-h-n">
                            {{ $comment->email }}
						</small>
					</h5>
					<span class="text-muted fs-xs opacity-70">
                        {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
					</span>
				</div>
				<div class="pb-3 pt-2 border-top-0 border-left-0 border-right-0 text-muted">
					{!! htmlspecialchars_decode($comment->comment, ENT_QUOTES) !!}
				</div>
				<div class="d-flex align-items-center demo-h-spacing py-3">
					<a href="javascript:void(0);" wire:click="toLike('{{ $comment->id }}')" class="d-inline-flex align-items-center text-dark">
					    <i class="fal fa-thumbs-up fs-xs mr-1 text-danger"></i> <span>{{ $comment->likes }} {{ __('messages.likes') }}</span>
                    </a>
                    @if($activity->user_id == auth()->user()->id && $comment->heart == false)
					<a href="javascript:void(0);" wire:click="ilove('{{ $comment->id }}')" class="d-inline-flex align-items-center text-dark">
					    <i class="fal fa-heart fs-xs mr-1"></i> <span>{{ __('messages.ilove') }}</span>
                    </a>
                    @elseif($comment->heart)
                    <a href="javascript:void(0);" class="d-inline-flex align-items-center text-dark">
					    <i class="fal fa-heart fs-xs mr-1" style='color:orange;'></i> <span>
                            @if($activity->user_id == auth()->user()->id)
                            {{ __('messages.ilove') }}
                            @else
                            {{ $activity->name }}
                            @endif
                        </span>
                    </a>
                    @endif
                    @if($comment->user_id == auth()->user()->id)
					<a href="{{ route('subjects_student_mycourse_themes_forum_comment_edit',[$cu,$mt,$code,$comment->id]) }}" class="d-inline-flex align-items-center text-dark">
                        <i class="fal fa-pencil-alt fs-xs mr-1"></i> <span>{{ __('messages.edit') }}</span>
                    </a>
                    @endif
                    @if($activity->user_id == auth()->user()->id)
					<a href="javascript:void(0);" wire:click="delete('{{ $comment->id }}')" class="d-inline-flex align-items-center text-dark">
                        <i class="fal fa-trash-alt fs-xs mr-1"></i> <span>{{ __('messages.delete') }}</span>
                    </a>
                    @endif
				</div>
			</div>
		</div>
        @endforeach
    @endif
    <script>

        function storeComment(){
            let data = CKEDITOR.instances.ckeditorcomment.getData();
            @this.set('comment', data);
            @this.store()
        }
        window.addEventListener('response_success_activity_comment', event => {
           swalAlert(event.detail.message);
           CKEDITOR.instances.ckeditorcomment.setData('');
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
