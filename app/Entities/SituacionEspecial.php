<?php namespace Consensus\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class SituacionEspecial extends BaseEntity {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['titulo','estado'];

    protected $table = 'situacion_especial';

}