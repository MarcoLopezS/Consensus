<div class="modal-header">
    <h4 class="modal-title">Crear nuevo registro</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">

            <div class="form-content"></div>

            {!! Form::open(['route' => 'entity.store', 'method' => 'POST', 'id' => 'formCreate']) !!}

                <div class="form-body">

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('titulo', 'Titulo') !!}
                            {!! Form::text('titulo', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('area', 'Área') !!}
                            {!! Form::text('area', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('funcionario', 'Funcionario') !!}
                            {!! Form::text('funcionario', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('otro', 'Otro') !!}
                            {!! Form::text('otro', null, ['class' => 'form-control']) !!}
                        </div>
                    </div>

                </div>

                @include('partials.progressbar')

            {!! Form::close() !!}

        </div>
    </div>
</div>
<div class="modal-footer">
    <a class="btn default" id="formCreateClose">Cerrar</a>
    <a class="btn blue" id="formCreateSubmit" href="javascript:;">Guardar</a>
</div>

{{-- JS Create --}}
{!! HTML::script('js/js-create-edit.js') !!}
<script>
    $("#formCreateClose").on("click", function (e) {
        e.preventDefault();

        var titulo = $("#titulo").val(), area = $("#area").val(), funcionario = $("#funcionario").val(), otro = $("#otro").val();

        if(titulo != "" || area != "" || funcionario != "" || otro != ""){
            bootbox.dialog({
                title: 'Alerta',
                message: 'El fomulario tiene datos que ha ingresado. ¿Desea cerrar sin guardar?',
                closeButton: false,
                buttons: {
                    cancel: { label: 'No', className: 'default' },
                    success: { label: 'Si', className: 'blue', callback: function() { $('#ajax').modal('hide'); } }
                }
            });
        }else{ $('#ajax').modal('hide'); }

    });

</script>