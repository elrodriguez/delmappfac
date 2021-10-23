<div>
    <div class="card mb-g">
        <div class="row row-grid no-gutters">
            <div class="col-12">
                <div class="p-3">
                    <h2 class="mb-0 fs-xl">{{ __('messages.participants') }}</h2>
                </div>
            </div>
            @foreach ($participants as $participant)
                <div class="col-4">
                    <div class="text-center p-3 d-flex flex-column hover-highlight">
                        @if($participant->profile_photo_path)
                            <span class="profile-image rounded-circle d-block m-auto" style="background-image:url('{{ asset('storage/'.$participant->profile_photo_path) }}'); background-size: cover;"></span>
                        @else
                            <span class="profile-image rounded-circle d-block m-auto" style="background-image:url('{{ ui_avatars_url($participant->name,32,'none') }}'); background-size: cover;"></span>
                        @endif
                        <span class="d-block text-truncate text-muted fs-xs mt-1">{{ $participant->name }}</span>
                        <span class="d-block text-truncate text-gradient fs-xs mt-1 fw-900">{{ __('messages.'.$participant->type) }}</span>
                        <span class="d-block text-truncate text-muted fs-xs mt-1">{{ $participant->description }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
