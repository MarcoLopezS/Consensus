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

        @include('partials.message')

        <div class="col-md-12 col-sm-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light portlet-datatable " id="form_wizard_1">

                @include('partials.progressbar')

                <div class="portlet-title">

                    <div class="caption">

                        @can('admin')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a class="btn sbold green" href="{{ route('cliente.create') }}" data-target="#ajax" data-toggle="modal"> Agregar registro
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endcan

                    </div>

                    <div class="actions">
                        @can('exportar')
                        <div class="btn-group btn-group-devided">
                            <div class="btn-group">
                                <a class="btn green-haze btn-outline btn-circle" href="{{ route('cliente.excel', Request::all()) }}">
                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                    <span class="hidden-xs"> Exportar a Excel </span>
                                </a>
                            </div>
                        </div>
                        @endcan
                    </div>

                </div>

                <div class="portlet-body">

                    {!! Form::model(Request::all(), ['route' => 'cliente.index', 'method' => 'GET']) !!}

                    <table class="table table-striped table-bordered table-hover order-column">

                        @include('system.cliente.partials.search')

                        <tbody>
                        @foreach($rows as $item)
                            @php
                                $row_id = $item->id;
                                $row_cliente = $item->cliente;
                                $row_dni = $item->dni;
                                $row_ruc = $item->ruc;
                                $row_email = $item->email;
                                $row_expedientes = $item->cantidad_expedientes;
                                $row_estado = $item->estado;
                            @endphp
                            <tr id="cliente-{{ $row_id }}" class="odd gradeX" data-id="{{ $row_id }}" data-title="{{ $row_cliente }}">
                                <td>{{ $row_cliente }}</td>
                                <td>{{ $row_dni }}</td>
                                <td>{{ $row_ruc }}</td>
                                <td>{{ $row_email }}</td>
                                <td class="text-center">
                                    <a href="{{ route('cliente.expedientes', $row_id) }}" data-target="#ajax" data-toggle="modal">
                                        <strong>{{ $row_expedientes }}</strong>
                                    </a>
                                </td>
                                <td class="text-center">
                                    @can('update')
                                    <a id="estado-{{ $row_id }}" href="#" class="btn-estado" data-id="{{ $row_id }}" data-title="{{ $row_cliente }}" data-url="{{ route('cliente.estado', $row_id) }}">
                                        {!! $row_estado ? '<span class="label label-success">'.trans('system.estado.'.$row_estado).'</span>' : '<span class="label label-default">'.trans('system.estado.'.$row_estado).'</span>' !!}
                                    </a>
                                    @else
                                        {!! $row_estado ? '<span class="label label-success">'.trans('system.estado.'.$row_estado).'</span>' : '<span class="label label-default">'.trans('system.estado.'.$row_estado).'</span>' !!}
                                    @endcan
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-xs blue dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Movimientos
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a class="menu-ver" href="{{ route('cliente.show', $row_id) }}" data-target="#ajax" data-toggle="modal">Ver</a></li>
                                            @can('update')
                                            <li><a class="menu-editar" href="{{ route('cliente.edit', $row_id) }}" data-target="#ajax" data-toggle="modal">Editar</a></li>
                                            @endcan
                                            <li><a href="#" class="menu-contacto cliente-contacto" data-id="{{ $row_id }}" data-list="{{ route('cliente.contactos.index', $row_id) }}" data-create="{{ route('cliente.contactos.create', $row_id) }}">Contacto</a></li>
                                            <li><a href="#" class="menu-documentos cliente-documento" data-id="{{ $row_id }}" data-list="{{ route('cliente.documentos.index', $row_id) }}" data-create="{{ route('cliente.documentos.create', $row_id) }}">Documentos</a></li>
                                            @can('admin')
                                            <li><a href="{{ route('cliente.unir', $row_id) }}" class="menu-transferir" data-target="#ajax" data-toggle="modal">Unir Cliente</a></li>
                                            @endcan
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

@stop

@section('contenido_footer')
{{-- Select2 --}}
{!! HTML::script('assets/global/plugins/select2/js/select2.full.min.js') !!}
{!! HTML::script('assets/global/plugins/select2/js/i18n/es.js') !!}

{{-- BootBox --}}
{!! HTML::script('assets/global/plugins/bootbox/bootbox.min.js') !!}

{{-- Cambiar Estado --}}
{!! HTML::script(elixir('js/js-cambiar-estado.js')) !!}

{{-- Script Cliente --}}
{!! HTML::script(elixir('js/js-cliente.js')) !!}
<script>
    $(document).on("ready", function () {
        $("#ajax").on("loaded.bs.modal", function() {
            var placeholder = "Seleccionar";

            $('.select2').select2({
                placeholder: placeholder
            });


            var idSelect = $('.seleccionar-cliente').data('id');

            $(".seleccionar-cliente").select2({
                ajax: {
                    url: "/cliente/"+idSelect+"/unir/datos",
                    dataType: 'json',
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                },
                placeholder: 'Buscar y seleccionar cliente',
                minimumInputLength: 1,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            function formatRepo (repo) {
                if (repo.loading) {
                    return repo.cliente;
                }

                var $container = $(
                    "<div class='select2-result-repository clearfix'>" +
                        "<div class='select2-result-repository__meta'>" +
                            "<div class='select2-result-repository__title'></div>" +
                            "<div class='select2-result-repository__description select-dni'><strong>DNI:</strong> </div>" +
                            "<div class='select2-result-repository__description select-ruc'><strong>RUC:</strong> </div>" +
                            "<div class='select2-result-repository__description select-email'><strong>Email:</strong> </div>" +
                            "<div class='select2-result-repository__description select-telefono'><strong>Teléfono:</strong> </div>" +
                            "<div class='select2-result-repository__description select-direccion'><strong>Dirección:</strong> </div>" +
                            "<div class='select2-result-repository__statistics'>" +
                                "<div class='select2-result-repository__forks'><i class='fa fa-briefcase'></i> Tiene </div>" +
                            "</div>" +
                        "</div>" +
                    "</div>"
                );

                $container.find(".select2-result-repository__title").text(repo.cliente);
                $container.find(".select2-result-repository__description.select-dni").append(repo.dni);
                $container.find(".select2-result-repository__description.select-ruc").append(repo.ruc);
                $container.find(".select2-result-repository__description.select-email").append(repo.email);
                $container.find(".select2-result-repository__description.select-telefono").append(repo.telefono);
                $container.find(".select2-result-repository__description.select-direccion").append(repo.direccion);
                $container.find(".select2-result-repository__forks").append(repo.cantidad_expedientes + " Expedientes");

                return $container;
            }

            function formatRepoSelection (repo) {
                return repo.cliente || repo.text;
            }
        });
    });
</script>

@stop