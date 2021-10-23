<div>
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>@lang('messages.new')</h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div class="row">
                    <div class="col-4" wire:ignore.self>
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
                    <div class="col-4 mb-3" wire:ignore.self>
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
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">{{ __('messages.version_sicmact') }}</label>
                        <input type="text" class="form-control" wire:model.defer="version_sicmact">
                    </div>
                </div>
            </div>
            <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                <a href="{{ route('support_helpdesk_ticket_applicant') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
                <button wire:loading.attr="disabled" class="btn btn-primary ml-auto waves-effect waves-themed" type="button" wire:click="store">
                    <i class="fal fa-check mr-1"></i>{{ __('messages.save') }}
                </button>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('response_success_ticket_store', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
