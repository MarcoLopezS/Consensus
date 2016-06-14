$(".col-hide").on("click", function () {
    var id = $(this).attr('id');
    $(this).prop("checked") ? $('.'+id).show() : $('.'+id).hide();
});

/* AJUSTES */
$("#ajustes-expediente").on("click", function() {
    $("#ajustes-expediente-panel").slideToggle();
});

$("#ajustes-expediente-cancelar").on("click", function() {
    $("#ajustes-expediente-panel").slideUp();
});

//MOSTRAR U OCULTAR COLUMNAS DE LA TABLA EXPEDIENTE
var ajustes = $("#expediente-ajustes-data").text();
var js = JSON.parse(ajustes);

getValues(js,'ch-expediente') == 1 ? $('.col-expediente').show() : $('.col-expediente').hide();
getValues(js,'ch-cliente') == 1 ? $('.col-cliente').show() : $('.col-cliente').hide();
getValues(js,'ch-moneda') == 1 ? $('.col-moneda').show() : $('.col-moneda').hide();
getValues(js,'ch-valor') == 1 ? $('.col-valor').show() : $('.col-valor').hide();
getValues(js,'ch-tarifa') == 1 ? $('.col-tarifa').show() : $('.col-tarifa').hide();
getValues(js,'ch-abogado') == 1 ? $('.col-abogado').show() : $('.col-abogado').hide();
getValues(js,'ch-asistente') == 1 ? $('.col-asistente').show() : $('.col-asistente').hide();
getValues(js,'ch-servicio') == 1 ? $('.col-servicio').show() : $('.col-servicio').hide();
getValues(js,'ch-fecha-inicio') == 1 ? $('.col-fecha-inicio').show() : $('.col-fecha-inicio').hide();
getValues(js,'ch-fecha-termino') == 1 ? $('.col-fecha-termino').show() : $('.col-fecha-termino').hide();
getValues(js,'ch-materia') == 1 ? $('.col-materia').show() : $('.col-materia').hide();
getValues(js,'ch-entidad') == 1 ? $('.col-entidad').show() : $('.col-entidad').hide();
getValues(js,'ch-instancia') == 1 ? $('.col-instancia').show() : $('.col-instancia').hide();
getValues(js,'ch-encargado') == 1 ? $('.col-encargado').show() : $('.col-encargado').hide();
getValues(js,'ch-fecha-poder') == 1 ? $('.col-fecha-poder').show() : $('.col-fecha-poder').hide();
getValues(js,'ch-fecha-vencimiento') == 1 ? $('.col-fecha-vencimiento').show() : $('.col-fecha-vencimiento').hide();
getValues(js,'ch-area') == 1 ? $('.col-area').show() : $('.col-area').hide();
getValues(js,'ch-jefe-area') == 1 ? $('.col-jefe-area').show() : $('.col-jefe-area').hide();
getValues(js,'ch-bienes') == 1 ? $('.col-bienes').show() : $('.col-bienes').hide();
getValues(js,'ch-situacion') == 1 ? $('.col-situacion').show() : $('.col-situacion').hide();
getValues(js,'ch-estado') == 1 ? $('.col-estado').show() : $('.col-estado').hide();
getValues(js,'ch-exito') == 1 ? $('.col-exito').show() : $('.col-exito').hide();


/* FILTRAR */
$("#filtrar-expediente").on("click", function() {
    $("#filtrar-expediente-panel").slideToggle();
});

$("#filtrar-expediente-cancelar").on("click", function() {
    $("#filtrar-expediente-panel").slideUp();
});

$(".select2-clear").on("click", function(){
    var id = $(this).data('id');
    $("." + id + " .select2").val(null).trigger('change');
});

$(".text-clear").on("click", function(){
    var id = $(this).data('id');
    $("." + id + " .form-control").val(null);
});


//MOSTRAR PROCESOS DE EXPEDIENTE
$(".expediente-procesos").on("click", function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var proceso = $(this).data('proceso');
    var create = $(this).data('proceso-create');

    $.ajax({
        url: proceso,
        type: 'GET',
        success: function(result){

            var html = '<tr id="tarea-'+id+'" class="bg-default" style="display:none;"><td style="padding:20px 15px;" colspan="23">' +
                '<div class="btn-group pull-left">' +
                '<h3 class="table-title">Procesos</h3>' +
                '</div>' +
                '<div class="btn-group pull-right table-botones">' +
                '<a class="btn sbold white tarea-cerrar" href="#" data-id="'+id+'"> Cerrar </a>' +
                '<a class="btn sbold blue-soft" href="'+create+'" data-target="#ajax" data-toggle="modal"> Agregar nuevo proceso <i class="fa fa-plus"></i></a>' +
                '</div>' +
                '<table id="tarea-lista-'+id+'" class="table table-striped table-bordered table-hover order-column">' +
                '<thead>' +
                '<tr role="row" class="heading">' +
                '<td>Solicitada</td>' +
                '<td>Vencimiento</td>' +
                '<td>Tarea</td>' +
                '<td>Asignado</td>' +
                '<td>Acciones</td>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
                '</table>' +
                '</td></tr>';

            $("#exp-" + id).after(html);
            $("#tarea-" + id).fadeIn();

            var tr;
            $.each(JSON.parse(result), function(idx, obj) {
                tr = $('<tr id="tarea-select-'+ obj.id +'">');
                tr.append('<td>'+ obj.fecha_solicitada +'</td>');
                tr.append('<td>'+ obj.fecha_vencimiento +'</td>');
                tr.append('<td>'+ obj.tarea +'</td>');
                tr.append('<td>'+ obj.asignado +'</td>');
                tr.append('<td><a href="'+ obj.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></td>');
                $("#tarea-lista-"+id+" tbody").prepend(tr);
            });

            $(".tarea-cerrar").on("click", function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $("#tarea-" + id).fadeOut();
            });
        },
        beforeSend: function () { $('.progress').show(); },
        complete: function () { $('.progress').hide(); },
        error: function() {

        }
    });

});


//MOSTRAR FLUJO DE CAJA DE EXPEDIENTE
$(".expediente-caja").on("click", function(e) {
    e.preventDefault();

    var id = $(this).data('id');
    var caja = $(this).data('caja');
    var create = $(this).data('caja-create');

    $.ajax({
        url: caja,
        type: 'GET',
        success: function(result){
            var html = '<tr id="caja-'+id+'" class="bg-default" style="display:none;"><td style="padding:20px 15px;" colspan="23">' +
                '<div class="btn-group pull-left">' +
                '<h3 class="table-title">Flujo de Caja</h3>' +
                '</div>' +
                '<div class="btn-group pull-right table-botones">' +
                '<a class="btn sbold white caja-cerrar" href="#" data-id="'+id+'"> Cerrar </a>' +
                '<a class="btn sbold blue-soft" href="'+create+'" data-target="#ajax" data-toggle="modal"> Agregar nuevo flujo de caja <i class="fa fa-plus"></i></a>' +
                '</div>' +
                '<table id="caja-lista-'+id+'" class="table table-striped table-bordered table-hover order-column">' +
                '<thead>' +
                '<tr role="row" class="heading">' +
                '<td>Fecha</td>' +
                '<td>Referencia</td>' +
                '<td>Monto</td>' +
                '<td>Moneda</td>' +
                '<td>Acciones</td>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
                '</table>' +
                '</td></tr>';

            $("#exp-" + id).after(html);
            $("#caja-" + id).fadeIn();

            var tr;
            $.each(JSON.parse(result), function(idx, obj) {
                tr = $('<tr id="caja-select-'+ obj.id +'">');
                tr.append('<td>'+ obj.fecha_caja +'</td>');
                tr.append('<td>'+ obj.referencia +'</td>');
                tr.append('<td>'+ obj.monto +'</td>');
                tr.append('<td>'+ obj.moneda +'</td>');
                tr.append('<td><a href="'+ obj.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></td>');
                $("#caja-lista-"+id+" tbody").prepend(tr);
            });

            $(".caja-cerrar").on("click", function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $("#caja-" + id).fadeOut();
            });
        },
        beforeSend: function () { $('.progress').show(); },
        complete: function () { $('.progress').hide(); },
        error: function() {

        }
    });

});