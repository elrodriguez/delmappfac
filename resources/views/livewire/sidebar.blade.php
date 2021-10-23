@php
    $path = explode('/', request()->path());
    $path[1] = (array_key_exists(1, $path)> 0)?$path[1]:'';
    $path[2] = (array_key_exists(2, $path)> 0)?$path[2]:'';
    $path[3] = (array_key_exists(3, $path)> 0)?$path[3]:'';
    //$path[0] = ($path[0] === '')?'dashboard':$path[0];
    
    $company = \App\Models\Master\Company::first();
@endphp
<aside class="page-sidebar">
    <div class="page-logo">
        <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
            @if(file_exists(public_path('storage/'.$company->logo)))
            <img src="{{ url('storage/'.$company->logo) }}" alt="{{ config('app.name', 'Laravel') }}" aria-roledescription="logo">
            @else
            <img src="{{ url('theme/img/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" aria-roledescription="logo">
            @endif
            <span class="page-logo-text mr-1">{{ config('app.name', 'Laravel') }}</span>
            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <!-- BEGIN PRIMARY NAVIGATION -->
    <nav id="js-primary-nav" class="primary-nav" role="navigation" x-data="{ open: false }">
        <div class="nav-filter">
            <div class="position-relative">
                <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                    <i class="fal fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="info-card">
            @if(auth()->user()->profile_photo_path)
            <img src="{{ asset('storage/'.auth()->user()->profile_photo_path) }}" style="width:50px;height: 50px;" class="profile-image rounded-circle" alt="{{ auth()->user()->name }}">
            @else
            <img src="{{ ui_avatars_url(auth()->user()->name,50,'none') }}" style="width:50px;height: 50px;" class="profile-image rounded-circle" alt="{{ auth()->user()->name }}">
            @endif
            <div class="info-card-text">
                <a href="#" class="d-flex align-items-center text-white">
                    <span class="text-truncate text-truncate-sm d-inline-block">
                    {{ auth()->user()->name }}
                    </span>
                </a>
                <span class="d-inline-block text-truncate text-truncate-sm">{{ auth()->user()->email }}</span>
            </div>
            <img src="{{ url('theme/img/card-backgrounds/cover-2-lg.png') }}" class="cover" alt="cover">
            <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                <i class="fal fa-angle-down"></i>
            </a>
        </div>
        <ul id="js-nav-menu" class="nav-menu">

                <li class="{{ ($path[0] === 'dashboard')?'active open':'' }}">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fal fa-tachometer-alt"></i>
                        <span class="nav-link-text" data-i18n="nav.Dashboard">Dashboard</span>
                        <span class="dl-ref bg-primary-500 hidden-nav-function-minify hidden-nav-function-top">Nuevo</span>
                    </a>
                </li>
                @can('configuracion')
                    <li class="nav-title">@lang('messages.system_configuration')</li>
                    @can('maestros')
                        <li class="{{ ($path[0] === 'configurations' && $path[1] === 'master')?'active open':'' }}">
                            <a href="#" title="@lang('messages.master')" data-filter-tags="@lang('messages.master')">
                                <i class="fal fa-cubes"></i>
                                <span class="nav-link-text" data-i18n="nav.@lang('messages.master')">@lang('messages.master')</span>
                            </a>
                            <ul>
                                @can('roles')
                                <li class="{{ ($path[0] === 'configurations' && $path[1] === 'master' && $path[2] === 'roles')?'active':'' }}">
                                    <a href="{{ route('roles') }}" title="{{ __('messages.roles_permissions') }}" data-filter-tags="{{ __('messages.roles_permissions') }}">
                                        <span class="nav-link-text" data-i18n="nav.{{ __('messages.roles_permissions') }}">{{ __('messages.roles_permissions') }}</span>
                                    </a>
                                </li>
                                @endcan
                                @can('usuarios')
                                <li class="{{ ($path[0] === 'configurations' && $path[1] === 'master' && $path[2] === 'users')?'active':'' }}">
                                    <a href="{{ route('users') }}" title="Lista de Usuarios" data-filter-tags="lista de usuarios">
                                        <span class="nav-link-text" data-i18n="nav.lista_de_usuarios">{{ __('messages.users') }}</span>
                                    </a>
                                </li>
                                @endcan
                                @can('actividades_usuario_log')
                                <li class="{{ ($path[0] === 'configurations' && $path[1] === 'master' && $path[1] === 'users_activity_log')?'active':'' }}">
                                    <a href="{{ route('users_activity_log') }}" title="{{ __('messages.user_activities') }}" data-filter-tags="{{ __('messages.user_activities') }}">
                                        <span class="nav-link-text" data-i18n="nav.registro_actividades_de_usuario">{{ __('messages.user_activities') }}</span>
                                    </a>
                                </li>
                                @endcan
                                @can('establecimientos')
                                <li  class="{{ ($path[0] === 'configurations' && $path[1] === 'master' && $path[2] === 'establishments')?'active':'' }}">
                                    <a href="{{ route('establishments') }}" title="@lang('messages.establishment')" data-filter-tags="@lang('messages.establishment')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.establishment')">@lang('messages.establishment')</span>
                                    </a>
                                </li>
                                @endcan
                                @can('clientes')
                                <li  class="{{ ($path[0] === 'configurations' && $path[1] === 'master' && $path[1] === 'customers')?'active':'' }}">
                                    <a href="{{ route('customers') }}" title="@lang('messages.customers')" data-filter-tags="@lang('messages.customers')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.customers')">@lang('messages.customers')</span>
                                    </a>
                                </li>
                                @endcan
                                @can('configuracion_maestros_cuentas_bancarias')
                                <li  class="{{ ($path[0] === 'configurations' && $path[1] === 'master' && $path[1] === 'bank_account')?'active':'' }}">
                                    <a href="{{ route('configurations_master_bank_account') }}" title="@lang('messages.bank_accounts')" data-filter-tags="@lang('messages.bank_accounts')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.bank_accounts')">@lang('messages.bank_accounts')</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan
                    @endcan
                @can('logistic')
                    <!-- Dominio logistica -->
                    <li class="nav-title">@lang('messages.logistics')</li>
                    <li class="{{ ($path[1] === 'catalogs')?'active open':'' }}">
                        <a href="javascript:void(0);" title="@lang('messages.catalogs')" data-filter-tags="@lang('messages.catalogs')">
                            <i class="fal fa-book-reader"></i>
                            <span class="nav-link-text" data-i18n="nav.{{ __('messages.catalogs') }}">@lang('messages.catalogs')</span>
                        </a>
                        <ul>
                            @can('marcas')
                            <li class="{{ ($path[2] === 'brands')?'active':'' }}">
                                <a href="{{ route('logistics_catalogs_brands') }}" title="@lang('messages.brands')" data-filter-tags="@lang('messages.brands')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.brands')">@lang('messages.brands')</span>
                                </a>
                            </li>
                            @endcan
                            @can('logistic_catalogos_categorias')
                            <li class="{{ ($path[1] === 'catalogs' && $path[2] === 'categories')?'active':'' }}">
                                <a href="{{ route('logistics_catalogs_categories') }}" title="@lang('messages.categories')" data-filter-tags="@lang('messages.categories')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.categories')">@lang('messages.categories')</span>
                                </a>
                            </li>
                            @endcan
                            @can('productos')
                            <li class="{{ ($path[2] === 'products')?'active':'' }}">
                                <a href="{{ route('logistics_catalogs_products') }}" title="@lang('messages.products')" data-filter-tags="@lang('messages.products')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.products')">@lang('messages.products')</span>
                                </a>
                            </li>
                            @endcan
                            @can('proveedores')
                            <li class="{{ ($path[2] === 'providers')?'active':'' }}">
                                <a href="{{ route('logistics_catalogs_providers') }}" title="@lang('messages.providers')" data-filter-tags="@lang('messages.providers')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.providers')">@lang('messages.providers')</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>

                    <li class="{{ ($path[1] === 'warehouse')?'active open':'' }}">
                        <a href="javascript:void(0);" title="@lang('messages.warehouse')" data-filter-tags="@lang('messages.warehouse')">
                            <i class="fal fa-cubes"></i>
                            <span class="nav-link-text" data-i18n="nav.logistica_almacen">@lang('messages.warehouse')</span>
                        </a>
                        <ul>
                            @can('compras')
                            <li class="{{ ($path[2] === 'shopping')?'active open':'' }}">
                                <a href="javascript:void(0);" title="@lang('messages.shopping')" data-filter-tags="@lang('messages.shopping')" class=" waves-effect waves-themed"  aria-expanded="true">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.shopping')">@lang('messages.shopping')</span>
                                </a>
                                <ul>
                                    @can('compras_nuevo')
                                    <li class="{{ ($path[3] === 'new')?'active':'' }}">
                                            <a href="{{ route('logistics_warehouse_shopping_created') }}" title="@lang('messages.new')" data-filter-tags="@lang('messages.new')" class=" waves-effect waves-themed">
                                                <span class="nav-link-text" data-i18n="nav.@lang('messages.new')">@lang('messages.new')</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('compras_listar')
                                    <li class="{{ ($path[3] === 'list')?'active':'' }}">
                                        <a href="{{ route('logistics_warehouse_shopping') }}" title="@lang('messages.list')" data-filter-tags="@lang('messages.list')" class=" waves-effect waves-themed">
                                            <span class="nav-link-text" data-i18n="nav.@lang('messages.list')">@lang('messages.list')</span>
                                        </a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcan
                            @can('Inventario')
                            <li class="{{ ($path[2] === 'inventory')?'active open':'' }}">
                                <a href="javascript:void(0);" title="@lang('messages.inventory')" data-filter-tags="@lang('messages.inventory')" class=" waves-effect waves-themed"  aria-expanded="true">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.inventory')">@lang('messages.inventory')</span>
                                </a>
                                <ul>
                                    @can('inventario_ubicaciones')
                                        <li class="{{ ($path[3] === 'locations')?'active':'' }}">
                                            <a href="{{ route('logistics_warehouse_inventory_locations') }}" title="@lang('messages.inventory_locations')" data-filter-tags="@lang('messages.inventory_locations')" class=" waves-effect waves-themed">
                                                <span class="nav-link-text" data-i18n="nav.{{ wspacelang('inventory_locations') }}">@lang('messages.inventory_locations')</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('logistic_almacen_inventario_movimientos')
                                        <li class="{{ ($path[0] === 'logistics' && $path[1] === 'warehouse' && $path[2] === 'inventory' && $path[3] === 'movements')?'active':'' }}">
                                            <a href="{{ route('logistics_warehouse_inventory_movements') }}" title="@lang('messages.movements')" data-filter-tags="@lang('messages.movements')">
                                                <span class="nav-link-text" data-i18n="nav.{{ wspacelang('movements') }}">@lang('messages.movements')</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('logistic_almacen_inventario_traslados')
                                        <li class="{{ ($path[0] === 'logistics' && $path[1] === 'warehouse' && $path[2] === 'inventory' && $path[3] === 'transfers')?'active':'' }}">
                                            <a href="{{ route('logistics_warehouse_inventory_transfers') }}" title="@lang('messages.transfers')" data-filter-tags="@lang('messages.transfers')">
                                                <span class="nav-link-text" data-i18n="nav.{{ wspacelang('transfers') }}">@lang('messages.transfers')</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('reporte_kardex')
                                        <li class="{{ ($path[3] === 'report_kardex')?'active':'' }}">
                                            <a href="{{ route('logistics_warehouse_report_kardex') }}" title="@lang('messages.kardex_report')" data-filter-tags="@lang('messages.kardex_report')" class=" waves-effect waves-themed">
                                                <span class="nav-link-text" data-i18n="nav.{{ wspacelang('kardex_report') }}">@lang('messages.kardex_report')</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('reporte_inventario')
                                        <li class="{{ ($path[3] === 'report_inventory')?'active':'' }}">
                                            <a href="{{ route('logistics_warehouse_report_inventory') }}" title="@lang('messages.inventory_report')" data-filter-tags="@lang('messages.inventory_report')" class=" waves-effect waves-themed">
                                                <span class="nav-link-text" data-i18n="nav.{{ wspacelang('inventory_report') }}">@lang('messages.inventory_report')</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('reporte_kardex_valorizado')
                                        <li class="{{ ($path[3] === 'reporte_kardex_valorizado')?'active':'' }}">
                                            <a href="{{ route('logistics_warehouse_reporte_kardex_valued') }}" title="@lang('messages.kardex_valued')" data-filter-tags="@lang('messages.kardex_valued')" class=" waves-effect waves-themed">
                                                <span class="nav-link-text" data-i18n="nav.@lang('messages.kardex_valued')">@lang('messages.kardex_valued')</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcan
                            @can('proyectos_orden')
                            <li class="{{ ($path[2] === 'project_orders')?'active':'' }}">
                                <a href="{{ route('logistics_warehouse_proyectos_orden') }}" title="@lang('messages.project_orders')" data-filter-tags="@lang('messages.project_orders')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.project_orders')">@lang('messages.project_orders')</span>
                                </a>
                            </li>
                            @endcan

                            @can('ingresos')
                            <li class="{{ ($path[1] === 'income')?'active open':'' }}">
                                <a href="javascript:void(0);" title="@lang('messages.income')" data-filter-tags="@lang('messages.income')" class="waves-effect waves-themed" aria-expanded="true">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.income')">@lang('messages.income')</span>
                                </a>
                                <ul>

                                    @can('ingreso envases')
                                    <li class="{{ ($path[2] === 'packaging')?'active':'' }}">
                                        <a href="{{ route('income') }}" title="@lang('messages.packaging')" data-filter-tags="@lang('messages.packaging')" class=" waves-effect waves-themed">
                                            <span class="nav-link-text" data-i18n="nav.@lang('messages.packaging')">@lang('messages.packaging')</span>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('ingreso pesca')
                                    <li class="{{ ($path[2] === 'fishing')?'active':'' }}">
                                        <a href="{{ route('warehouse_fishing') }}" title="@lang('messages.fishing')" data-filter-tags="@lang('messages.fishing')" class=" waves-effect waves-themed">
                                            <span class="nav-link-text" data-i18n="nav.@lang('messages.fishing')">@lang('messages.fishing')</span>
                                        </a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @endcan
                            @can('Materiales')
                            <li class="{{ ($path[1] === 'materials')?'active':'' }}">
                                <a href="{{ route('materials') }}" title="@lang('messages.materials')" data-filter-tags="@lang('messages.materials')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.materials')">@lang('messages.materials')</span>
                                </a>
                            </li>
                            @endcan
                            @can('producion')
                            <li class="{{ ($path[1] === 'production_today')?'active':'' }}">
                                <a href="{{ route('production_today_list') }}" title="@lang('messages.production')" data-filter-tags="@lang('messages.production')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.production')">@lang('messages.production')</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @can('logistic_production')
                        <li class="{{ ($path[1] === 'production')?'active open':'' }}">
                            <a href="javascript:void(0);" title="@lang('messages.production')" data-filter-tags="@lang('messages.production')" class=" waves-effect waves-themed"  aria-expanded="true">
                                <i class="fal fa-industry-alt"></i>
                                <span class="nav-link-text" data-i18n="nav.@lang('messages.production')">@lang('messages.production')</span>
                            </a>
                            <ul>
                                @can('proyectos')
                                <li class="{{ ($path[2] === 'projects')?'active':'' }}">
                                        <a href="{{ route('logistics_production_projects') }}" title="@lang('messages.projects')" data-filter-tags="@lang('messages.projects')" class=" waves-effect waves-themed">
                                            <span class="nav-link-text" data-i18n="nav.@lang('messages.projects')">@lang('messages.projects')</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                @endcan
                {{-- dominio academico--}}
                @can('academic')
                <li class="nav-title">@lang('messages.academic')</li>
                    @can('academico_administracion')
                        <li class="{{ ($path[0] === 'academic' && $path[1] === 'administration')?'active open':'' }}">
                            <a href="#" title="@lang('messages.administration')" data-filter-tags="@lang('messages.administration')">
                                <i class="fal fa-cogs"></i>
                                <span class="nav-link-text" data-i18n="nav.{{ wspacelang('administration') }}">@lang('messages.administration')</span>
                            </a>
                            <ul>
                                @can('academico_curricula')
                                <li class="{{ ($path[2] === 'curriculas')?'active':'' }}">
                                    <a href="{{ route('academic_curriculas') }}" title="@lang('messages.curriculas')" data-filter-tags="@lang('messages.curriculas')">
                                        <span class="nav-link-text" data-i18n="nav.{{ wspacelang('curriculas') }}">@lang('messages.curriculas')</span>
                                    </a>
                                </li>
                                @endcan
                                @can('academico_temporadas')
                                <li class="{{ ($path[2] === 'seasons')?'active':'' }}">
                                    <a href="{{ route('academic_seasons') }}" title="@lang('messages.seasons')" data-filter-tags="@lang('messages.seasons')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.seasons')">@lang('messages.seasons')</span>
                                    </a>
                                </li>
                                @endcan
                                @can('Cursos')
                                <li class="{{ ($path[2] === 'courses')?'active':'' }}">
                                    <a href="{{ route('academic_courses') }}" title="@lang('messages.courses')" data-filter-tags="@lang('messages.courses')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.courses')">@lang('messages.courses')</span>
                                    </a>
                                </li>
                                @endcan
                                @can('Docente')
                                <li class="{{ ($path[2] === 'teachers')?'active':'' }}">
                                    <a href="{{ route('academic_teachers') }}" title="@lang('messages.teachers')" data-filter-tags="@lang('messages.teachers')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.teachers')">@lang('messages.teachers')</span>
                                    </a>
                                </li>
                                @endcan
                                @can('Postulante')
                                <!--li class="{{ ($path[1] === 'postulants')?'active':'' }}">
                                    <a href="{{ route('postulants') }}" title="@lang('messages.postulants')" data-filter-tags="@lang('messages.postulants')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.postulants')">@lang('messages.postulants')</span>
                                    </a>
                                </li-->
                                @endcan
                                @can('alumnos')
                                <li class="{{ ($path[2] === 'students')?'active':'' }}">
                                    <a href="{{ route('academic_students') }}" title="@lang('messages.students')" data-filter-tags="@lang('messages.students')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.students')">@lang('messages.students')</span>
                                    </a>
                                </li>
                                @endcan
                                @can('servicios_academico')
                                <li class="{{ ($path[2] === 'products_services')?'active':'' }}">
                                    <a href="{{ route('academic_products_and_services') }}" title="@lang('messages.products_and_services')" data-filter-tags="@lang('messages.products_and_services')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.products_and_services')">@lang('messages.products_and_services')</span>
                                    </a>
                                </li>
                                @endcan
                                @can('descuento_academico')
                                <li class="{{ ($path[2] === 'discounts')?'active':'' }}">
                                    <a href="{{ route('academic_discounts') }}" title="@lang('messages.academic_discounts')" data-filter-tags="@lang('messages.academic_discounts')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.academic_discounts')">@lang('messages.academic_discounts')</span>
                                    </a>
                                </li>
                                @endcan
                                @can('Paquete_compromisos_promociones')
                                <li class="{{ ($path[2] === 'packages')?'active':'' }}">
                                    <a href="{{ route('academic_packages') }}" title="@lang('messages.package_commitments_promotions')" data-filter-tags="@lang('messages.package_commitments_promotions')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.package_commitments_promotions')">@lang('messages.package_commitments_promotions')</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('academico_cobros')
                        <li class="{{ ($path[1] === 'charges')?'active open':'' }}">
                            <a href="#" title="@lang('messages.charges')" data-filter-tags="@lang('messages.charges')">
                                <i class="fal fa-cash-register"></i>
                                <span class="nav-link-text" data-i18n="nav.@lang('messages.charges')">@lang('messages.charges')</span>
                            </a>
                            <ul>
                                @can('academico_nuevo_comprobante')
                                <li class="{{ ($path[2] === 'new_document')?'active':'' }}">
                                    <a href="{{ route('charges_new_document') }}" title="@lang('messages.new_document')" data-filter-tags="@lang('messages.new_document')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.new_document')">@lang('messages.new_document')</span>
                                    </a>
                                </li>
                                @endcan
                                @can('academico_listado_comprobante')
                                <li class="{{ ($path[2] === 'list_document')?'active':'' }}">
                                    <a href="{{ route('charges_list_document') }}" title="@lang('messages.voucher_list')" data-filter-tags="@lang('messages.voucher_list')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.voucher_list')">@lang('messages.voucher_list')</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('academico_matriculas')
                        <li class="{{ ($path[1] === 'enrollment')?'active open':'' }}">
                            <a href="#" title="@lang('messages.enrollment')" data-filter-tags="@lang('messages.enrollment')">
                                <i class="fal fa-clipboard-user"></i>
                                <span class="nav-link-text" data-i18n="nav.@lang('messages.enrollment')"> @lang('messages.enrollment')</span>
                            </a>
                            <ul>
                                @can('matricula_registrar')
                                <li class="{{ ($path[2] === 'register')?'active':'' }}">
                                    <a href="{{ route('enrollment_register') }}" title="@lang('messages.register')" data-filter-tags="@lang('messages.register')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.register')">@lang('messages.register')</span>
                                    </a>
                                </li>
                                @endcan
                                @can('Lista_matriculados')
                                <li class="{{ ($path[2] === 'list_courses')?'active':'' }}">
                                    <a href="{{ route('enrollment_register_list_courses') }}" title="@lang('messages.enrolled_course')" data-filter-tags="@lang('messages.enrolled_course')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.enrolled_course')">@lang('messages.enrolled_course')</span>
                                    </a>
                                </li>
                                @endcan
                                @can('Lista_matriculados_cursos')
                                <li class="{{ ($path[2] === 'list')?'active':'' }}">
                                    <a href="{{ route('enrollment_register_list') }}" title="@lang('messages.school_enrollment')" data-filter-tags="@lang('messages.school_enrollment')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.school_enrollment')">@lang('messages.school_enrollment')</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('academico_asignaturas')
                        <li class="{{ ( $path[0] === 'academic' && $path[1] === 'subjects')?'active open':'' }}">
                            <a href="#" title="@lang('messages.subjects')" data-filter-tags="@lang('messages.subjects')">
                                <i class="fal fa-atlas"></i>
                                <span class="nav-link-text" data-i18n="nav.@lang('messages.subjects')"> @lang('messages.subjects')</span>
                            </a>
                            <ul>
                                @can('Listar_cursos_docente')
                                <li class="{{ ($path[2] === 'courses')?'active':'' }}">
                                    <a href="{{ route('subjects_courses_teacher') }}" title="@lang('messages.prepare_plasses')" data-filter-tags="@lang('messages.prepare_plasses')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.prepare_plasses')">@lang('messages.prepare_plasses')</span>
                                    </a>
                                </li>
                                @endcan
                                @can('mis_cursos')
                                <li class="{{ ($path[2] === 'mycourses')?'active':'' }}">
                                    <a href="{{ route('subjects_student_my_courses') }}" title="@lang('messages.my_courses')" data-filter-tags="@lang('messages.my_courses')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.my_courses')">@lang('messages.my_courses')</span>
                                    </a>
                                </li>
                                @endcan
                                @can('listado_alumno_del_capacitacion_asistencia')
                                <li class="{{ ($path[2] === 'assistance')?'active':'' }}">
                                    <a href="{{ route('subjects_training_students_assistance') }}" title="@lang('messages.assistance')" data-filter-tags="@lang('messages.assistance')">
                                        <span class="nav-link-text" data-i18n="nav.@lang('messages.assistance')">@lang('messages.assistance')</span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                @endcan

                {{-- dominio rrhh--}}
                @can('rrhh')
                <li class="nav-title">@lang('messages.rrhh')</li>
                    @can('rrhh_administracion')
                    <li class="{{ ($path[0] === 'rrhh' && $path[1] === 'administration')?'active open':'' }}">
                        <a href="#" title="@lang('messages.administration')" data-filter-tags="@lang('messages.administration')">
                            <i class="fal fa-cogs"></i>
                            <span class="nav-link-text" data-i18n="nav.@lang('messages.administration')"> @lang('messages.administration')</span>
                        </a>
                        <ul>
                            @can('rrhh_administration_employees')
                            <li class="{{ ($path[2] === 'employees')?'active':'' }}">
                                <a href="{{ route('rrhh_administration_employees') }}" title="@lang('messages.employees')" data-filter-tags="@lang('messages.employees')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.employees')">@lang('messages.employees')</span>
                                </a>
                            </li>
                            @endcan
                            @can('rrhh_administration_concepts')
                            <li class="{{ ($path[2] === 'concepts')?'active':'' }}">
                                <a href="{{ route('rrhh_administration_concepts') }}" title="@lang('messages.concepts')" data-filter-tags="@lang('messages.concepts')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.concepts')">@lang('messages.concepts')</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                    @can('rrhh_pagos')
                    <li class="{{ ($path[1] === 'payments')?'active open':'' }}">
                        <a href="#" title="@lang('messages.payments')" data-filter-tags="@lang('messages.payments')">
                            <i class="fal fa-money-bill-wave"></i>
                            <span class="nav-link-text" data-i18n="nav.@lang('messages.payments')"> @lang('messages.payments')</span>
                        </a>
                        <ul>
                            @can('rrhh_pagos_adelantos')
                            <li class="{{ ($path[2] === 'advancements')?'active':'' }}">
                                <a href="{{ route('rrhh_payments_advancements') }}" title="@lang('messages.employee_concepts')" data-filter-tags="@lang('messages.employee_concepts')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.employee_concepts')">@lang('messages.employee_concepts')</span>
                                </a>
                            </li>
                            @endcan
                            @can('rrhh_boletas')
                            <li class="{{ ($path[2] === 'tickts')?'active':'' }}">
                                <a href="{{ route('rrhh_payments_ticket') }}" title="@lang('messages.tickets')" data-filter-tags="@lang('messages.tickets')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.tickets')">@lang('messages.tickets')</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                @endcan
                {{-- dominio market --}}
                @can('market')
                    <li class="nav-title">@lang('messages.market')</li>
                    @can('market_administration')
                    <li class="{{ ($path[0] === 'market' && $path[1] === 'administration')?'active open':'' }}">
                        <a href="#" title="@lang('messages.administration')" data-filter-tags="@lang('messages.administration')">
                            <i class="fal fa-cogs"></i>
                            <span class="nav-link-text" data-i18n="nav.@lang('messages.administration')"> @lang('messages.administration')</span>
                        </a>
                        <ul>
                            @can('market_administration_caja_chica')
                            <li class="{{ ($path[0] === 'market' && $path[1] === 'administration' && $path[2] === 'cash')?'active':'' }}">
                                <a href="{{ route('market_administration_cash') }}" title="@lang('messages.petty_cash')" data-filter-tags="@lang('messages.petty_cash')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.petty_cash')">@lang('messages.petty_cash')</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                    @can('ventas')
                    <li class="{{ ($path[0] === 'market' && $path[1] === 'sales')?'active open':'' }}">
                        <a href="#" title="@lang('messages.sales')" data-filter-tags="@lang('messages.sales')">
                            <i class="fal fa-cash-register"></i>
                            <span class="nav-link-text" data-i18n="nav.@lang('messages.sales')"> @lang('messages.sales')</span>
                        </a>
                        <ul>
                            @can('ventas_nuevo_comprobante')
                            <li class="{{ ($path[0] === 'market' && $path[1] === 'sales' && $path[2] === 'documents_create')?'active':'' }}">
                                <a href="{{ route('market_sales_document_create') }}" title="@lang('messages.new_document')" data-filter-tags="@lang('messages.new_document')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.new_document')">@lang('messages.new_document')</span>
                                </a>
                            </li>
                            @endcan
                            @can('ventas_lista_comprobantes')
                            <li class="{{ ($path[0] === 'market' && $path[1] === 'sales' && $path[2] === 'documents_list')?'active':'' }}">
                                <a href="{{ route('market_sales_document_list') }}" title="@lang('messages.voucher_list')" data-filter-tags="@lang('messages.voucher_list')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.voucher_list')">@lang('messages.voucher_list')</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                    @can('market_reportes')
                        <li class="{{ ($path[0] === 'market' && $path[1] === 'reports')?'active open':'' }}">
                            <a href="#" title="@lang('messages.reports')" data-filter-tags="@lang('messages.reports')">
                                <i class="fal fa-analytics"></i>
                                <span class="nav-link-text" data-i18n="nav.@lang('messages.reports')"> @lang('messages.reports')</span>
                            </a>
                            <ul>
                                @can('market_reportes_ventas_vendedor')
                                    <li class="{{ ($path[0] === 'market' && $path[1] === 'reports' && $path[2] === 'sales_seller')?'active':'' }}">
                                        <a href="{{ route('market_reports_sales_seller') }}" title="@lang('messages.sales_by_seller')" data-filter-tags="@lang('messages.sales_by_seller')">
                                            <span class="nav-link-text" data-i18n="nav.@lang('messages.sales_by_seller')">@lang('messages.sales_by_seller')</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('market_reportes_productos_mas_vendidos')
                                    <li class="{{ ($path[0] === 'market' && $path[1] === 'reports' && $path[2] === 'most_selled_products')?'active':'' }}">
                                        <a href="{{ route('market_reports_most_selled_products') }}" title="@lang('messages.most_selled_products')" data-filter-tags="@lang('messages.most_selled_products')">
                                            <span class="nav-link-text" data-i18n="nav.@lang('messages.most_selled_products')">@lang('messages.most_selled_products')</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('market_reportes_ventas_por_productos')
                                    <li class="{{ ($path[0] === 'market' && $path[1] === 'reports' && $path[2] === 'sales_by_products')?'active':'' }}">
                                        <a href="{{ route('market_reports_sales_products') }}" title="@lang('messages.sales_by_products')" data-filter-tags="@lang('messages.sales_by_products')">
                                            <span class="nav-link-text" data-i18n="nav.@lang('messages.sales_by_products')">@lang('messages.sales_by_products')</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                @endcan
                {{-- dominio soporte_tecnico --}}
                @can('soporte_tecnico')
                    <li class="nav-title">@lang('messages.technical_support')</li>
                    @can('soporte_tecnico_administracion')
                    <li class="{{ ($path[0] === 'support' && $path[1] === 'administration')?'active open':'' }}">
                        <a href="#" title="@lang('messages.administration')" data-filter-tags="@lang('messages.administration')">
                            <i class="fal fa-cogs"></i>
                            <span class="nav-link-text" data-i18n="nav.@lang('messages.administration')"> @lang('messages.administration')</span>
                        </a>
                        <ul>
                            @can('soporte_tecnico_administracion_categorias')
                            <li class="{{ ($path[0] === 'support' && $path[1] === 'administration' && $path[2] === 'category')?'active':'' }}">
                                <a href="{{ route('support_administration_category') }}" title="@lang('messages.category')" data-filter-tags="@lang('messages.category')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.category')">@lang('messages.category')</span>
                                </a>
                            </li>
                            @endcan
                            @can('soporte_tecnico_administracion_grupos')
                            <li class="{{ ($path[0] === 'support' && $path[1] === 'administration' && $path[2] === 'groups')?'active':'' }}">
                                <a href="{{ route('support_administration_groups') }}" title="@lang('messages.groups')" data-filter-tags="@lang('messages.groups')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.groups')">@lang('messages.groups')</span>
                                </a>
                            </li>
                            @endcan
                            @can('soporte_tecnico_administracion_area_usuarios')
                            <li class="{{ ($path[0] === 'support' && $path[1] === 'administration' && $path[2] === 'area_users')?'active':'' }}">
                                <a href="{{ route('support_administration_area_user') }}" title="@lang('messages.areas_and_user')" data-filter-tags="@lang('messages.areas_and_user')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.areas_and_user')">@lang('messages.areas_and_user')</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                    @can('soporte_tecnico_helpdesk')
                    <li class="{{ ($path[0] === 'support' && $path[1] === 'helpdesk')?'active open':'' }}">
                        <a href="#" title="@lang('messages.help_desk')" data-filter-tags="@lang('messages.help_desk')">
                            <i class="fal fa-keynote"></i>
                            <span class="nav-link-text" data-i18n="nav.@lang('messages.help_desk')"> @lang('messages.help_desk')</span>
                        </a>
                        <ul>
                            @can('soporte_tecnico_helpdesk_ticket')
                            <li class="{{ ($path[0] === 'support' && $path[1] === 'helpdesk' && $path[2] === 'ticket')?'active':'' }}">
                                <a href="{{ route('support_helpdesk_ticket') }}" title="@lang('messages.ticket')" data-filter-tags="@lang('messages.ticket')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.ticket')">@lang('messages.ticket')</span>
                                </a>
                            </li>
                            @endcan
                            @can('soporte_tecnico_helpdesk_ticket_applicant')
                            <li class="{{ ($path[0] === 'support' && $path[1] === 'helpdesk' && $path[2] === 'tickets_applicant')?'active':'' }}">
                                <a href="{{ route('support_helpdesk_ticket_applicant') }}" title="@lang('messages.requested_tickets')" data-filter-tags="@lang('messages.requested_tickets')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.requested_tickets')">@lang('messages.requested_tickets')</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                    @can('soporte_tecnico_reportes')
                    <li class="{{ ($path[0] === 'support' && $path[1] === 'reports')?'active open':'' }}">
                        <a href="#" title="@lang('messages.reports')" data-filter-tags="@lang('messages.reports')">
                            <i class="fal fa-analytics"></i>
                            <span class="nav-link-text" data-i18n="nav.@lang('messages.reports')"> @lang('messages.reports')</span>
                        </a>
                        <ul>
                            @can('soporte_tecnico_reportes_incidencias')
                            <li class="{{ ($path[0] === 'support' && $path[1] === 'reports' && $path[2] === 'incidents')?'active':'' }}">
                                <a href="{{ route('support_reports_ticket_incidents') }}" title="@lang('messages.incidents')" data-filter-tags="@lang('messages.incidents')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.incidents')">@lang('messages.incidents')</span>
                                </a>
                            </li>
                            @endcan
                            @can('soporte_tecnico_reportes_resumenes_estados')
                            <li class="{{ ($path[0] === 'support' && $path[1] === 'reports' && $path[2] === 'state_summaries')?'active':'' }}">
                                <a href="{{ route('support_reports_ticket_state_summaries') }}" title="@lang('messages.state_summaries')" data-filter-tags="@lang('messages.state_summaries')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.state_summaries')">@lang('messages.state_summaries')</span>
                                </a>
                            </li>
                            @endcan
                            @can('soporte_tecnico_reportes_ruta_ticket')
                            <li class="{{ ($path[0] === 'support' && $path[1] === 'reports' && $path[2] === 'ticket_path')?'active':'' }}">
                                <a href="{{ route('support_reports_ticket_path') }}" title="@lang('messages.ticket_path')" data-filter-tags="@lang('messages.ticket_path')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.ticket_path')">@lang('messages.ticket_path')</span>
                                </a>
                            </li>
                            @endcan
                            @can('soporte_tecnico_reportes_ticket_por_usuario')
                            <li class="{{ ($path[0] === 'support' && $path[1] === 'reports' && $path[2] === 'ticket_attended_user')?'active':'' }}">
                                <a href="{{ route('support_reports_ticket_attended_user') }}" title="@lang('messages.ticket_attended_by_user')" data-filter-tags="@lang('messages.ticket_attended_by_user')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.ticket_attended_by_user')">@lang('messages.ticket_attended_by_user')</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                @endcan
                @can('tienda_virtual')
                    <li class="nav-title">@lang('messages.onlineshop')</li>
                    @can('tienda_virtual_administracion')
                    <li class="{{ ($path[0] === 'shop' && $path[1] === 'administration')?'active open':'' }}">
                        <a href="#" title="@lang('messages.administration')" data-filter-tags="@lang('messages.administration')">
                            <i class="fal fa-cogs"></i>
                            <span class="nav-link-text" data-i18n="nav.@lang('messages.administration')"> @lang('messages.administration')</span>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('onlineshop_public_home') }}" title="{{ __('messages.sho_see_shop') }}" data-filter-tags="{{ __('messages.sho_see_shop') }}" >
                                    <span class="nav-link-text" data-i18n="nav.{{ __('messages.sho_see_shop') }}">{{ __('messages.sho_see_shop') }}</span>
                                    <span class="dl-ref bg-primary-500 hidden-nav-function-minify hidden-nav-function-top">{{ __('messages.direct_access') }}</span>
                                </a>
                            </li>
                            @can('tienda_virtual_administracion_configuraciones')
                            <li class="{{ ($path[0] === 'shop' && $path[1] === 'administration' && $path[2] === 'configurations')?'active':'' }}">
                                <a href="{{ route('onlineshop_administration_configurations') }}" title="@lang('messages.configurations')" data-filter-tags="@lang('messages.configurations')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.configurations')">@lang('messages.configurations')</span>
                                </a>
                            </li>
                            @endcan
                            @can('tienda_virtual_administracion_productos')
                            <li class="{{ ($path[0] === 'shop' && $path[1] === 'administration' && $path[2] === 'products')?'active':'' }}">
                                <a href="{{ route('onlineshop_administration_products') }}" title="@lang('messages.products')" data-filter-tags="@lang('messages.products')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.products')">@lang('messages.products')</span>
                                </a>
                            </li>
                            @endcan
                            @can('tienda_virtual_administracion_promociones')
                            <li class="{{ ($path[0] === 'shop' && $path[1] === 'administration' && $path[2] === 'promotions')?'active':'' }}">
                                <a href="{{ route('onlineshop_administration_promotions') }}" title="@lang('messages.promotions')" data-filter-tags="@lang('messages.promotions')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.promotions')">@lang('messages.promotions')</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                    @can('tienda_virtual_atencion')
                    <li class="{{ ($path[0] === 'shop' && $path[1] === 'attention')?'active open':'' }}">
                        <a href="#" title="@lang('messages.attention')" data-filter-tags="@lang('messages.attention')">
                            <i class="fal fa-cogs"></i>
                            <span class="nav-link-text" data-i18n="nav.@lang('messages.attention')"> @lang('messages.attention')</span>
                        </a>
                        <ul>
                            @can('tienda_virtual_atencion_mensajes')
                            <li class="{{ ($path[0] === 'shop' && $path[1] === 'attention' && ($path[2] === 'customer_messages' || $path[2] = 'sent_messages' || $path[2] = 'trash_messages') ) ? 'active' : '' }}">
                                <a href="{{ route('onlineshop_attention_customer_messages') }}" title="@lang('messages.customer_messages')" data-filter-tags="@lang('messages.customer_messages')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.customer_messages')">@lang('messages.customer_messages')</span>
                                </a>
                            </li>
                            @endcan
                            @can('tienda_virtual_atencion_pedidos')
                            <li class="{{ ($path[0] === 'shop' && $path[1] === 'attention' && $path[2] === 'orders')?'active':'' }}">
                                <a href="{{ route('onlineshop_administration_configurations') }}" title="@lang('messages.sho_orders')" data-filter-tags="@lang('messages.sho_orders')">
                                    <span class="nav-link-text" data-i18n="nav.@lang('messages.sho_orders')">@lang('messages.sho_orders')</span>
                                </a>
                            </li>
                            @endcan
                        </ul>
                    @endcan
                @endcan
            </ul>
        <div class="filter-message js-filter-message bg-success-600"></div>
    </nav>
    <!-- END PRIMARY NAVIGATION -->
    <!-- NAV FOOTER -->
    <div class="nav-footer shadow-top">
        <a href="#" onclick="return false;" data-action="toggle" data-class="nav-function-minify" class="hidden-md-down">
            <i class="ni ni-chevron-right"></i>
            <i class="ni ni-chevron-right"></i>
        </a>
        <ul class="list-table m-auto nav-footer-buttons">
            <li>
                <a href="{{ route('chat_index') }}" data-toggle="tooltip" data-placement="top" title="@lang('messages.internal_chat')">
                    <i class="fal fa-comments"></i>
                </a>
            </li>
            <!--li>
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Support Chat">
                    <i class="fal fa-life-ring"></i>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Make a call">
                    <i class="fal fa-phone"></i>
                </a>
            </li-->
        </ul>
    </div> <!-- END NAV FOOTER -->
</aside>
