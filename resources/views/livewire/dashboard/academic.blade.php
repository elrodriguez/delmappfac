<div>
    @role('SuperAdmin|Administrador')
    <div class="subheader">
        <h1 class="subheader-title">
            <i class="subheader-icon fal fa-chart-area"></i> {{ __('messages.analytics_dashboard') }}
        </h1>

        @livewire('dashboard.academic.total-document-income')
    </div>
    <div class="row">
        <div class="col-sm-6 col-xl-3">
            @livewire('dashboard.academic.total-student')
            @livewire('dashboard.academic.total-teachers')
        </div>
        <div class="col-sm-6 col-xl-3">
            @livewire('dashboard.academic.total-users')
            @livewire('dashboard.academic.number-documents')
        </div>
    </div>
    @endrole
</div>
