<?php

use App\Models\Master\Establishment;
use App\Models\Warehouse\Warehouse;

Route::middleware(['middleware' => 'role_or_permission:compras_nuevo'])->get('shopping/new', function () {
    return view('logistics.warehouse.shopping_created');
})->name('logistics_warehouse_shopping_created');
Route::middleware(['middleware' => 'role_or_permission:compras_listar'])->get('shopping', function () {
    return view('logistics.warehouse.shopping');
})->name('logistics_warehouse_shopping');
Route::get('shopping/list', [\App\Http\Controllers\Logistics\Warehouse\ShoppingController::class, 'list'
])->name('shopping_list');
Route::middleware(['middleware' => 'role_or_permission:compras_editar'])->get('shopping/edit/{id}', function ($id) {
    return view('logistics.warehouse.shopping_edit')->with('id',$id);
})->name('logistics_warehouse_shopping_edit');
Route::middleware(['middleware' => 'role_or_permission:compras_eliminar'])->get('shopping/delete/{id}', [\App\Http\Controllers\Logistics\Warehouse\ShoppingController::class, 'destroy'
])->name('logistics_warehouse_shopping_delete');
Route::get('shopping/details/{id}', [\App\Http\Controllers\Logistics\Warehouse\ShoppingController::class, 'detailsProductsPurchase'])->name('logistics_warehouse_shopping_details');

Route::middleware(['middleware' => 'role_or_permission:proyectos_orden'])->get('project_orders', function () {
    return view('logistics.warehouse.project_orders');
})->name('logistics_warehouse_proyectos_orden');
Route::get('projects/list', [\App\Http\Controllers\Logistics\Warehouse\ProjectOrdersController::class, 'list'
])->name('logistics_warehouse_projects_list');
Route::middleware(['middleware' => 'role_or_permission:proyecto_orden_materiales'])->get('projects_orders/materials/{id}', function ($id) {
    return view('logistics.warehouse.project_order_materials')->with('id',$id);
})->name('logistics_production_projects_order_material');
Route::middleware(['middleware' => 'role_or_permission:inventario_ubicaciones'])->get('inventory/locations', function () {
    return view('logistics.warehouse.inventory_locations');
})->name('logistics_warehouse_inventory_locations');
Route::get('inventory/locations/list',[\App\Http\Controllers\Logistics\Warehouse\WarehouseController::class, 'list'])->name('logistics_warehouse_inventory_locations_list');
Route::middleware(['middleware' => 'role_or_permission:inventario_ubicaciones_nuevo'])->get('inventory/locations/create', function () {
    return view('logistics.warehouse.inventory_locations_create');
})->name('logistics_warehouse_inventory_locations_create');
Route::middleware(['middleware' => 'role_or_permission:inventario_ubicaciones_nuevo'])->get('inventory/locations/edit/{id}', function ($id) {
    return view('logistics.warehouse.inventory_locations_edit')->with('id',$id);
})->name('logistics_warehouse_inventory_locations_edit');
Route::middleware(['middleware' => 'role_or_permission:inventario_ubicaciones_eliminar'])->get('inventory/locations/destroy/{id}', [\App\Http\Controllers\Logistics\Warehouse\WarehouseController::class, 'destroy'])->name('logistics_warehouse_inventory_locations_destroy');

Route::middleware(['middleware' => 'role_or_permission:reporte_kardex'])->get('inventory/report_kardex', function () {
    $warehouses = Warehouse::all();
    return view('logistics.warehouse.report_kardex')->with('warehouses',$warehouses);
})->name('logistics_warehouse_report_kardex');

Route::post('items/search', [\App\Http\Controllers\Logistics\Warehouse\ItemsController::class, 'searchItem'])->name('logistics_warehouse_items_search_autocomplete');
Route::post('inventory/report/inventory_kardex',[\App\Http\Controllers\Logistics\Warehouse\InventoryKardexController::class, 'inventoryKardexItemsSearch'])->name('logistics_warehouse_inventory_kardex_report');
Route::middleware(['middleware' => 'role_or_permission:reporte_inventario'])->get('inventory/report_inventory', function () {
    $warehouses = Warehouse::all();
    return view('logistics.warehouse.report_inventory')->with('warehouses',$warehouses);
})->name('logistics_warehouse_report_inventory');
Route::post('inventory/report/inventory',[\App\Http\Controllers\Logistics\Warehouse\InventoryController::class, 'inventoryItemWarehouse'])->name('logistics_warehouse_inventory_inventory_report');

Route::middleware(['middleware' => 'role_or_permission:reporte_kardex_valorizado'])->get('inventory/reporte_kardex_valued', function () {
    $establishments = Establishment::all();
    return view('logistics.warehouse.reporte_kardex_valued')->with('establishments',$establishments);
})->name('logistics_warehouse_reporte_kardex_valued');

Route::post('inventory/report/inventory_kardex_valued',[\App\Http\Controllers\Logistics\Warehouse\ReportValuedKardexController::class, 'getData'])->name('logistics_warehouse_inventory_inventory_report_Valued');
Route::post('inventory/report/inventory_kardex_valued/excel',[\App\Http\Controllers\Logistics\Warehouse\ReportValuedKardexController::class, 'reportAssistance'])->name('logistics_warehouse_inventory_inventory_report_valued_excel');

Route::middleware(['middleware' => 'role_or_permission:logistic_almacen_inventario_movimientos'])->get('inventory/movements', function () {
    return view('logistics.warehouse.movements');
})->name('logistics_warehouse_inventory_movements');
Route::get('inventory/movements/list',[\App\Http\Controllers\Logistics\Warehouse\MovementsController::class, 'list'])->name('logistics_warehouse_inventory_movements_list');
Route::get('inventory/movements/products/search',[\App\Http\Controllers\Logistics\Warehouse\MovementsController::class, 'searchProducts'])->name('logistics_warehouse_inventory_movements_product_search');
Route::middleware(['middleware' => 'role_or_permission:logistic_almacen_inventario_traslados'])->get('inventory/transfers', function () {
    return view('logistics.warehouse.transfers');
})->name('logistics_warehouse_inventory_transfers');
Route::get('inventory/transfers/list',[\App\Http\Controllers\Logistics\Warehouse\TransferController::class, 'list'])->name('logistics_warehouse_inventory_transfers_list');
Route::middleware(['middleware' => 'role_or_permission:logistic_almacen_inventario_traslados_nuevo'])->get('inventory/transfers/create', function () {
    return view('logistics.warehouse.transfers_create');
})->name('logistics_warehouse_inventory_transfers_create');
