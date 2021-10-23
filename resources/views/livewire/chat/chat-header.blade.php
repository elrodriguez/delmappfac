<div class="card-header py-2 pr-2 d-flex align-items-center flex-wrap">
    @if($avatar_contact)
        @php
            $avatar = asset('storage/'.$avatar_contact);
        @endphp
    @else
        @php
            $avatar = ui_avatars_url($name_contact,50,'none');
        @endphp
    @endif
    <div class="card-title">{{ $name_contact }} <small>{{ $email_contact }}</small></div>
    <button class="btn btn-outline-info btn-icon ml-auto rounded-circle ml-1 waves-effect waves-themed">
        <i class="fal fa-volume-mute fs-md"></i>
    </button>
    <button class="btn btn-outline-info btn-icon rounded-circle ml-1 waves-effect waves-themed">
        <i class="fal fa-phone fs-md"></i>
    </button>
    <button class="btn btn-outline-info btn-icon rounded-circle ml-1 waves-effect waves-themed">
        <i class="fal fa-video fs-md"></i>
    </button>
</div>
