<div class="modal-header">
    <h4 class="modal-title">Vista previa de registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <div class="portlet light form-fit">

                <div class="portlet-body form">

                    <div class="form-horizontal form-bordered form-label-stripped">

                        <div class="form-body">

                            <h3>Expediente: <strong>{{ $row->expediente }}</strong></h3>

                            <div class="form-group">
                                {!! Form::label('cliente', 'Cliente', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-9">
                                    <p class="form-control-static">{{ $row->cliente->cliente }}</p>
                                </div>
                            </div>

                            @cannot('cliente')
                            <div class="form-group">
                                {!! Form::label('moneda', 'Moneda', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-2">
                                    <p class="form-control-static">{{ $row->exp_moneda }}</p>
                                </div>

                                {!! Form::label('valor', 'Valor', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-2">
                                    <p class="form-control-static">{{ $row->valor }}</p>
                                </div>
                            </div>
                            @endcan

                            <div class="form-group">
                                {!! Form::label('abogado', 'Abogado', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->exp_abogado }}</p>
                                </div>

                                @cannot('cliente')
                                {!! Form::label('tarifa', 'Tárifa', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->exp_tarifa }}</p>
                                </div>
                                @endcan

                            </div>

                            @cannot('cliente')
                            <div class="form-group">
                                {!! Form::label('honorario_hora', 'Honorario por Hora', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-2">
                                    <p class="form-control-static">{{ $row->honorario_hora }}</p>
                                </div>

                                {!! Form::label('numero_horas', 'Número de Horas', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-2">
                                    <p class="form-control-static">{{ $row->numero_horas }}</p>
                                </div>

                                {!! Form::label('importe', 'Importe', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-2">
                                    <p class="form-control-static">{{ $row->importe }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('tope_monto', 'Tope Monto', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-2">
                                    <p class="form-control-static">{{ $row->tope_monto }}</p>
                                </div>

                                {!! Form::label('asistente', 'Asistente', ['class' => 'control-label col-md-3']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->exp_asistente }}</p>
                                </div>
                            </div>
                            @endcan

                            <div class="form-group">
                                {!! Form::label('servicio', 'Servicio', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-4">
                                    <p class="form-control-static">{{ $row->exp_servicio }}</p>
                                </div>

                                {!! Form::label('numero_dias', 'Número de Días', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->numero_dias }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('fecha_inicio', 'Fecha Inicio', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->exp_fecha_inicio }}</p>
                                </div>

                                {!! Form::label('fecha_termino', 'Fecha Término', ['class' => 'control-label col-md-3']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->exp_fecha_termino }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('descripcion', 'Descripción', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $row->descripcion }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('concepto', 'Concepto', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $row->concepto }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('materia', 'Materia', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-4">
                                    <p class="form-control-static">{{ $row->exp_materia }}</p>
                                </div>

                                {!! Form::label('entidad', 'Entidad', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-4">
                                    <p class="form-control-static">{{ $row->exp_entidad }}</p>
                                </div>
                            </div>

                            @cannot('cliente')
                            <div class="form-group">
                                {!! Form::label('area', 'Área', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-4">
                                    <p class="form-control-static">{{ $row->exp_area }}</p>
                                </div>

                                {!! Form::label('jefe_area', 'Jefe de Área', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-4">
                                    <p class="form-control-static">{{ $row->jefe_area }}</p>
                                </div>
                            </div>
                            @endcan

                            <div class="form-group">
                                {!! Form::label('instancia', 'Instancia', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-4">
                                    <p class="form-control-static">{{ $row->exp_instancia }}</p>
                                </div>

                                @cannot('cliente')
                                {!! Form::label('encargado', 'Encargado', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-4">
                                    <p class="form-control-static">{{ $row->encargado }}</p>
                                </div>
                                @endcan
                            </div>

                            <div class="form-group">
                                {!! Form::label('fecha_poder', 'Fecha Poder', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->exp_fecha_poder }}</p>
                                </div>

                                {!! Form::label('fecha_vencimiento', 'Fecha Vencimiento', ['class' => 'control-label col-md-3']) !!}
                                <div class="col-md-4">
                                    <p class="form-control-static">{{ $row->exp_fecha_vencimiento }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('bienes', 'Bienes', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-4">
                                    <p class="form-control-static">{{ $row->exp_bienes }}</p>
                                </div>

                                {!! Form::label('situacion', 'Situación Especial', ['class' => 'control-label col-md-3']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->exp_situacion_especial }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('estado', 'Estado', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-4">
                                    <p class="form-control-static">{{ $row->exp_estado }}</p>
                                </div>

                                {!! Form::label('exito', 'Éxito', ['class' => 'control-label col-md-3']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->exp_exito }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('vehicular_placa_antigua', 'Placa Antigua', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->vehicular_placa_antigua }}</p>
                                </div>

                                {!! Form::label('vehicular_placa_nueva', 'Placa Nueva', ['class' => 'control-label col-md-3']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->vehicular_placa_nueva }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('vehicular_siniestro', 'Nro Siniestro', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $row->vehicular_siniestro }}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('observacion', 'Observación', ['class' => 'control-label col-md-2']) !!}
                                <div class="col-md-10">
                                    <p class="form-control-static">{{ $row->observacion }}</p>
                                </div>
                            </div>

                        </div>
                        
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose" data-dismiss="modal">Cerrar</a>
</div>