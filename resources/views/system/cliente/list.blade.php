@extends('layouts.system')

@section('title')
    Clientes
@stop

@section('contenido_header')
{{-- Select2 --}}
{!! HTML::style('assets/global/plugins/select2/css/select2.min.css') !!}
{!! HTML::style('assets/global/plugins/select2/css/select2-bootstrap.min.css') !!}
@stop

@section('contenido_body')

    <div class="row">

        @include('flash::message')

        <div id="mensajeAjax" class="alert alert-dismissable"></div>

        <div class="col-md-12 col-sm-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light portlet-datatable " id="form_wizard_1">
                <div class="portlet-body">

                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a class="btn sbold green" href="{{ route('cliente.create') }}" data-target="#ajax" data-toggle="modal"> Agregar registro
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {!! Form::model(Request::all(), ['route' => 'cliente.index', 'method' => 'GET']) !!}

                    <table class="table table-striped table-bordered table-hover order-column">

                        @include('system.cliente.partials.search')

                        <tbody>
                        @foreach($rows as $item)
                            {{--*/
                            $row_id = $item->id;
                            $row_cliente = $item->cliente;
                            $row_dni = $item->dni;
                            $row_ruc = $item->ruc;
                            $row_email = $item->email;
                            $row_estado = $item->estado;
                            /*--}}
                            <tr class="odd gradeX" data-id="{{ $row_id }}" data-title="{{ $row_cliente }}">
                                <td>{{ $row_cliente }}</td>
                                <td>{{ $row_dni }}</td>
                                <td>{{ $row_ruc }}</td>
                                <td>{{ $row_email }}</td>
                                <td class="text-center">
                                    <a id="estado-{{ $row_id }}" href="#" data-method="put" class="btn-oferta">
                                        {!! $row_estado ? '<span class="label label-success">'.trans('system.estado.'.$row_estado).'</span>' : '<span class="label label-default">'.trans('system.estado.'.$row_estado).'</span>' !!}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Acciones
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{ route('cliente.edit', $row_id) }}" data-target="#ajax" data-toggle="modal">Editar</a></li>
                                            <li><a href="{{ route('cliente.contactos.index', $row_id) }}">Contacto</a></li>
                                            <li><a href="{{ route('cliente.documentos.index', $row_id) }}">Documentos</a></li>
                                            <li><a href="{{ route('cliente.user.get', $row_id) }}">Crear usuario</a></li>
                                            <li><a href="javascript:;">Historial</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! Form::close() !!}

                    <div class="row">

                        <div class="col-md-5 col-sm-12">
                            <div class="dataTables_info" id="table1_info" role="status" aria-live="polite">Total de registros: {{ $rows->total() }}</div>
                        </div>

                        <div class="col-md-7 col-sm-12">
                            <div class="pull-right dataTables_paginate paging_simple_numbers" id="table1_paginate">
                                {!! $rows->appends(Request::all())->render() !!}
                            </div>

                        </div>

                    </div>

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>

    </div>

{!! Form::open(['route' => ['cliente.destroy', ':REGISTER'], 'method' => 'DELETE', 'id' => 'FormDeleteRow']) !!}
{!! Form::close() !!}

<div class="modal-view-delete" id="delete" title="Eliminar registro">
    <p>¿Desea eliminar el registro?</p>
    <div id="deleteTitle"></div>
</div>

@stop

@section('contenido_footer')

{{-- Select2 --}}
{!! HTML::script('assets/global/plugins/select2/js/select2.full.min.js') !!}
{!! HTML::script('assets/global/plugins/select2/js/i18n/es.js') !!}

<script>

    $(document).on("ready", function () {

        $("#ajax").on("loaded.bs.modal", function() {
            var placeholder = "Seleccionar";

            $('.select2').select2({
                placeholder: placeholder
            });
        });

        $('.modal-view-delete, #mensajeAjax').hide();

        $(".btn-delete").on("click", function(e){
            e.preventDefault();
            var row = $(this).parents("tr");
            var id = row.data("id");
            var title = row.data("title");
            var form = $("#FormDeleteRow");
            var url = form.attr("action").replace(':REGISTER', id);
            var data = form.serialize();

            $("#delete #deleteTitle").text(title);

            $( "#delete" ).dialog({
                resizable: true,
                height: 250,
                modal: false,
                buttons: {
                    "Borrar registro": function() {
                        row.fadeOut();

                        $.post(url, data, function(result){
                            $("#mensajeAjax").show().removeClass('alert-danger').addClass('alert-success').text(result.message);
                        }).fail(function(){
                            $("#mensajeAjax").show().removeClass('alert-success').addClass('alert-danger').text("Se produjo un error al eliminar el registro");
                            row.show();
                        });

                        $(this).dialog("close");
                    },
                    Cancel: function() {
                        $(this).dialog("close");
                    }
                }
            });

        });

    });

</script>

@stop