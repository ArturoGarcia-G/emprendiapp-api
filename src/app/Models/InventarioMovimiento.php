<?php

namespace App\Models;

use App\Traits\DatosAuditoria;
use Illuminate\Database\Eloquent\Model;

class InventarioMovimiento extends Model
{
  use DatosAuditoria;

  protected $table = 'inventario_movimientos';
  protected $primaryKey = 'inventario_movimiento_id';
  protected $keyType = 'string';
  public $incrementing = false;
  public $timestamps = false;

  // Campos asignables
  protected $fillableCreate = [
    'inventario_movimiento_id',
    'negocio_id',
    'producto_id',
    'venta_id',
    'cantidad',
    'descripcion',
    'tipo',
    'registro_fecha',
    'registro_autor_id',
  ];

  protected $fillableUpdate = [
    'producto_id',
    'venta_id',
    'cantidad',
    'descripcion',
    'tipo',
    'actualizacion_fecha',
    'actualizacion_autor_id',
  ];

  protected $fillable = [
    'inventario_movimiento_id',
    'negocio_id',
    'producto_id',
    'venta_id',
    'cantidad',
    'descripcion',
    'tipo',
    'registro_fecha',
    'registro_autor_id',
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
