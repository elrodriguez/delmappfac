@if ($paginator->hasPages())
    <div class="text-muted mr-1 mr-lg-3 ml-auto">
        {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} <span class="hidden-lg-down"> of {{ $paginator->total() }} </span>
    </div>
    <div class="d-flex flex-wrap">
        @if ($paginator->onFirstPage())
            <button class="btn btn-icon rounded-circle"><i class="fal fa-chevron-left fs-md"></i></button>
        @else
            <button wire:click="previousPage" wire:loading.attr="disabled" class="btn btn-icon rounded-circle"><i class="fal fa-chevron-left fs-md"></i></button>
        @endif
        
        @if ($paginator->hasMorePages())
            <button wire:click="nextPage" wire:loading.attr="disabled" class="btn btn-icon rounded-circle"><i class="fal fa-chevron-right fs-md"></i></button>
        @else
            <button class="btn btn-icon rounded-circle" disabled="disabled"><i class="fal fa-chevron-right fs-md"></i></button>
        @endif
    </div>
@endif
