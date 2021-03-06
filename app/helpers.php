<?php

use Carbon\Carbon;

//CONVERTIR HORAS A MINUTOS
function HorasAMinutos($hours)
{
    $minutes = 0;
    if (strpos($hours, ':') !== false)
    {
        list($hours, $minutes) = explode(':', $hours);
    }
    return $hours * 60 + $minutes;
}

//CONVERTIR MINUTOS A HORAS
function MinutosAHoras($minutes)
{
    $hours = (int)($minutes / 60);
    $minutes -= $hours * 60;
    return sprintf("%d:%02.0f", $hours, $minutes);
}

//RESTAR HORAS
function restarHoras($fecha, $desde, $hasta)
{
    $hora_desde = new DateTime($fecha.' '.$desde.':00');
    $hora_hasta = $hora_desde->diff(new DateTime($fecha.' '.$hasta.':00'));

    $dt = Carbon::createFromTime($hora_hasta->h, $hora_hasta->i, $hora_hasta->s);

    return $dt->toTimeString();
}


function sumarHoras($values) {

    $soloHoras = [];

    foreach($values as $valor) {
       array_push($soloHoras, $valor->horas.":00");
    }

    $total_horas = 0;
    foreach($soloHoras as $h) {
        $parts = explode(":", $h );
        $total_horas += $parts[2] + $parts[1]*60 + $parts[0]*3600;
    }
    $h = sprintf('%02d',floor($total_horas / 3600)); // Calculas horas
    $total_horas -= $h * 3600; // Restas al total
    $m = sprintf('%02d',floor($total_horas / 60)); // Calculas minutos
    $s = sprintf('%02d',$total_horas - ($m * 60)); // Calculas segundos restando minutos al total // Calculas segundos restando minutos al total

    return $h . ':' . $m;
}


//CONVERTIR FORMATO DE FECHA
function formatoFecha($date)
{
    if($date <> ""){
        $fecha = Carbon::createFromFormat('d/m/Y', $date);
        return $fecha->format('Y-m-d');
    }else{
        return "";
    }
}

//OBTENER DIAS
function fechaDias($vencimiento)
{
    $fecha_fin = Carbon::createFromFormat('Y-m-d', $vencimiento);
    $fecha_hoy = Carbon::now();
    $dias = $fecha_fin->diffInDays($fecha_hoy);
    return $dias;
}

//TIPO DE USUARIO
function tipo_usuario($usuario)
{
    if( $usuario->admin == 1 ){
        return $tipo = 'Administrador';
    }else if( $usuario->usuario == 1 ){
        return $tipo = 'Usuario';
    }else if( $usuario->cliente_id > 0 ){
        return $tipo = 'Cliente';
    }else if( $usuario->abogado_id > 0 ){
        return $tipo = 'Abogado';
    }
}

//FECHA
function fecha($fecha)
{
    return date_format(new DateTime($fecha), 'd/m/Y H:i');
}

//FORMATO SOLO HORA
function formatoHoraHM($value)
{
    return date_format(new DateTime($value), 'H:i');
}

//SOLO FECHA
function soloFecha($fecha)
{
    return date_format(new DateTime($fecha), 'd/m/Y');
}

/* FECHA ACTUAL */
function dateActual(){
    return date('d/m/Y');
}

//FUNCION PARA MARCAR ORDEN
function cssOrden($orden)
{
    switch ($orden)
    {
        case 'tituloAsc':
            return $order = 'tituloAsc';
            break;

        case 'tituloDesc':
            return $order = 'tituloDesc';
            break;

        case 'diasAsc':
            return $order = 'diasAsc';
            break;

        case 'diasDesc':
            return $order = 'diasDesc';
            break;

        case 'clienteAsc':
            return $order = 'clienteAsc';
            break;

        case 'clienteDesc':
            return $order = 'clienteDesc';
            break;

        case 'dniAsc':
            return $order = 'dniAsc';
            break;

        case 'dniDesc':
            return $order = 'dniDesc';
            break;

        case 'rucAsc':
            return $order = 'rucAsc';
            break;

        case 'rucDesc':
            return $order = 'rucDesc';
            break;

        case 'emailAsc':
            return $order = 'emailAsc';
            break;

        case 'emailDesc':
            return $order = 'emailDesc';
            break;

        case 'areaAsc':
            return $order = 'areaAsc';
            break;

        case 'areaDesc':
            return $order = 'areaDesc';
            break;

        case 'funcionarioAsc':
            return $order = 'funcionarioAsc';
            break;

        case 'funcionarioDesc':
            return $order = 'funcionarioDesc';
            break;

        case 'otroAsc':
            return $order = 'otroAsc';
            break;

        case 'otroDesc':
            return $order = 'otroDesc';
            break;
    }
}