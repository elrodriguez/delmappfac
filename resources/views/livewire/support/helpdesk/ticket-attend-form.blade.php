<div>
    <div class="card mb-g rounded-top">
        <div class="row no-gutters row-grid">
            <div class="col-12">
                <div class="d-flex flex-column align-items-center justify-content-center p-4">
                    @if($ticket['applicant']['profile_photo_path'])
                        <img src="{{ asset('storage/'.$ticket['applicant']['profile_photo_path']) }}" class="rounded-circle shadow-2 img-thumbnail" alt="">
                    @else
                        <img src="{{ ui_avatars_url($ticket['applicant']['name'],130,'none') }}" style="width:130px;height: 130px;" class="rounded-circle shadow-2 img-thumbnail" alt="">
                    @endif
                    <h5 class="mb-0 fw-700 text-center mt-3">
                        {{ $ticket['applicant']['trade_name'] }}
                        <small class="text-muted mb-0">{{ $ticket['applicant']['email'] }}</small>
                    </h5>
                </div>
            </div>
            <div class="col-12 p-2">
                <dl class="row">
                    <dt class="col-sm-3">{{ __('messages.ticket') }}</dt>
                    <dd class="col-sm-9">{{ $ticket['ticket']['internal_id'] }}</dd>
                    <dt class="col-sm-3">{{ __('messages.category') }}</dt>
                    <dd class="col-sm-9">{{ $ticket['ticket']['category_description'] }}</dd>
                    <dt class="col-sm-3">{{ __('messages.subcategory') }}</dt>
                    <dd class="col-sm-9">
                        {{ $ticket['ticket']['subcategory_description'] }}
                        <p>{{ __('messages.details') }}:
                            <span class="fw-300 font-italic">{{ $ticket['ticket']['subcategory_detailed_description'] }}</span>
                        </p>
                    </dd>
                    <dt class="col-sm-3">{{ __('messages.priority') }}</dt>
                    <dd class="col-sm-9">
                        @if ($ticket['ticket']['sup_panic_level_id'] == 1)
                        <span class="badge badge-warning">{{ $ticket['ticket']['level_description'] }}</span>
                        @else
                        <span class="badge badge-danger">{{ $ticket['ticket']['level_description'] }}</span>
                        @endif
                    </dd>
                    <dt class="col-sm-3">{{ __('messages.state') }}</dt>
                    <dd class="col-sm-9">
                        @if($ticket['ticket']['state'] == 'sent')
                            <span class="badge badge-primary">{{ __('messages.'.$ticket['ticket']['state']) }}</span>
                        @elseif($ticket['ticket']['state'] == 'attended')
                            <span class="badge badge-secondary">{{ __('messages.'.$ticket['ticket']['state']) }}</span>
                        @elseif($ticket['ticket']['state'] == 'derivative')
                            <span class="badge badge-dark">{{ __('messages.'.$ticket['ticket']['state']) }}</span>
                        @elseif($ticket['ticket']['state'] == 'cancel')
                            <span class="badge badge-danger">{{ __('messages.'.$ticket['ticket']['state']) }}</span>
                        @elseif($ticket['ticket']['state'] == 'closed_ok')
                            <span class="badge badge-info">{{ __('messages.'.$ticket['ticket']['state']) }}</span>
                        @elseif($ticket['ticket']['state'] == 'closed_fail')
                            <span class="badge badge-warning">{{ __('messages.'.$ticket['ticket']['state']) }}</span>
                        @endif
                    </dd>
                    <dt class="col-sm-3">{{ __('messages.reception_mode') }}</dt>
                    <dd class="col-sm-9">{{ $ticket['ticket']['reception_description'] }}</dd>
                    <dt class="col-sm-3">{{ __('messages.area') }}</dt>
                    <dd class="col-sm-9">{{ $ticket['ticket']['area_description'] }}</dd>
                    <dt class="col-sm-3">{{ __('messages.files') }}</dt>
                    <dd class="col-sm-9">
                        @foreach ($ticket['files'] as $file)
                        <a href="{{ asset('storage/'.$file['url']) }}" target="_blank" type="button" class="btn btn-default mb-2 btn-xs px-1 py-1 fw-500 waves-effect waves-themed">
                            <span class="d-block text-truncate text-truncate-sm">
                                <i class="fal fa-file-pdf mr-1 color-danger-700"></i> {{ $file['original_name'] }}
                            </span>
                        </a>
                        @endforeach
                        @if(in_array($ticket['ticket']['state'], $states_not))
                            <button class="btn btn-default mb-2 btn-sm btn-icon waves-effect waves-themed" data-toggle="modal" data-target="#exampleModalFileTicket">
                                <i class="fal fa-paperclip"></i>
                            </button>
                        @endif
                    </dd>
                    <dt class="col-sm-3">{{ __('messages.version_sicmact') }}</dt>
                    <dd class="col-sm-9" wire:ignore><a href="#" id="version_sicmact" data-type="text" data-pk="{{ $ticket['ticket']['id'] }}">{{ $ticket['ticket']['version_sicmact'] }}</a></dd>
                </dl>
            </div>
            @if(auth()->user()->id != $ticket['applicant']['id'])
                <div class="col-12 p-2">
                    <div class="d-flex flex-row align-items-center">
                        <div class="icon-stack display-3 flex-shrink-0">
                            <i class="fal fa-circle icon-stack-3x opacity-100 color-primary-400"></i>
                            @if(isDevice($ticket['ticket']['browser']) == 'desktop')
                                <i class="fas fa-desktop-alt icon-stack-1x opacity-100 color-primary-500"></i>
                            @elseif (isDevice($ticket['ticket']['browser']) == 'tablet')
                                <i class="fas fa-tablet icon-stack-1x opacity-100 color-primary-500"></i>
                            @elseif (isDevice($ticket['ticket']['browser']) == 'mobile')
                                <i class="fas fa-tablet-android-alt icon-stack-1x opacity-100 color-primary-500"></i>
                            @endif
                        </div>
                        <div class="ml-3">
                            <strong>IP: {{ $ticket['ticket']['ip_pc'] }}</strong>
                            <br>
                            {{ $ticket['ticket']['browser'] }}
                        </div>
                    </div>
                </div>
            @elseif($ticket['technical'])
                <div class="col-12 p-2">
                    <div class="d-flex flex-row align-items-center">
                        <div class="icon-stack display-3 flex-shrink-0">
                            <i class="fal fa-circle icon-stack-3x opacity-100 color-primary-400"></i>
                            <i class="fas fa-user-alt icon-stack-1x opacity-100 color-primary-500"></i>
                        </div>
                        <div class="ml-3">
                            <strong>{{ __('messages.user_in_charge') }}</strong>
                            <br>
                            {{ $ticket['technical']['name'] }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="exampleModalFileTicket" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.add_file') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label class="form-label">{{ __('messages.file_browser') }}</label>
                        <div class="custom-file" wire:ignore>
                            <input type="file" class="custom-file-input" id="customFile" accept="application/pdf" wire:model.defer="files">
                            <label class="custom-file-label" for="customFile">{{ __('messages.choose_file') }}</label>
                        </div>
                        @error('files') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                    <button wire:click="addFile" type="button" class="btn btn-primary">{{ __('messages.save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('response_success_ticket_store_file', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            $('#exampleModalFileTicket').modal('hide')
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
