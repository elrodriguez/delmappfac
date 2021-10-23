<div class="panel-container show">
    <form  class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="update">
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('messages.name') }}</label>
                    <select class="custom-select form-control" wire:model.defer="category_id">
                        <option value="">{{ __('messages.to_select') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->short_description }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('messages.name') }} <span class="text-danger">*</span> </label>
                    <input class="form-control" id="name" name="name" required="" wire:model.defer="name">
                    @error('name')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('messages.description') }}</label>
                    <textarea wire:model.defer="description" class="form-control" ></textarea>
                    @error('description')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('messages.days') }}</label>
                    <select wire:model.defer="days" class="custom-select from-control text-right" >
                        @for ($c = 0;$c<=31;$c++)
                            <option value="{{ $c }}">{{ $c }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('messages.hours') }}</label>
                    <select wire:model.defer="hours" class="custom-select from-control text-right" >
                        @for ($c = 0;$c<=23;$c++)
                            <option value="{{ $c }}">{{ $c }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('messages.minutes') }}</label>
                    <select wire:model.defer="minutes" class="custom-select from-control text-right" >
                        @for ($c = 0;$c<=59;$c++)
                            <option value="{{ $c }}">{{ $c }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="state" wire:model.defer="state">
                        <label class="custom-control-label" for="state">{{ __('messages.active') }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('support_administration_category') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
            <button wire:loading.attr="disabled" class="btn btn-primary ml-auto waves-effect waves-themed" type="submit">
                <i class="fal fa-check mr-1"></i>{{ __('messages.to_update') }}
            </button>
        </div>
    </form>
    <script>
        window.addEventListener('response_success_supcategory_update', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
