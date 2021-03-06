<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitialTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*===============================
        = CONFIGURACION =
        ===============================*/

        Schema::create('configuraciones', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('accion')->unique();
            $table->string('valor');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('notificaciones', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('notificable_id')->unsigned();
            $table->string('notificable_type');

            $table->integer('abogado_id');
            $table->date('fecha_vencimiento');
            $table->text('descripcion');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        /*===============================
        = USUARIOS =
        ===============================*/

        Schema::create('users', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('username', 25)->unique();
            $table->string('password', 60);
            $table->boolean('active');

            $table->boolean('admin')->nullable();
            $table->boolean('usuario')->nullable();
            $table->integer('cliente_id')->nullable()->unsigned();
            $table->integer('abogado_id')->nullable()->unsigned();
            $table->integer('asistente_id')->nullable()->unsigned();

            $table->string('code', 60)->nullable();
            $table->rememberToken();
            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('user_profiles', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('user_id')->unsigned();

            $table->string('nombre');
            $table->string('apellidos');
            $table->string('email')->unique();

            $table->string('imagen');
            $table->string('imagen_carpeta');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('user_roles', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('user_id')->unsigned();

            $table->boolean('create')->nullable();
            $table->boolean('update')->nullable();
            $table->boolean('delete')->nullable();
            $table->boolean('exporta')->nullable();
            $table->boolean('printer')->nullable();

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });


        /*===============================
        = HISTORIAL DE TODAS LAS TABLAS =
        ===============================*/

        Schema::create('histories', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('historyble_id')->unsigned();
            $table->string('historyble_type');

            $table->integer('user_id')->nullable()->default(NULL);

            $table->enum('type', ['create','update', 'restore', 'delete']);
            $table->enum('opcion', ['text', 'file']);
            $table->text('descripcion');

            $table->nullableTimestamps();
        });

        /*==============================
        =          DOCUMENTOS          =
        ==============================*/

        Schema::create('documentos', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('documentable_id')->unsigned();
            $table->string('documentable_type');

            $table->integer('user_id')->nullable()->default(NULL);

            $table->enum('type', ['create','update', 'restore', 'delete']);

            $table->string('documento')->nullable();
            $table->string('carpeta')->nullable();

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        /*==============================
        =         FLUJO DE CAJA        =
        ==============================*/

        Schema::create('flujo_caja', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('expediente_id')->nullable()->unsigned();
            $table->integer('tarea_accion_id')->nullable()->unsigned();

            $table->integer('user_id')->nullable()->default(NULL);

            $table->date('fecha');
            $table->string('referencia');
            $table->integer('money_id');
            $table->double('monto', 15, 2);
            $table->enum('tipo', ['ingreso','egreso']);
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        /*==============================
        =            CLIENTES          =
        ==============================*/

        Schema::create('clientes', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('cliente')->nullable();

            $table->string('dni', 8)->nullable();
            $table->string('ruc', 11)->nullable();
            $table->string('carnet_extranjeria', 12)->nullable();
            $table->string('pasaporte', 12)->nullable();
            $table->string('partida_nacimiento', 15)->nullable();
            $table->string('otros', 15)->nullable();

            $table->string('email')->nullable();

            $table->string('telefono', 25)->nullable();
            $table->string('fax', 20)->nullable();

            $table->text('direccion')->nullable();
            $table->integer('pais_id')->unsigned()->nullable();
            $table->integer('distrito_id')->unsigned()->nullable();

            $table->string('imagen');
            $table->string('imagen_carpeta');

            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('cliente_contactos', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('cliente_id')->unsigned();

            $table->string('contacto');
            $table->string('dni', 8);
            $table->string('ruc', 11);
            $table->string('carnet_extranjeria', 12);
            $table->string('pasaporte', 12);
            $table->string('partida_nacimiento', 15);
            $table->string('otros', 15);

            $table->string('email');
            $table->string('telefono', 25);
            $table->string('fax', 25);

            $table->text('direccion');
            $table->integer('pais_id')->unsigned()->nullable();
            $table->integer('distrito_id')->unsigned()->nullable();

            $table->boolean('estado');
            
            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('cliente_documentos', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('cliente_id')->unsigned();

            $table->string('titulo');
            $table->text('descripcion');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        /*==============================
        =      ABOGADOS Y TARIFAS      =
        ==============================*/

        Schema::create('abogados', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('nombre');

            $table->string('dni', 8);
            $table->string('ruc', 11);
            $table->string('carnet_extranjeria', 12);
            $table->string('pasaporte', 12);
            $table->string('partida_nacimiento', 15);
            $table->string('otros', 15);

            $table->string('email');

            $table->string('telefono', 25);
            $table->string('fax', 20);

            $table->text('direccion');
            $table->integer('pais_id')->unsigned();

            $table->string('imagen');
            $table->string('imagen_carpeta');

            $table->boolean('abogado')->nullable();
            $table->boolean('asistente')->nullable();

            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('tariffs', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->string('abrev', 5)->nullable();
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('tarifa_abogados', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('tariff_id');
            $table->integer('abogado_id');
            $table->integer('valor');
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        /*==============================
        =            MONEDA            =
        ==============================*/

        Schema::create('money', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('titulo')->nullable();
            $table->decimal('valor', 8, 5)->nullable();
            $table->string('simbolo');
            $table->string('abrev', 5);
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        /*==============================
        =          EXPEDIENTE          =
        ==============================*/

        Schema::create('expedientes', function(Blueprint $table)
        {
            $table->increments('id');

            $table->enum('expediente_opcion', ['auto', 'manual'])->default('auto');
            $table->integer('expediente_tipo_id')->nullable()->unsigned();
            $table->string('expediente')->nullable();

            $table->integer('cliente_id')->unsigned()->nullable();
            $table->integer('money_id')->unsigned();
            $table->double('valor', 20, 2)->nullable();

            $table->integer('tariff_id')->unsigned();
            $table->boolean('check_abogado')->nullable();
            $table->integer('abogado_id')->unsigned()->nullable();
            $table->boolean('check_asistente')->nullable();
            $table->integer('asistente_id')->unsigned()->nullable();

            $table->double('honorario_hora', 15, 2)->nullable()->default('0');
            $table->integer('numero_horas')->nullable()->default('0');
            $table->double('importe', 15, 2)->nullable()->default('0');
            $table->double('tope_monto', 15, 2)->nullable()->default('0');

            $table->double('retainer_fm', 10, 2)->nullable()->default('0');
            $table->integer('honorario_fijo')->nullable()->default('0');
            $table->integer('hora_adicional')->nullable()->default('0');

            $table->integer('service_id')->unsigned();
            $table->integer('numero_dias')->nullable()->default('0');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_termino')->nullable();

            $table->text('descripcion')->nullable();
            $table->text('concepto')->nullable();

            $table->integer('matter_id')->unsigned()->nullable();
            $table->integer('entity_id')->unsigned()->nullable();
            $table->integer('instance_id')->unsigned()->nullable();
            $table->string('encargado')->nullable()->nullable();

            $table->boolean('check_poder')->nullable();
            $table->date('fecha_poder')->nullable();
            $table->boolean('check_vencimiento')->nullable();
            $table->date('fecha_vencimiento')->nullable();

            $table->integer('area_id')->unsigned()->nullable();
            $table->string('jefe_area')->nullable();

            $table->integer('bienes_id')->unsigned()->nullable();
            $table->integer('situacion_especial_id')->unsigned()->nullable();
            $table->integer('state_id')->unsigned()->nullable();
            $table->boolean('exito_id')->unsigned()->nullable();

            $table->text('observacion')->nullable();

            $table->string('vehicular_placa_antigua')->nullable();
            $table->string('vehicular_placa_nueva')->nullable();
            $table->string('vehicular_siniestro')->nullable();

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('expediente_tipos', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->string('abrev', 5)->nullable();
            $table->integer('num');

            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('expediente_intervinientes', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('expediente_id');

            $table->string('nombre');
            $table->string('dni', 8);
            $table->string('telefono', 30);
            $table->string('celular', 30);
            $table->string('email', 50);

            $table->integer('intervener_id');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('expediente_documentos', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('expediente_id');

            $table->string('titulo');
            $table->text('descripcion');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        /*==============================
        =             TAREAS           =
        ==============================*/

        Schema::create('tareas', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('expediente_id')->unsigned();
            $table->integer('expediente_tipo_id')->unsigned();

            $table->integer('tarea_concepto_id');
            $table->text('descripcion');

            $table->date('fecha_solicitada');
            $table->date('fecha_vencimiento');

            $table->integer('titular_id')->unsigned();
            $table->integer('abogado_id')->unsigned();
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('tarea_notificaciones', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('tarea_id')->unsigned();
            $table->integer('abogado_id')->unsigned();
            $table->integer('dias');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('tarea_acciones', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('expediente_id')->unsigned();
            $table->integer('expediente_tipo_id')->unsigned();

            $table->integer('abogado_id')->unsigned();
            $table->integer('cliente_id')->unsigned();

            $table->integer('tarea_id')->unsigned();
            $table->date('fecha');
            $table->time('desde');
            $table->time('hasta');
            $table->time('horas');
            $table->text('descripcion');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('tarea_conceptos', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });



        /*==============================
        =                              =
        ==============================*/

        Schema::create('payment_methods', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('services', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->integer('dias_ejecucion');
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('instances', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('matters', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('entities', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->string('area');
            $table->string('funcionario');
            $table->string('otro');
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('areas', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->string('email');
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('ubicaciones', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('states', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('interveners', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('expense_types', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('paises', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('distritos', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('bienes', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('situacion_especial', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });

        Schema::create('exito', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });


        /*===============================
        = AJUSTES DEL SISTEMA =
        ===============================*/

        Schema::create('ajustes', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('model');
            $table->integer('user_id')->nullable();
            $table->text('contenido');

            $table->nullableTimestamps();
        });

        Schema::create('facturacion', function(Blueprint $table)
        {
            $table->increments('id');

            $table->integer('cliente_id')->unsigned();
            $table->integer('comprobante_tipo_id')->unsigned();
            $table->string('comprobante_numero');
            $table->date('fecha');
            $table->integer('money_id')->unsigned();
            $table->double('importe', 20, 2);
            $table->integer('expediente_id')->nullable();
            $table->text('descripcion');

            $table->nullableTimestamps();
            $table->softDeletes();
        });
        
        Schema::create('comprobante_tipos', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('titulo')->nullable();
            $table->boolean('estado');

            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('configuraciones');
        Schema::drop('notificaciones');

        Schema::drop('users');
        Schema::drop('user_profiles');
        Schema::drop('user_roles');
        Schema::drop('password_resets');
        Schema::drop('histories');
        Schema::drop('documentos');

        Schema::drop('expedientes');
        Schema::drop('expediente_tipos');
        Schema::drop('expediente_intervinientes');
        Schema::drop('expediente_documentos');

        Schema::drop('tareas');
        Schema::drop('tarea_notificaciones');
        Schema::drop('tarea_acciones');
        Schema::drop('tarea_conceptos');

        Schema::drop('flujo_caja');

        Schema::drop('cliente_documentos');
        Schema::drop('cliente_contactos');
        Schema::drop('clientes');

        Schema::drop('abogados');
        Schema::drop('tariffs');
        Schema::drop('tarifa_abogados');

        Schema::drop('money');
        Schema::drop('payment_methods');
        Schema::drop('services');
        Schema::drop('instances');
        Schema::drop('matters');
        Schema::drop('entities');
        Schema::drop('areas');
        Schema::drop('ubicaciones');
        Schema::drop('states');
        Schema::drop('interveners');
        Schema::drop('expense_types');
        Schema::drop('paises');
        Schema::drop('distritos');

        Schema::drop('bienes');
        Schema::drop('situacion_especial');
        Schema::drop('exito');

        Schema::drop('ajustes');

        Schema::drop('facturacion');
        Schema::drop('comprobante_tipos');
    }
}
