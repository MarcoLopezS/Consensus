@extends('layouts.system')

@section('title')
    Áreas
@stop

@section('contenido_header')
@stop

@section('contenido_body')

    <div class="row">

        @include('flash::message')

        <div class="col-md-12 col-sm-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light portlet-datatable " id="form_wizard_1">

                @include('partials.message')

                @include('partials.progressbar')

                <div class="portlet-title">

                    <div class="caption">

                        @can('create')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a class="btn sbold green" href="{{ route('area.create') }}" data-target="#ajax" data-toggle="modal"> Agregar registro
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
                                <a class="btn green-haze btn-outline btn-circle" href="{{ route('area.excel', Request::all()) }}">
                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                    <span class="hidden-xs"> Exportar a Excel </span>
                                </a>
                            </div>
                        </div>
                        @endcan

                        <div class="btn-group btn-group-devided">
                            <div class="btn-group">
                                <a class="btn green btn-outline btn-circle" href="{{ route('area.index') }}">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    <span class="hidden-xs"> Activos </span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover order-column">
                        <thead>
                            <tr role="row" class="heading">
                                <th width="30%">Titulo</th>
                                <th width="30%">Email</th>
                                <th width="20%">Estado</th>
                                <th width="10%">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                        @foreach($rows as $item)
                            @php
                            $row_id = $item->id;
                            $row_titulo = $item->titulo;
                            $row_email = $item->email;
                            $row_estado = $item->estado;
                            @endphp
                            <tr class="odd gradeX" data-id="{{ $row_id }}" data-title="{{ $row_titulo }}">
                                <td>{{ $row_titulo }}</td>
                                <td>{{ $row_email }}</td>
                                <td class="text-center">
                                    @can('update')
                                        <a id="estado-{{ $row_id }}" href="#" class="btn-estado" data-id="{{ $row_id }}" data-title="{{ $row_titulo }}" data-url="{{ route('area.estado', $row_id) }}">
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
                                            <li><a class="menu-ver" href="{{ route('area.show', $row_id) }}" data-target="#ajax" data-toggle="modal">Ver</a></li>
                                            @can('update')
                                            <li><a class="menu-editar" href="{{ route('area.edit', $row_id) }}" data-target="#ajax" data-toggle="modal">Editar</a></li>
                                            @endcan
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

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
        </div>

    </div>

@stop

@section('contenido_footer')
{{-- BootBox --}}
{!! HTML::script('assets/global/plugins/bootbox/bootbox.min.js') !!}

{{-- Cambiar Estado --}}
{!! HTML::script(elixir('js/js-cambiar-estado.js')) !!}
@stop