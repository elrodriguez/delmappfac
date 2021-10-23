<div>
    <form wire:submit.prevent="updateProfileInformation">
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>@lang('messages.profile_information')</h2>
        </div>
        <div class="panel-container show">
            <div class="row no-gutters row-grid">
                <div class="col-12">
                    <div class="d-flex flex-column align-items-center justify-content-center p-4">
                        @if ($photo)
                            <img src="{{ $photo->temporaryUrl() }}" alt="{{ $this->user->name }}" style="width:130px;height: 130px;" class="rounded-circle shadow-2 img-thumbnail" alt="">
                        @else
                            <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" style="width:130px;height: 130px;" class="rounded-circle shadow-2 img-thumbnail" alt="">
                        @endif
                       
                        
                        <h5 class="mb-0 fw-700 text-center mt-3">
                            {{ auth()->user()->name }}
                            <small class="text-muted mb-0">{{ auth()->user()->email }}</small>
                        </h5>
                        <input type="file" class="hidden" id="photo" style="display: none" wire:model="photo" />
                    </div>
                    <div class="mt-2" x-show="photoPreview">
                        <span class="block rounded-full w-20 h-20"
                              x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 text-center">
                        <x-jet-secondary-button class="mt-2 mr-2" type="button" onclick="openInputFileAvatar()">
                            {{ __('Select A New Photo') }}
                        </x-jet-secondary-button>
    
                        @if ($this->user->profile_photo_path)
                            <x-jet-secondary-button type="button" class="mt-2" onclick="deleteAvatarUser()">
                                {{ __('Remove Photo') }}
                            </x-jet-secondary-button>
                        @endif
                    </div>
                </div>
            </div>
                <div class="panel-content">
                    <div class="panel-tag">
                        @lang('messages.msg_info_profile')
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="name">@lang('messages.name')</label>
                        <input type="text" class="form-control" id="name" wire:model.defer="state.name">
                        @if($errors->has('name'))
                            <span>{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">@lang('messages.email')</label>
                        <input type="text" class="form-control" id="email" wire:model.defer="state.email">
                        @if($errors->has('email'))
                            <span>{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>
                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                    <button class="btn btn-primary ml-auto waves-effect waves-themed" wire:loading.attr="disabled" wire:target="photo"><i class="fal fa-check mr-1"></i>@lang('messages.save')</button>
                </div>

        </div>
    </div>
    </form>
    <script defer>
        function openInputFileAvatar(){
            $('#photo').trigger('click');
        }
        function confirmchange(){
            Swal.fire({
                title: "¿Estas seguro?",
                text: "Cambiar imagen de avatar",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "No",
                confirmButtonText: "Si"
            }).then(function(result){
                if (result.value){
                    @this.call('updateImagePhoto');
                }
            });
        }
        function deleteAvatarUser(){
            Swal.fire({
                title: "¿Estas seguro?",
                text: "Eliminar imagen de avatar",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "No",
                confirmButtonText: "Si"
            }).then(function(result){
                if (result.value){
                    @this.call('deleteProfilePhoto');
                }
            });
        }

    </script>
</div>
