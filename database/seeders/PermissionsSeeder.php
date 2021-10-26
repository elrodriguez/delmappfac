<?php

namespace Database\Seeders;

use App\Models\Master\Person;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Team;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions_array = [];
        $permissions_teacher = [];
        $permissions_student = [];

        array_push($permissions_array,Permission::create(['name' => 'configuracion']));
        array_push($permissions_array,Permission::create(['name' => 'maestros']));
        array_push($permissions_array,Permission::create(['name' => 'roles']));
        array_push($permissions_array,Permission::create(['name' => 'nuevo rol']));
        array_push($permissions_array,Permission::create(['name' => 'editar rol']));
        array_push($permissions_array,Permission::create(['name' => 'eliminar rol']));
        array_push($permissions_array,Permission::create(['name' => 'permisos']));
        array_push($permissions_array,Permission::create(['name' => 'nuevo permiso']));
        array_push($permissions_array,Permission::create(['name' => 'usuarios']));
        array_push($permissions_array,Permission::create(['name' => 'nuevo usuario']));
        array_push($permissions_array,Permission::create(['name' => 'editar usuario']));
        array_push($permissions_array,Permission::create(['name' => 'eliminar usuario']));
        array_push($permissions_array,Permission::create(['name' => 'asignar rol']));
        array_push($permissions_array,Permission::create(['name' => 'Eliminar cuenta de usuario']));
        array_push($permissions_array,Permission::create(['name' => 'crear Equipo de trabajo']));
        array_push($permissions_array,Permission::create(['name' => 'actividades_usuario_log']));
        array_push($permissions_array,Permission::create(['name' => 'establecimientos']));
        array_push($permissions_array,Permission::create(['name' => 'editar establecimiento']));
        array_push($permissions_array,Permission::create(['name' => 'nuevo establecimiento']));
        array_push($permissions_array,Permission::create(['name' => 'eliminar establecimiento']));
        array_push($permissions_array,Permission::create(['name' => 'maestros_establecimiento_series']));
        array_push($permissions_array,Permission::create(['name' => 'clientes']));
        array_push($permissions_array,Permission::create(['name' => 'clientes nuevo']));
        array_push($permissions_array,Permission::create(['name' => 'clientes editar']));
        array_push($permissions_array,Permission::create(['name' => 'configuracion_maestros_cuentas_bancarias']));
        array_push($permissions_array,Permission::create(['name' => 'configuracion_maestros_cuentas_bancarias_nuevo']));
        array_push($permissions_array,Permission::create(['name' => 'configuracion_maestros_cuentas_bancarias_editar']));
        array_push($permissions_array,Permission::create(['name' => 'configuracion_maestros_cuentas_bancarias_eliminar']));

        // array_push($permissions_array,Permission::create(['name' => 'empresa']));
        // array_push($permissions_array,Permission::create(['name' => 'parametros']));
        // array_push($permissions_array,Permission::create(['name' => 'Mesas']));
        // array_push($permissions_array,Permission::create(['name' => 'Materiales']));
        // array_push($permissions_array,Permission::create(['name' => 'ingresos']));
        // array_push($permissions_array,Permission::create(['name' => 'ingreso nuevo']));
        // array_push($permissions_array,Permission::create(['name' => 'ingreso editar']));
        // array_push($permissions_array,Permission::create(['name' => 'ingreso eliminar']));

        // Permission::create(['name' => 'academic']);

        // array_push($permissions_array,Permission::create(['name' => 'academico_administracion']));
        // array_push($permissions_array,Permission::create(['name' => 'academico_cobros']));
        // array_push($permissions_array,Permission::create(['name' => 'academico_matriculas']));
        // array_push($permissions_array,Permission::create(['name' => 'alumnos']));
        // array_push($permissions_array,Permission::create(['name' => 'alumnos nuevo']));
        // array_push($permissions_array,Permission::create(['name' => 'alumnos editar']));
        // array_push($permissions_array,Permission::create(['name' => 'alumnos eliminar']));
        // array_push($permissions_array,Permission::create(['name' => 'importar_alumnos_excel']));
        // array_push($permissions_array,Permission::create(['name' => 'Postulante']));
        // array_push($permissions_array,Permission::create(['name' => 'Postulante nuevo']));
        // array_push($permissions_array,Permission::create(['name' => 'Postulante editar']));
        // array_push($permissions_array,Permission::create(['name' => 'Postulante eliminar']));
        // array_push($permissions_array,Permission::create(['name' => 'producion']));
        // array_push($permissions_array,Permission::create(['name' => 'ingreso envases']));
        // array_push($permissions_array,Permission::create(['name' => 'ingreso pesca']));
        // array_push($permissions_array,Permission::create(['name' => 'ingreso pesca nuevo']));
        // array_push($permissions_array,Permission::create(['name' => 'ingreso pesca eliminar']));
        // array_push($permissions_array,Permission::create(['name' => 'ingreso pesca sacos']));
        // array_push($permissions_array,Permission::create(['name' => 'producion nuevo']));
        // array_push($permissions_array,Permission::create(['name' => 'producion eliminar']));
        // array_push($permissions_array,Permission::create(['name' => 'Cursos']));
        // array_push($permissions_array,Permission::create(['name' => 'Cursos Nuevo']));
        // array_push($permissions_array,Permission::create(['name' => 'Cursos Editar']));
        // array_push($permissions_array,Permission::create(['name' => 'Cursos Eliminar']));
        // array_push($permissions_array,Permission::create(['name' => 'Docente']));
        // array_push($permissions_array,Permission::create(['name' => 'Docente Nuevo']));
        // array_push($permissions_array,Permission::create(['name' => 'Docente Editar']));
        // array_push($permissions_array,Permission::create(['name' => 'Docente Eliminar']));
        // array_push($permissions_array,Permission::create(['name' => 'Docente Asignar Cursos']));
        // array_push($permissions_array,Permission::create(['name' => 'apoderado']));
        // array_push($permissions_array,Permission::create(['name' => 'Curso año grado y seccion']));
        // array_push($permissions_array,Permission::create(['name' => 'servicios_academico']));
        // array_push($permissions_array,Permission::create(['name' => 'servicios_academico_nuevo']));
        // array_push($permissions_array,Permission::create(['name' => 'servicios_academico_editar']));
        // array_push($permissions_array,Permission::create(['name' => 'servicios_academico_eliminar']));
        // array_push($permissions_array,Permission::create(['name' => 'Paquete_compromisos_promociones']));
        // array_push($permissions_array,Permission::create(['name' => 'pcp_nuevo']));
        // array_push($permissions_array,Permission::create(['name' => 'pcp_editar']));
        // array_push($permissions_array,Permission::create(['name' => 'descuento_academico']));
        // array_push($permissions_array,Permission::create(['name' => 'descuento_academico_nuevo']));
        // array_push($permissions_array,Permission::create(['name' => 'descuento_academico_editar']));
        // array_push($permissions_array,Permission::create(['name' => 'descuento_academico_eliminar']));
        // array_push($permissions_array,Permission::create(['name' => 'pcp_eliminar']));
        // array_push($permissions_array,Permission::create(['name' => 'pcp_agregar_items']));
        // array_push($permissions_array,Permission::create(['name' => 'academico_nuevo_comprobante']));
        // array_push($permissions_array,Permission::create(['name' => 'academico_listado_comprobante']));
        // array_push($permissions_array,Permission::create(['name' => 'matricula_registrar']));
        // array_push($permissions_array,Permission::create(['name' => 'academico_asignaturas']));
        // array_push($permissions_array,Permission::create(['name' => 'Lista_matriculados']));
        // array_push($permissions_array,Permission::create(['name' => 'Lista_matriculados_cursos']));
        // array_push($permissions_array,Permission::create(['name' => 'listado_alumno_del_capacitacion_asistencia']));

        Permission::create(['name' => 'rrhh']);
        array_push($permissions_array,Permission::create(['name' => 'rrhh_administracion']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_administration_employees']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_administration_employees_create']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_administration_employees_editar']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_administration_employees_import_excel']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_pagos']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_pagos_adelantos']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_pagos_adelantos_nuevo']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_pagos_adelantos_editar']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_pagos_adelantos_eliminar']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_concepts']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_boletas']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_boletas_nuevo']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_boletas_anular']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_administration_concepts']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_administration_concepts_create']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_administration_concepts_edit']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_administration_concepts_delete']));
        array_push($permissions_array,Permission::create(['name' => 'rrhh_boletas_imprimir']));

        Permission::create(['name' => 'logistic']);
        array_push($permissions_array,Permission::create(['name' => 'catalogos']));
        array_push($permissions_array,Permission::create(['name' => 'productos']));
        array_push($permissions_array,Permission::create(['name' => 'productos nuevo']));
        array_push($permissions_array,Permission::create(['name' => 'productos_editar']));
        array_push($permissions_array,Permission::create(['name' => 'productos_eliminar']));
        array_push($permissions_array,Permission::create(['name' => 'marcas']));
        array_push($permissions_array,Permission::create(['name' => 'marcas_nuevo']));
        array_push($permissions_array,Permission::create(['name' => 'marcas_editar']));
        array_push($permissions_array,Permission::create(['name' => 'marcas_eliminar']));
        array_push($permissions_array,Permission::create(['name' => 'proveedores']));
        array_push($permissions_array,Permission::create(['name' => 'proveedores_nuevo']));
        array_push($permissions_array,Permission::create(['name' => 'proveedores_editar']));
        array_push($permissions_array,Permission::create(['name' => 'proveedores_eliminar']));
        array_push($permissions_array,Permission::create(['name' => 'logistic_catalogos_categorias']));
        array_push($permissions_array,Permission::create(['name' => 'logistic_catalogos_categorias_nuevo']));
        array_push($permissions_array,Permission::create(['name' => 'logistic_catalogos_categorias_editar']));
        array_push($permissions_array,Permission::create(['name' => 'logistic_catalogos_categorias_eliminar']));
        array_push($permissions_array,Permission::create(['name' => 'produccion']));
        array_push($permissions_array,Permission::create(['name' => 'Almacen']));
        array_push($permissions_array,Permission::create(['name' => 'ingreso compras']));
        array_push($permissions_array,Permission::create(['name' => 'ingreso compras nuevo']));
        array_push($permissions_array,Permission::create(['name' => 'proyectos']));
        array_push($permissions_array,Permission::create(['name' => 'proyectos_nuevo']));
        array_push($permissions_array,Permission::create(['name' => 'proyectos_listado']));
        array_push($permissions_array,Permission::create(['name' => 'proyectos_editar']));
        array_push($permissions_array,Permission::create(['name' => 'proyectos_eliminar']));
        array_push($permissions_array,Permission::create(['name' => 'projectos_etapas']));
        array_push($permissions_array,Permission::create(['name' => 'logistic_production']));
        array_push($permissions_array,Permission::create(['name' => 'projectos_materiales']));
        array_push($permissions_array,Permission::create(['name' => 'projectos_empleados']));
        array_push($permissions_array,Permission::create(['name' => 'proyectos_otros_gastos']));
        array_push($permissions_array,Permission::create(['name' => 'compras']));
        array_push($permissions_array,Permission::create(['name' => 'compras_nuevo']));
        array_push($permissions_array,Permission::create(['name' => 'compras_listar']));
        array_push($permissions_array,Permission::create(['name' => 'compras_editar']));
        array_push($permissions_array,Permission::create(['name' => 'proyectos_orden']));
        array_push($permissions_array,Permission::create(['name' => 'proyecto_orden_materiales']));
        array_push($permissions_array,Permission::create(['name' => 'Inventario']));
        array_push($permissions_array,Permission::create(['name' => 'inventario_ubicaciones']));
        array_push($permissions_array,Permission::create(['name' => 'inventario_ubicaciones_nuevo']));
        array_push($permissions_array,Permission::create(['name' => 'inventario_ubicaciones_editar']));
        array_push($permissions_array,Permission::create(['name' => 'inventario_ubicaciones_eliminar']));
        array_push($permissions_array,Permission::create(['name' => 'reporte_kardex']));
        array_push($permissions_array,Permission::create(['name' => 'reporte_inventario']));
        array_push($permissions_array,Permission::create(['name' => 'reporte_kardex_valorizado']));
        array_push($permissions_array,Permission::create(['name' => 'logistic_almacen_inventario_movimientos']));
        array_push($permissions_array,Permission::create(['name' => 'logistic_almacen_inventario_traslados']));
        array_push($permissions_array,Permission::create(['name' => 'logistic_almacen_inventario_traslados_nuevo']));

        Permission::create(['name' => 'market']);
        array_push($permissions_array,Permission::create(['name' => 'market_administration']));
        array_push($permissions_array,Permission::create(['name' => 'market_administration_caja_chica']));
        array_push($permissions_array,Permission::create(['name' => 'market_administration_caja_chica_cerrar']));
        array_push($permissions_array,Permission::create(['name' => 'ventas']));
        array_push($permissions_array,Permission::create(['name' => 'ventas_nuevo_comprobante']));
        array_push($permissions_array,Permission::create(['name' => 'ventas_lista_comprobantes']));
        array_push($permissions_array,Permission::create(['name' => 'market_ventas_documentos_nota']));
        array_push($permissions_array,Permission::create(['name' => 'market_reportes']));
        array_push($permissions_array,Permission::create(['name' => 'market_reportes_ventas_vendedor']));
        array_push($permissions_array,Permission::create(['name' => 'market_reportes_productos_mas_vendidos']));
        array_push($permissions_array,Permission::create(['name' => 'market_reportes_ventas_por_productos']));

        // Permission::create(['name' => 'soporte_tecnico']);
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_administracion']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_administracion_categorias']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_administracion_categorias_nuevo']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_administracion_categorias_editar']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_administracion_categorias_eliminar']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_administracion_grupos']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_administracion_grupos_nuevo']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_administracion_grupos_editar']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_administracion_grupos_eliminar']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_administracion_area_usuarios']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_administracion_area_usuarios_nuevo']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_administracion_area_usuarios_eliminar']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_helpdesk']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_helpdesk_ticket']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_helpdesk_ticket_nuevo']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_helpdesk_ticket_atendidos']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_helpdesk_ticket_registrados']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_helpdesk_ticket_atender']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_helpdesk_ticket_ver']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_helpdesk_ticket_applicant']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_helpdesk_ticket_applicant_nuevo']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_helpdesk_ticket_applicant_seguir']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_helpdesk_ticket_applicant_eliminar']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_reportes']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_reportes_incidencias']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_reportes_resumenes_estados']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_reportes_ruta_ticket']));
        // array_push($permissions_array,Permission::create(['name' => 'soporte_tecnico_reportes_ticket_por_usuario']));
        
        Permission::create(['name' => 'tienda_virtual']);
        array_push($permissions_array,Permission::create(['name' => 'tienda_virtual_administracion']));
        array_push($permissions_array,Permission::create(['name' => 'tienda_virtual_administracion_configuraciones']));
        array_push($permissions_array,Permission::create(['name' => 'tienda_virtual_administracion_promociones']));
        array_push($permissions_array,Permission::create(['name' => 'tienda_virtual_administracion_promociones_create']));
        array_push($permissions_array,Permission::create(['name' => 'tienda_virtual_administracion_promociones_edit']));
        array_push($permissions_array,Permission::create(['name' => 'tienda_virtual_administracion_promociones_items']));
        array_push($permissions_array,Permission::create(['name' => 'tienda_virtual_administracion_promociones_delete']));
        array_push($permissions_array,Permission::create(['name' => 'tienda_virtual_administracion_productos']));
        array_push($permissions_array,Permission::create(['name' => 'tienda_virtual_atencion']));
        array_push($permissions_array,Permission::create(['name' => 'tienda_virtual_atencion_mensajes']));
        array_push($permissions_array,Permission::create(['name' => 'tienda_virtual_atencion_pedidos']));
        array_push($permissions_array,Permission::create(['name' => 'tienda_virtual_atencion_mensajes_enviados']));
        array_push($permissions_array,Permission::create(['name' => 'tienda_virtual_atencion_mensajes_papelera']));
        
        $permissions_normal = Permission::create(['name' => 'mis Equipos de trabajo']);

        array_push($permissions_student,Permission::create(['name' => 'mis_cursos']));
        array_push($permissions_student,Permission::create(['name' => 'mis_cursos_temas']));

        array_push($permissions_teacher,Permission::create(['name' => 'Listar_cursos_docente']));
        array_push($permissions_teacher,Permission::create(['name' => 'temas_del_curso']));
        array_push($permissions_teacher,Permission::create(['name' => 'listado_alumno_del_curso']));

        array_push($permissions_array,$permissions_normal);
        array_push($permissions_array,$permissions_teacher);
        array_push($permissions_array,$permissions_student);

        $roleSuperAdmin = Role::create(['name' => 'SuperAdmin']);
        $roleAdmin = Role::create(['name' => 'Administrador']);
        $roleTeacher = Role::create(['name' => 'Docente']);
        $roleStudent = Role::create(['name' => 'Alumno']);
        //$roleUser = Role::create(['name' => 'Public']);
        //$roleSeller= Role::create(['name' => 'Vendedor']);
        //$roleCliente= Role::create(['name' => 'Cliente']);

        $roleSuperAdmin->givePermissionTo('configuracion');
        $roleSuperAdmin->givePermissionTo('academic');
        $roleSuperAdmin->givePermissionTo('rrhh');
        // $roleSuperAdmin->givePermissionTo('logistic');
        // $roleSuperAdmin->givePermissionTo('market');
        // $roleSuperAdmin->givePermissionTo('soporte_tecnico');

        $roleSuperAdmin->syncPermissions($permissions_array);
        $roleAdmin->syncPermissions($permissions_array);
        $roleTeacher->givePermissionTo('academic');
        $roleTeacher->syncPermissions($permissions_teacher);
        $roleStudent->givePermissionTo('academic');
        $roleStudent->syncPermissions($permissions_student);
        //$roleSeller->givePermissionTo('market');

        //$roleUser->givePermissionTo($permissions_normal);

        $person = Person::create([
            'type' => 'customers',
            'identity_document_type_id' => '0',
            'number' => '12345678',
            'name' => 'Demo',
            'trade_name' => 'Demo Admin',
            'country_id' => 'PE',
            'department_id' => '02',
            'province_id' => '0218',
            'district_id' => '021801',
            'address' => 'Chimbote',
            'email' => 'demo@gmail.com',
            'last_paternal' => 'Admin',
            'last_maternal' => 'User',
            'sex' => 'm',
            'marital_state' => 'soltero',
            'birth_date' => '2000-08-06'
        ]);

        $person_public = Person::create([
            'type' => 'customers',
            'identity_document_type_id' => '0',
            'number' => '00000001',
            'name' => 'Generico',
            'trade_name' => 'GENERICO',
            'country_id' => 'PE',
            'department_id' => '02',
            'province_id' => '0218',
            'district_id' => '021801',
            'address' => 'Chimbote',
            'email' => 'generico@gmail.com',
            'last_paternal' => 'Cliente',
            'last_maternal' => 'Publico',
            'sex' => 'm',
            'marital_state' => 'soltero',
            'birth_date' => '2000-08-06'
        ]);

        $userAdmin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'person_id' => $person->id,
            'establishment_id' => 1
        ]);

        $userAdmin->assignRole('SuperAdmin');

        $userNormal = User::create([
            'name' => 'generico',
            'email' => 'generico@gmail.com',
            'password' => Hash::make('12345678'),
            'person_id' => $person_public->id,
            'establishment_id' => 1
        ]);

        // $userNormal->assignRole('Public');

        $userAdmin->ownedTeams()->save(Team::forceCreate([
            'user_id' => $userAdmin->id,
            'name' => explode(' ', $userAdmin->name, 2)[0]."'s Equipo",
            'personal_team' => true,
        ]));

        $userNormal->ownedTeams()->save(Team::forceCreate([
            'user_id' => $userNormal->id,
            'name' => explode(' ', $userNormal->name, 2)[0]."'s Equipo",
            'personal_team' => true,
        ]));
    }
}
