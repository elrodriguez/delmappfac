<div>
    <div class="card mb-g rounded-top">
        <div class="row no-gutters row-grid">
            <div class="col-12">
                <div class="d-flex flex-column align-items-center justify-content-center p-4">
                    @if(auth()->user()->profile_photo_path)
                    <img src="{{ asset('storage/'.auth()->user()->profile_photo_path) }}" style="width:130px;height: 130px;" class="rounded-circle shadow-2 img-thumbnail" alt="">
                    @else
                    <img src="{{ ui_avatars_url(auth()->user()->name,130) }}" style="width:130px;height: 130px;" class="rounded-circle shadow-2 img-thumbnail" alt="">
                    @endif
                    <h5 class="mb-0 fw-700 text-center mt-3">
                        {{ auth()->user()->name }}
                        <small class="text-muted mb-0">{{ auth()->user()->email }}</small>
                    </h5>
                    <input id="photo" type="file" style="display:none;" wire:model="photo" onchange="confirmchange()" />
                </div>
            </div>
            <div class="col-12">
                <div class="p-3 text-center">
                    <a href="javascript:void(0);" onclick="openInputFileAvatar()" id="button-input-file" class="btn-link font-weight-bold">Nueva foto</a> <span class="text-primary d-inline-block mx-3">&#9679;</span>
                    <a href="javascript:void(0);" onclick="deleteAvatarUser()" class="btn-link font-weight-bold">Quitar foto</a>
                </div>
            </div>
        </div>
    </div>
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
                    @this.call('deleteProfileAvatar');
                }
            });
        }
    </script>
</div>
