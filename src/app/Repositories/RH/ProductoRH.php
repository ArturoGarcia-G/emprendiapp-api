<?php

namespace App\Repositories\RH;

use Illuminate\Database\Eloquent\Builder;

class ProductoRH
{

  /**
   * Aplicar filtros dinamicos al listado
   */
  public static function aplicarFiltros(Builder &$query, array $filtros)
  {
    if (!empty($filtros['status'])) {
      $query->where('status', $filtros['status']);
    }

    if (!empty($filtros['fecha_inicio']) && !empty($filtros['fecha_fin'])) {
      $query->whereBetween('registro_fecha', [
        $filtros['fecha_inicio'],
        $filtros['fecha_fin']
      ]);
    }

    if (!empty($filtros['negocio_id'])) {
      $query->where('negocio_id', $filtros['negocio_id']);
    }

    if (!empty($filtros['usuario_id'])) {
      $query->where('usuario_id', $filtros['usuario_id']);
    }

    return $query;
  }
}
