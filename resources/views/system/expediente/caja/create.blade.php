<div class="modal-header">
    <h4 class="modal-title">Nuevo flujo de caja</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            @include('flash::message')

            <div id="tarea-nueva" class="portlet-body">

                <div class="col-md-6">
                    <h4>Cliente: <strong>{{ $row->cliente->cliente }}</strong></h4>
                </div>
                <div class="col-md-6 text-left">
                    <h4>Expediente: <strong>{{ $row->expediente }}</strong></h4>
                </div>

                <div class="col-md-12">
                    <div class="form-content"></div>
                </div>

                {!! Form::open(['route' => ['expedientes.flujo-caja.store', $row->id], 'method' => 'POST', 'id' => 'formCreate', 'class' => 'horizontal-form', 'autocomplete' => 'off', 'files' => 'true']) !!}

                <div class="form-body">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('referencia', 'Referencia', ['class' => 'control-label']) !!}
                                    {!! Form::text('referencia', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('tipo', 'Tipo', ['class' => 'control-label']) !!}
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">{!! Form::radio('tipo', 'ingreso', null,  ['id' => 'tipo']) !!}Ingreso</label>
                                        <label class="mt-radio">{!! Form::radio('tipo', 'egreso', null,  ['id' => 'tipo']) !!}Egreso</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('fecha', 'Fecha', ['class' => 'control-label']) !!}
                                    <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                                        {!! Form::text('fecha', dateActual(), ['class' => 'form-control']) !!}
                                        <span class="input-group-btn"><button class="btn default" type="button"><i class="fa fa-calendar"></i></button></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('monto', 'Monto', ['class' => 'control-label']) !!}
                                    {!! Form::text('monto', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('moneda', 'Moneda', ['class' => 'control-label']) !!}
                                    {!! Form::select('moneda', [''=>''] + $moneda, null, ['class' => 'form-control select2', 'style' => 'width: 100%;']) !!}
                                </div>
                            </div>

                        </div>

                        <div class="col-md-8">

                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('file', 'Comprobante', ['class' => 'control-label']) !!}
                                    <div class="dropzone"></div>
                                </div>
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
    <a class="btn default" id="formCreateClose">Cerrar</a>
    <a id="formCreateSubmit" class="btn blue"><i class='fa fa-check'></i> Guardar</a>
</div>

{{-- Date Picker --}}
{!! HTML::script('assets/global/plugins/moment.min.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
{!! HTML::script('assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') !!}

{{-- Components --}}
{!! HTML::script('assets/pages/scripts/components-date-time-pickers.js') !!}

{{-- GUARDAR TAREA --}}
<script>
    var archivo = '';
    var carpeta = '';

    var myDropzone = new Dropzone(".dropzone", {
        dictDefaultMessage: 'Da clic para seleccionar el archivo del comprobante',
        dictMaxFilesExceeded: 'No se puede cargar más archivos',
        url: "{{ route('documentos.upload') }}",
        method: 'POST',
        headers: {'X-CSRF-Token': '{!! csrf_token() !!}'},
        maxFiles: 1,
        success: function (file, result) {
            archivo = result.archivo;
            carpeta = result.carpeta;
        }
    });

    $("#formCreateSubmit").on("click", function(e){
        e.preventDefault();

        var form = $("#formCreate");
        var url = form.attr('action');
        var data = form.serialize()+'&documento='+archivo+'&carpeta='+carpeta;

        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            processData: false,
            success: function (result) {
                var successHtml = '<div class="alert alert-success"><button class="close" data-close="alert"></button>El registro se agregó satisfactoriamente.</div>';
                $(".form-content").html(successHtml);
                $(".select2").val(null).trigger('change');
                form[0].reset();

                myDropzone.removeAllFiles();

                var html = '<tr id="caja-select-'+ result.id +'">' +
                                '<td>'+ result.fecha_caja +'</td>' +
                                '<td>'+ result.referencia +'</td>' +
                                '<td>'+ result.monto +'</td>' +
                                '<td>'+ result.moneda +'</td>' +
                                '<td>'+ result.tipo +'</td>' +
                                '<td><a href="'+ result.url_editar +'" data-target="#ajax" data-toggle="modal">Editar</a></td>' +
                           '</tr>';

                $("#caja-lista-{{ $row->id }} tbody").prepend(html);

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

{{-- BootBox --}}
{!! HTML::script('assets/global/plugins/bootbox/bootbox.min.js') !!}
{!! HTML::script(elixir('js/js-form-close.js')) !!}
<script>
    $("#formCreateClose").on("click", function (e) {
        e.preventDefault();

        var referencia = $("#referencia").val(), monto = $("#monto").val(), moneda = $("#moneda").val();

        formClose([referencia, monto, moneda, archivo, carpeta]);
    });
</script>