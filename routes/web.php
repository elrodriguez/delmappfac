<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Models\Master\Parameter;
use App\Http\Controllers\Warehouse\PurchaseController;
use App\Http\Controllers\Warehouse\DocumentFishingController;
use App\Http\Controllers\Warehouse\ProducctionController;
use App\Http\Controllers\Master\CompanyController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route::get('/storage-link', function () {
//     if(file_exists(public_path('storage'))){
//         return 'public/storage existe';
//     }

//     app('files')->link(
//         storage_path('app/public'), public_path('storage')
//     );

//     return 'public/storage creado';
// });

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $parameter = Parameter::where('id_parameter','PRT0001GN')->first();
    return view('dashboard')->with('PRT0001GN',$parameter->value_default);
})->name('dashboard');

Route::group(['middleware' => ['auth:sanctum', 'verified','role:SuperAdmin|Administrador']], function () {

    Route::get('print/{model}/{external_id}/{format?}', [\App\Http\Controllers\Master\DocumentController::class, 'toPrintInvoice']);

    Route::get('download/{domain}/{type}/{filename}', [\App\Http\Controllers\Master\DocumentController::class, 'downloadExternal'])->name('download_sale_document');

    Route::middleware(['middleware' => 'role_or_permission:parametros'])->get('parameters', function () {
        return view('master.parameters');
    })->name('parameters');

    Route::middleware(['middleware' => 'role_or_permission:empresa'])->get('company', function () {
        return view('master.company');
    })->name('company');

    Route::post('company/uploadFile', [CompanyController::class, 'uploadFile'])->name('company_uploadFile');

    Route::group(['prefix' => 'configurations'], function() {
        Route::group(['prefix' => 'master'], function() {
            require __DIR__ . '/web/configurations/master.php';
        });
    });
});
Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::group(['prefix' => 'chat'], function() {
        Route::get('index', function () {
            return view('chat.chat_index');
        })->name('chat_index');
    });

    Route::group(['prefix' => 'support'], function() {
        Route::group(['prefix' => 'administration'], function() {
            require __DIR__ . '/web/support/administration.php';
        });
        Route::group(['prefix' => 'helpdesk'], function() {
            require __DIR__ . '/web/support/helpdesk.php';
        });
        Route::group(['prefix' => 'reports'], function() {
            require __DIR__ . '/web/support/reports.php';
        });
    });

});
Route::group(['middleware' => ['auth:sanctum', 'verified','role:SuperAdmin|Administrador']], function () {
    Route::group(['prefix' => 'warehouse'], function() {

        Route::middleware(['middleware' => 'role_or_permission:ingresos'])->get('income/packaging', function () {
            $parameter = Parameter::where('id_parameter','PRT0001GN')->first();
            return view('warehouse.income')->with('PRT0001GN',$parameter->value_default);
        })->name('income');

        Route::get('income/packaging/list', [PurchaseController::class, 'list'])->name('income_list');

        Route::middleware(['middleware' => 'role_or_permission:ingreso nuevo'])->get('income/packaging/create', function () {
            return view('warehouse.income_created');
        })->name('income_create');

        Route::post('income/packaging/search_supplier', [PurchaseController::class, 'searchSupplier'])->name('search_supplier');

        Route::middleware(['middleware' => 'role_or_permission:ingreso editar'])->get('income/packaging/edit/{id}', function ($id) {
            return view('warehouse.income_edit')->with('id',$id);
        })->name('income_edit');

        Route::middleware(['middleware' => 'role_or_permission:ingreso eliminar'])->get('income/delete/{id}', [PurchaseController::class, 'destroy'])->name('income_delete');

        Route::middleware(['middleware' => 'role_or_permission:Materiales'])->get('materials', function () {
            return view('warehouse.materials');
        })->name('materials');

        Route::middleware(['middleware' => 'role_or_permission:producion'])->get('production_today', function () {
            return view('warehouse.production');
        })->name('production_today_list');

        Route::get('production/list', [ProducctionController::class, 'list'])->name('production_list');
        Route::middleware(['middleware' => 'role_or_permission:producion eliminar'])->get('production/delete/{id}', [ProducctionController::class, 'destroy'])->name('production_delete');

        Route::middleware(['middleware' => 'role_or_permission:producion nuevo'])->get('production_today/create', function () {
            return view('warehouse.production_create');
        })->name('production_today_create');

        Route::post('income/packaging/search_customer', [DocumentFishingController::class, 'searchCustomer'])->name('search_customer');

        Route::middleware(['middleware' => 'role_or_permission:ingreso pesca'])->get('income/fishing', function () {
            return view('warehouse.fishing');
        })->name('warehouse_fishing');

        Route::middleware(['middleware' => 'role_or_permission:ingreso pesca nuevo'])->get('income/fishing/create', function () {
            return view('warehouse.fishing_create');
        })->name('warehouse_fishing_create');

        Route::get('income/fishing/list', [DocumentFishingController::class, 'list'])->name('income_fishing_list');

        Route::middleware(['middleware' => 'role_or_permission:ingreso pesca eliminar'])->get('income/fishing/delete/{id}', [DocumentFishingController::class, 'destroy'])->name('income_fishing_delete');

        Route::middleware(['middleware' => 'role_or_permission:ingreso pesca sacos'])->get('income/fishing/sacks/{id}', function ($id) {
            return view('warehouse.fishing_sacks_add')->with('id',$id);
        })->name('warehouse_fishing_sacks_add');


    });
});

Route::group(['middleware' => ['auth:sanctum', 'verified','role:SuperAdmin|Administrador|Soporte TI']], function () {
    Route::group(['prefix' => 'logistics'], function() {
        Route::group(['prefix' => 'catalogs'], function() {
            require __DIR__ . '/web/logistics/catalogs.php';
        });
        Route::group(['prefix' => 'warehouse'], function() {
            //Shopping shopping_created
            require __DIR__ . '/web/logistics/warehouse.php';
        });
        Route::group(['prefix' => 'production'], function() {
            //production
            require __DIR__ . '/web/logistics/production.php';
        });
    });
    Route::group(['prefix' => 'rrhh'], function() {
        Route::group(['prefix' => 'administration'], function() {
            require __DIR__ . '/web/RRHH/administration.php';
        });
        Route::group(['prefix' => 'payments'], function() {
            require __DIR__ . '/web/RRHH/payments.php';
        });
    });
});

Route::group(['middleware' => ['auth:sanctum', 'verified','role:SuperAdmin|Administrador|Docente|Alumno']], function () {
    Route::group(['prefix' => 'academic'], function() {
        Route::group(['prefix' => 'administration'], function() {
            require __DIR__ . '/web/academic/administration.php';
        });
        Route::group(['prefix' => 'charges'], function() {
            require __DIR__ . '/web/academic/charges.php';
        });
        Route::group(['prefix' => 'enrollment'], function() {
            require __DIR__ . '/web/academic/enrollment.php';
        });
        Route::group(['prefix' => 'subjects'], function() {
            require __DIR__ . '/web/academic/subjects.php';
        });
    });

});

Route::group(['middleware' => ['auth:sanctum', 'verified','role:SuperAdmin|Administrador|Vendedor']], function () {
    Route::group(['prefix' => 'market'], function() {
        Route::group(['prefix' => 'sales'], function() {
            require __DIR__ . '/web/market/sales.php';
        });
        Route::group(['prefix' => 'administration'], function() {
            require __DIR__ . '/web/market/administration.php';
        });
        Route::group(['prefix' => 'reports'], function() {
            require __DIR__ . '/web/market/reports.php';
        });
    });
});

Route::middleware(['auth:sanctum', 'verified'])->get('lang/{lang}', [LanguageController::class, 'swap'])->name('lang.swap');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::group(['prefix' => 'shop'], function() {
        require __DIR__ . '/web/onlineshop/administration.php';
    });
});

Route::group(['prefix' => 'store'], function() {
    require __DIR__ . '/web/onlineshop/client.php';
});