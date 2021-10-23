<div class="panel-container show">

    <div class="panel-content">
        <div class="panel-tag"><code>PROYECTO</code> {{ $project_description }}</div>
        <form id="formProjects" class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="store()">
            <div class="form-row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">{{ __('messages.description') }} <span class="text-danger">*</span> </label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="description" name="description" wire:model.defer="description">
                        <div class="input-group-append">
                            <button class="btn btn-primary waves-effect waves-themed">{{ __('messages.add') }}</button>
                        </div>
                    </div>
                    @error('description')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </form>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped w-100 dataTable dtr-inline collapsed">
                <thead class="bg-info-900">
                    <tr>
                        <th class="text-center">#</th>
                        <th>{{ __('messages.description') }}</th>
                        <th style="width: 160px" class="text-center">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($stages)>0)
                        @php
                            $total = count($stages);
                            $c = 1;
                        @endphp
                        @foreach ($stages as $key => $stage)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>{{ $stage->description }}</td>
                            <td class="text-center align-middle">
                                <div class="btn-group mr-2" role="group" aria-label="Group A">
                                    @if($c > 1)
                                    <button wire:click="changeordernumber('1','{{ $stage->id }}','{{ $c }}','{{ $key }}')" type="button" class="btn btn-outline-secondary waves-effect waves-themed">
                                        <i class="fal fa-arrow-alt-up"></i>
                                    </button>
                                    @endif
                                    @if($total > $c)
                                    <button wire:click="changeordernumber('0','{{ $stage->id }}','{{ $c }}','{{ $key }}')" type="button" class="btn btn-outline-secondary waves-effect waves-themed">
                                        <i class="fal fa-arrow-alt-down"></i>
                                    </button>
                                    @endif
                                    <button wire:click="deleteItem('{{ $stage->id}}','{{ $c }}')" type="button" class="btn btn-secondary waves-effect waves-themed">
                                        <i class="fal fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @php
                            $c++;
                        @endphp
                        @endforeach
                    @else
                    <tr class="odd">
                        <td colspan="12" class="dataTables_empty text-center" valign="top">{{ __('messages.no_data_available_in_the_table') }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        <a href="{{ route('logistics_production_projects') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>

    </div>

    <script>
        window.addEventListener('response_projects_stages', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
