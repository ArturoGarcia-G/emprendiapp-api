<?php

namespace App\Models;

use App\Traits\DatosAuditoria;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
  use DatosAuditoria;

  protected $table = 'clientes';
  protected $primaryKey = 'cliente_id';
  protected $keyType = 'string';
  public $incrementing = false;
  public $timestamps = false;

  // Campos asignables
  protected $fillableCreate = [
    'cliente_id',
    'folio_global',
    'folio_local',
    'telefono',
    'nombre',
    'status',
    'registro_fecha',
    'registro_autor_id',
    'negocio_id',
  ];

  protected $fillableUpdate = [
    'telefono',
    'nombre',
    'status',
    'actualizacion_fecha',
    'actualizacion_autor_id',
  ];

  protected $fillable = [
    'cliente_id',
    'folio_global',
    'folio_local',
    'telefono',
    'nombre',
    'status',
    'registro_fecha',
    'registro_autor_id',
    'actualizacion_fecha',
    'actualizacion_autor_id',
    'negocio_id',
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
