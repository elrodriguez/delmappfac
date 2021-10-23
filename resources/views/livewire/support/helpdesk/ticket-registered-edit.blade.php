<div>
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>@lang('messages.edit')</h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">

                <div class="panel-content">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-row">
								<div class="col-md-4 mb-3">
									<label class="form-label">{{ __('messages.user_registration') }}</label>
									<input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
								</div>
                                <div class="col-md-8 mb-3">
									<label class="form-label">{{ __('messages.user_name') }}</label>
									<input type="text" class="form-control" value="{{ $person->trade_name }}" disabled>
								</div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3" wire:ignore.self>
                                    <label class="form-label" for="validationCustom01">{{ __('messages.area') }} <span class="text-danger">*</span> </label>
                                    <select class="custom-select form-control" wire:model.defer="area_id" disabled>
                                        <option value="">{{ __('messages.to_select') }}</option>
                                        @foreach ($areas_user as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['description'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-row">
								<div class="col-md-4 mb-3">
									<label class="form-label">{{ __('messages.user_requests') }}</label>
									<input type="text" class="form-control" value="{{ $requesting_user_name }}" disabled>
								</div>
                                <div class="col-md-8 mb-3">
									<label class="form-label">{{ __('messages.requesting_username') }}</label>
									<div class="input-group">
										<input type="text" class="form-control" value="{{ $requesting_user_trade_name }}" disabled>
                                        <div class="input-group-prepend">
											<button onclick="openModalSeachUser()" type="button" class="btn btn-outline-default waves-effect waves-themed">
                                                <i class="fal fa-search"></i>
                                            </button>
										</div>
									</div>
								</div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
									<label class="form-label">{{ __('messages.ticket') }} {{ __('messages.number') }}</label>
									<input type="text" class="form-control" value="{{ __('messages.automatic') }}" disabled>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
                    <div class="row">
                        <div class="col-6" wire:ignore.self>
                            <label class="form-label">{{ __('messages.category') }} <span class="text-danger">*</span> </label>
                            <select class="custom-select form-control" wire:model.defer="category_id" wire:change="loadSubCategories">
                                <option value="">{{ __('messages.to_select') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category['id'] }}">{{ $category['short_description'] }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6 mb-3" wire:ignore.self>
                            <label class="form-label">{{ __('messages.subcategory') }} <span class="text-danger">*</span> </label>
                            <select class="custom-select form-control" wire:model.defer="subcategory_id" wire:change="loadDescriptionDefault">
                                <option value="">{{ __('messages.to_select') }}</option>
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory['id'] }}">{{ $subcategory['short_description'] }}</option>
                                @endforeach
                            </select>
                            @error('subcategory_id')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 mb-3">
                            <label class="form-label">{{ __('messages.priority') }} <span class="text-danger">*</span> </label>
                            <select class="custom-select form-control" wire:model.defer="priority_id">
                                <option value="">{{ __('messages.to_select') }}</option>
                                @foreach ($priorities as $priority)
                                    <option value="{{ $priority['id'] }}">{{ $priority['description'] }}</option>
                                @endforeach
                            </select>
                            @error('priority_id')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label">{{ __('messages.reception_mode') }} <span class="text-danger">*</span> </label>
                            <select class="custom-select form-control" wire:model.defer="reception_id">
                                <option value="">{{ __('messages.to_select') }}</option>
                                @foreach ($receptions as $reception)
                                    <option value="{{ $reception['id'] }}">{{ $reception['description'] }}</option>
                                @endforeach
                            </select>
                            @error('reception_id')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label">{{ __('messages.date') }} <span class="text-danger">*</span> </label>
                            <div class="input-group" wire:ignore>
                                <input required="" type="text" class="form-control" wire:model.defer="registration_date" name="registration_date" id="datepicker-7" onchange="this.dispatchEvent(new InputEvent('input'))">
                                <div class="input-group-append">
                                    <span class="input-group-text fs-xl">
                                        <i class="fal fa-calendar-alt"></i>
                                    </span>
                                </div>
                            </div>
                            @error('registration_date')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ __('messages.description') }} <span class="text-danger">*</span> </label>
                            <textarea class="form-control" rows="6" wire:model.defer="description"></textarea>
                            @error('description')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="form-group mb-0">
                                <label class="form-label">{{ __('messages.file_browser') }}</label>
                                <div class="custom-file" wire:ignore>
                                    <input type="file" class="custom-file-input" id="customFile" accept="application/pdf" wire:model.defer="files">
                                    <label class="custom-file-label" for="customFile">{{ __('messages.choose_file') }}</label>
                                </div>
                                @error('files') <span class="error">{{ $message }}</span> @enderror
                            </div>
                            <div class="mt-3">
                            @foreach ($files_olds as $files_old)
                                <div class="btn-group btn-group-sm mb-2">
                                    <a href="{{ asset('storage/'.$files_old['url']) }}" target="_blank" type="button" class="btn btn-default btn-xs px-1 py-1 fw-500 waves-effect waves-themed">
                                        <span class="d-block text-truncate text-truncate-sm">
                                            <i class="fal fa-file-pdf mr-1 color-danger-700"></i> {{ $files_old['original_name'] }}
                                        </span>
                                    </a>
                                    @if($state == 'sent')
                                        <button wire:click="destroyFile({{ $files_old->id }})" type="button" class="btn btn-default btn-xs px-1 py-1 fw-500 waves-effect waves-themed"><i class="fal fa-times"></i></button>
                                    @endif
                                </div>
                            @endforeach
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">{{ __('messages.version_sicmact') }}</label>
                            <input type="text" class="form-control" wire:model.defer="version_sicmact">
                        </div>
                    </div>
                </div>
            <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                <a href="{{ route('support_helpdesk_my_tickets_registered') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
                @if($state == 'sent')
                    <button wire:loading.attr="disabled" class="btn btn-primary ml-auto waves-effect waves-themed" type="button" wire:click="update">
                        <i class="fal fa-check mr-1"></i>{{ __('messages.to_update') }}
                    </button>
                @endif
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div wire:ignore class="modal fade" id="exampleModalSearchUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.search') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div wire:ignore>
                        <select data-placeholder="@lang('messages.select_state')" class="js-data-example-ajax form-control" id="select2-ajax"  onchange="selectUser(event)"></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openModalSeachUser(){
            $('#exampleModalSearchUser').modal('show');
        }
        function selectUser(e){
            @this.selectUser(e.target.value);
            $('#exampleModalSearchUser').modal('hide');
        }
        window.addEventListener('response_success_ticket_update', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
