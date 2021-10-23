<div>
    <div class="">
    @foreach($contacts as $contact)
        @if($contact->profile_photo_path)
            @php
                $avatar = asset('storage/'.$contact->profile_photo_path);
            @endphp
        @else
            @php
                $avatar = ui_avatars_url($contact->name,64,'none',false);
            @endphp
        @endif
        <div class="rounded mb-g border border-faded bg-success-500 color-fusion-300">
            <div class="hover-bg p-2">
                <div class="media" style="cursor: pointer;" wire:click="selectContact('{{ $contact->name }}','{{ $contact->profile_photo_path }}','{{ $contact->id }}','{{ $contact->email }}')">
                    <img src="{{ $avatar }}" style="width: 64px" class="align-self-center mr-3" alt="{{ $contact->name }}">
                    <div class="media-body">
                        <h5 class="mt-0">{{ $contact->name }}</h5>
                        <code>{{ $contact->email }}</code>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </div>
</div>
