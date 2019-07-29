{{-- TimePicker --}}
{!! HTML::style('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') !!}

<div class="modal-header">
    <h4 class="modal-title">Editar acción</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            @include('flash::message')

            <div id="tarea-nueva" class="portlet-body">

                <div class="col-md-6 text-left">
                    <h4>Expediente: <strong>{{ $row->expedientes->expediente }}</strong></h4>
                </div>

                <div class="col-md-6 text-left">
                    <h4>Tarea: <strong>{{ $row->concepto->titulo }}</strong></h4>
                </div>

                <div class="col-md-12">
                    <div class="form-content"></div>
                </div>

                {!! Form::model($prin, ['route' => ['tareas.acciones.update', $row->id, $prin->id], 'method' => 'PUT', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off']) !!}

                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('fecha', 'Fecha', ['class' => 'control-label']) !!}
                                    <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                                        {!! Form::text('fecha', $prin->fecha_accion, ['class' => 'form-control']) !!}
                                        <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('desde', 'Desde', ['class' => 'control-label']) !!}
                                    <div class="input-group">
                                        {!! Form::text('desde', null, ['class' => 'form-control timepicker timepicker-24']) !!}
                                        <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-clock-o"></i></button></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('hasta', 'Hasta', ['class' => 'control-label']) !!}
                                    <div class="input-group">
                                        {!! Form::text('hasta', null, ['class' => 'form-control timepicker timepicker-24']) !!}
                                        <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-clock-o"></i></button></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('descripcion', 'Descripción', ['class' => 'control-label']) !!}
                                    {!! Form::textarea('descripcion', null, ['class' => 'form-control', 'rows' => '3']) !!}
                                </div>
                            </div>
                        </div>

                    </div>

                    @include('partials.progressbar')

                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
    <a id="formCreateSubmit" class="btn blue"><i class='fa fa-check'></i> Guardar</a>
</div>

{{-- Date Picker --}}
{!! HTML::script('assets/global/plugins/moment.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') !!}

{{-- Components --}}
{!! HTML::script('assets/pages/scripts/components-date-time-pickers.js') !!}

{{-- GUARDAR TAREA --}}
<script>
    $("#formCreateSubmit").on("click", function(e){
        e.preventDefault();

        var form = $("#formCreate");
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function (result) {
                console.log(result);
                var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se actualizó satisfactoriamente.</div>';
                $(".form-content").html(successHtml);

                $("#accion-select-"+ result.id).remove();

                var html = '<tr id="accion-select-'+ result.id +'">' +
                                '<td>'+ result.fecha_accion +'</td>' +
                                '<td>'+ result.desde +'</td>' +
                                '<td>'+ result.hasta +'</td>' +
                                '<td>'+ result.horas +'</td>' +
                                '<td>'+ result.descripcion +'</td>' +
                                '<td class="text-center">' +
                                    '<div class="btn-group">' +
                                        '<button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Movimientos' +
                                            '<i class="fa fa-angle-down"></i>' +
                                        '</button>' +
                                        '<ul class="dropdown-menu pull-right" role="menu">' +
                                            '<li><a href="'+ result.url_lista_gastos +'" data-target="#ajax" data-toggle="modal">Gastos</a></li>' +
                                            '<li><a href="'+ result.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></li>' +
                                            '<li><a href="#" data-url="'+ result.url_eliminar +'" data-title="'+ result.descripcion +'" data-accion="'+ result.id +'" class="btn-delete">Eliminar</a></li>' +
                                        '</ul>' +
                                    '</div>' +
                                '</td>' +
                           '</tr>';

                $("#accion-lista-{{ $row->id }} tbody").prepend(html);

                borrarAccion();
            },
            beforeSend: function () { $('.progress').show(); },
            complete: function () { $('.progress').hide(); },
            error: function (result){
                if(result.status === 422){
                    var errors = result.responseJSON;
                    var errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                    $.each( errors, function( key, value ) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></div>';
                    $('.form-content').html(errorsHtml);
                }else{
                    errorsHtml = '<div class="alert alert-danger"><button class="close" data-close="alert"></button><ul>';
                    errorsHtml += '<li>Se ha producido un error. Intentelo de nuevo.</li>';
                    errorsHtml += '</ul></div>';
                    $('.form-content').html(errorsHtml);
                }
            }
        });

    });
</script>