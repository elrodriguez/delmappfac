<div>
    <div class="card mb-g">
        <div class="row row-grid no-gutters">
            <div class="col-12">
                <div class="p-3">
                    <h2 class="mb-0 fs-xl">{{ __('messages.solutions') }}</h2>
                </div>
            </div>
            <div class="col-12">
                <div class="p-3">
                    @foreach ($solutions as $solution)
                        {{ $solution->solution_description }}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
