<?php namespace Consensus\Entities;

use DateTime;
use Illuminate\Database\Eloquent\SoftDeletes;

class TareaAccion extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['tarea_id','desde','hasta','horas','descripcion'];
    protected $appends = ['url_editar','url_eliminar','url_lista_gastos','fecha_accion'];

    protected $table = 'tarea_acciones';

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'tarea_id');
    }

    public function flujo_caja()
    {
        return $this->hasMany(FlujoCaja::class);
    }

    public function getFechaAccionAttribute()
    {
        return soloFecha($this->fecha);
    }

    public function getDesdeAttribute($value)
    {
        return formatoHoraHM($value);
    }

    public function getHastaAttribute($value)
    {
        return formatoHoraHM($value);
    }

    public function getHorasAttribute($value)
    {
        return formatoHoraHM($value);
    }

    public function getUrlEditarAttribute()
    {
        return route('tareas.acciones.edit', [$this->tarea_id, $this->id]);
    }

    public function getUrlEliminarAttribute()
    {
        return route('tareas.acciones.destroy', [$this->tarea_id, $this->id]);
    }

    public function getUrlListaGastosAttribute()
    {
        return route('accion.gastos.index', [$this->id]);
    }

}