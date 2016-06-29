<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class FlujoCaja extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['expediente_id','fecha','referencia','money_id','monto','tipo'];
    protected $appends = ['fecha_caja','moneda','url_editar','url_editar_gasto','url_update_gasto'];

    protected $table = 'flujo_caja';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function flujo_cajatable()
    {
        return $this->morphTo();
    }

    public function money()
    {
        return $this->belongsTo(Money::class);
    }

    public function getFechaCajaAttribute()
    {
        return soloFecha($this->fecha);
    }

    public function getMonedaAttribute()
    {
        return $this->money->titulo;
    }

    public function getUrlEditarAttribute()
    {
        return route('expedientes.flujo-caja.edit', [$this->expediente_id, $this->id]);
    }

    public function getUrlEditarGastoAttribute()
    {
        return route('accion.gastos.edit', [$this->flujo_cajatable_id, $this->id]);
    }

    public function getUrlUpdateGastoAttribute()
    {
        return route('accion.gastos.update', [$this->flujo_cajatable_id, $this->id]);
    }

}