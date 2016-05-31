<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h4 class="modal-title">Vista previa de registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <div class="horizontal-form">

                <div class="form-body">

                    <h3 class="form-section">Kardex: <strong>{{ $row->kardex }}</strong></h3>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('cliente', 'Cliente', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ $row->cliente->cliente }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('abogado', 'Abogado', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ $row->tariff->titulo }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('moneda', 'Moneda', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ $row->money->titulo }}</p>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('tarifa', 'Tárifa', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ $row->tariff->titulo }}</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('fecha_inicio', 'Fecha Inicio', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ soloFecha($row->fecha_inicio) }}</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('fecha_termino', 'Fecha Término', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ soloFecha($row->fecha_termino) }}</p>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('honorario_hora', 'Honorario por Hora', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ $row->honorario_hora }}</p>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('tope_monto', 'Tope Monto', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ $row->tope_monto }}</p>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('retainer_fm', 'Retainer FM', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ $row->retainer_fm }}</p>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('numero_horas', 'Número de Horas', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ $row->numero_horas }}</p>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('honorario_fijo', 'Honorario Fijo', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ $row->honorario_fijo }}</p>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('hora_adicional', 'Hora Adicional', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ $row->hora_adicional }}</p>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('servicio', 'Servicio', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ $row->service->titulo }}</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('numero_dias', 'Número de Días', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ $row->numero_dias }}</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('fecha_limite', 'Fecha Limite', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ soloFecha($row->fecha_limite) }}</p>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('descripcion', 'Descripción', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ $row->descripcion }}</p>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('concepto', 'Concepto', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ $row->concepto }}</p>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('observacion', 'Observación', ['class' => 'control-label']) !!}
                                <p class="form-control-static">{{ $row->observacion }}</p>
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
    <a class="btn blue" id="formCreateSubmit" href="javascript:;">Guardar</a>
</div>