<div>
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>@lang('messages.search_filters')</h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <form action="{{ route('support_report_ticket_attended_users')}}" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">@lang('messages.date')<span class="text-danger">*</span></label>
                            <div class="input-group" wire:ignore>
                                <input type="text" class="form-control" id="custom-range">
                                <div class="input-group-append">
                                    <span class="input-group-text fs-xl">
                                        <i class="fal fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            <div wire:ignore>
                                <input type="hidden" id="date_start" name="date_start">
                                <input type="hidden" id="date_end" name="date_end">
                            </div>
                            @error('date_start')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                            @error('date_end')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="warehouse" class="form-label">{{ __('messages.establishment') }}</label>
                            <select class="custom-select form-control" id="establishment_id" name="establishment_id" wire:model.defer="establishment_id">
                                <option value="">{{ __('messages.to_select') }}</option>
                                @foreach ($establishments as $establishment)
                                    <option value="{{ $establishment->id }}">{{ $establishment->name }}</option>
                                @endforeach
                            </select>
                            @error('establishment_id')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12 mb-3 d-flex flex-row align-items-center">
                            <button  type="submit" class="btn btn-secondary ml-auto waves-effect waves-themed mr-3"><i class="fal fa-file-search mr-1"></i>{{ __('messages.excel') }}</button>
                            <button wire:click="getUsersState" wire:loading.attr="disabled" type="button" class="btn btn-primary waves-effect waves-themed" >
                                <span class="fal fa-search mr-2" role="status" aria-hidden="true"></span>
                                <span>{{ __('messages.search') }}</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="panel-2" class="panel panel-locked panel-sortable" data-panel-lock="false" data-panel-close="false" data-panel-fullscreen="false" data-panel-collapsed="false" data-panel-color="false" data-panel-locked="false" data-panel-refresh="false" data-panel-reset="false" role="widget">
        <div class="panel-hdr" role="heading">
            <h2 class="ui-sortable-handle">
                {{ __('messages.users') }}
            </h2>
        </div>
        <div class="panel-container p-0 show" role="content">
            <div class="table-responsive">
                <table id="dt-basic-example" class="table table-bordered table-striped m-0">
                    <thead>
                        <tr>
                            <td class="align-middle">{{ __('messages.name') }}</td>
                            <td class="align-middle">{{ __('messages.state') }}</td>
                            <td class="text-center align-middle">{{ __('messages.quantity') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($users)>0)
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->trade_name }}</td>
                                    <td>
                                        @if($user->state == 'sent')
                                            <span class="badge badge-primary badge-pill">{{ __('messages.'.$user->state) }}</span>
                                        @elseif($user->state == 'attended')
                                            <span class="badge badge-secondary badge-pill">{{ __('messages.'.$user->state) }}</span>
                                        @elseif($user->state == 'derivative')
                                            <span class="badge badge-dark badge-pill">{{ __('messages.'.$user->state) }}</span>
                                        @elseif($user->state == 'cancel')
                                            <span class="badge badge-danger badge-pill">{{ __('messages.rejected') }}</span>
                                        @elseif($user->state == 'closed_ok')
                                            <span class="badge badge-info badge-pill">{{ __('messages.'.$user->state) }}</span>
                                        @elseif($user->state == 'closed_fail')
                                            <span class="badge badge-warning badge-pill">{{ __('messages.'.$user->state) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-right">{{ $user->quantity }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="odd">
                                <td colspan="10" class="dataTables_empty text-center" valign="top">{{ __('messages.no_data_available_in_the_table') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function selectDate(start,end){
            @this.set('date_start',start);
            @this.set('date_end',end);
            document.getElementById("date_start").value = start;
            document.getElementById("date_end").value = end;
        }
    </script>
</div>
