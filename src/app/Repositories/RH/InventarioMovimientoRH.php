<?php

namespace App\Repositories\RH;

use Illuminate\Database\Eloquent\Builder;

class InventarioMovimientoRH
{

  /**
   * Aplicar filtros dinamicos al listado
   */
  public static function aplicarFiltros(Builder &$query, array $filtros)
  {
    if (!empty($filtros['negocioId'])) {
      $query->where('negocio_id', $filtros['negocioId']);
    }

    if (!empty($filtros['productoId'])) {
      $query->where('producto_id', $filtros['productoId']);
    }

    return $query;
  }
}
