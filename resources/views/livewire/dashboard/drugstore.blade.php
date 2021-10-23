<div>
    @role('SuperAdmin|Administrador')
    <div class="subheader">
        <h1 class="subheader-title">
            <i class="subheader-icon fal fa-chart-area"></i> {{ __('messages.analytics_dashboard') }}
        </h1>
        @livewire('dashboard.warehouse.expenses-total')
        @livewire('dashboard.warehouse.profits-total')
    </div>
    <div class="row">
        <div class="col-4">
            @livewire('dashboard.academic.total-users')
            @livewire('dashboard.rrhh.employes-quantity')
        </div>
        <div class="col-4">
            @livewire('dashboard.warehouse.products-quantity')
            @livewire('dashboard.warehouse.categories-quantity')
        </div>
        <div class="col-4">
            @livewire('dashboard.warehouse.suppliers-quantity')
            @livewire('dashboard.warehouse.brands-quantity')
        </div>
    </div>
    @endrole
</div>
