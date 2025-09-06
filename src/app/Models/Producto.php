<?php

namespace App\Models;

use App\Traits\DatosAuditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Producto extends Model
{
  use HasUuids, DatosAuditoria;

  protected $table = 'productos';
  protected $primaryKey = 'producto_id';
  protected $keyType = 'string';
  public $incrementing = false;
  public $timestamps = false;

  // Campos asignables
  protected $fillableCreate = [
    'folio',
    'sku',
    'nombre',
    'stock',
    'precio',
    'costo',
    'status',
    'registro_fecha',
    'registro_autor_id',
    'negocio_id',
  ];

  protected $fillableUpdate = [
    'sku',
    'nombre',
    'stock',
    'precio',
    'costo',
    'status',
    'actualizacion_fecha',
    'actualizacion_autor_id',
  ];

  protected $fillable = [
    'folio',
    'sku',
    'nombre',
    'stock',
    'precio',
    'costo',
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
