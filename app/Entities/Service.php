<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','dias_ejecucion','estado'];

    protected $appends = ['url_ver','url_editar','url_estado'];

    /*
     * GETTERS
     */
    public function getUrlVerAttribute()
    {
        return route('service.show', $this->id);
    }

    public function getUrlEditarAttribute()
    {
        return route('service.edit', $this->id);
    }

    public function getUrlEstadoAttribute()
    {
        return route('service.estado', $this->id);
    }

    /*
     * SCOPES
     */
    public function scopeOrder($query, $order)
    {
        switch ($order){
            case '':
                $query->orderBy('titulo', 'asc');
                break;

            case 'tituloAsc':
                $query->orderBy('titulo', 'asc');
                break;

            case 'tituloDesc':
                $query->orderBy('titulo', 'desc');
                break;

            case 'diasAsc':
                $query->orderBy('dias_ejecucion', 'asc');
                break;

            case 'diasDesc':
                $query->orderBy('dias_ejecucion', 'desc');
                break;
        }
    }
}