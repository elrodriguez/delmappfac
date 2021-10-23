<div>
    <div class="card border mb-g">
        <div class="card-header py-2">
            <div class="card-title">
                {{ __('messages.solutions_for_similar_problems') }}
            </div>
        </div>
        <div class="card-body pl-4 pt-4 pr-4 pb-0">

            @foreach ($recommended as $item)
            <div class="alert border border-primary bg-transparent text-primary">

                <span class="h5">{{ $item->internal_id }}</span>
                <br>
                <p>{{ $item->solution_description }}</p>
                <div class="mt-3">
                    @if($item->files_olds)
                        @foreach (json_decode($item->files_olds) as $files_old)
                            <div class="btn-group btn-group-sm mb-2">
                                <a href="{{ asset('storage/'.$files_old->url) }}" target="_blank" type="button" class="btn btn-default btn-xs px-1 py-1 fw-500 waves-effect waves-themed">
                                    <span class="d-block text-truncate text-truncate-sm">
                                        <i class="fal fa-file-pdf mr-1 color-danger-700"></i> {{ $files_old->name }}
                                    </span>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="d-flex align-items-center demo-h-spacing py-3">
					<a wire:click="points({{ $item->id }})" href="javascript:void(0);" class="d-inline-flex align-items-center text-dark">
					    <i class="fas fa-heart fs-xs mr-1 text-danger"></i> <span>{{ $item->points }} Likes</span>
					</a>
				</div>
            </div>
            @endforeach

        </div>
        <div class="card-footer text-muted p-2 panel-content d-flex flex-row align-items-center">
            <div class="ml-auto">
                {{ $recommended->links() }}
            </div>
        </div>
    </div>
</div>
