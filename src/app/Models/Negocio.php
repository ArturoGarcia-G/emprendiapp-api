<?php

namespace App\Models;

use App\Traits\DatosAuditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Negocio extends Model
{
  use HasUuids, DatosAuditoria;

  protected $table = 'negocios';
  protected $primaryKey = 'negocio_id';
  protected $keyType = 'string';
  public $incrementing = false;
  public $timestamps = false; // Usamos timestamps manuales

  // Campos asignables
  protected $fillableCreate = [
    'nombre',
    'email',
    'telefono',
    'direccion',
    'status',
    'registro_fecha',
    'registro_autor_id',
    'pin',
  ];

  protected $fillableUpdate = [
    'nombre',
    'email',
    'telefono',
    'direccion',
    'status',
    'actualizacion_fecha',
    'actualizacion_autor_id',
  ];

  // Métodos para fillable según contexto
  public function fillCreate(array $attributes)
  {
    return $this->fill(array_intersect_key($attributes, array_flip($this->fillableCreate)));
  }

  public function fillUpdate(array $attributes)
  {
    return $this->fill(array_intersect_key($attributes, array_flip($this->fillableUpdate)));
  }
}
