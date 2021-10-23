<x-app-layout>
    @section('styles')

    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item active">Chat</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-plus-circle'></i> Chat
                <small>
                    A robust and simple chat component that is flexible, intuitive, easy to use and customize
                </small>
            </h1>
        </div>

    </x-slot>
    <div id="panel-11" class="panel">
        <div class="panel-hdr">
            <h2>
                Chat <span class="fw-300">interno</span>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse" aria-describedby="tooltip126608"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                @livewire('chat.inbox-container')
            </div>
            <!-- panel footer with utility classes -->
        </div>
    </div>
    @section('script')

    @endsection
</x-app-layout>
