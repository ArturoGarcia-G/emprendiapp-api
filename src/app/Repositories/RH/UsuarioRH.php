<?php

namespace App\Repositories\RH;

use Illuminate\Database\Eloquent\Builder;

class UsuarioRH
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

    if (!empty($filtros['id_negocio'])) {
      $query->where('id_negocio', $filtros['id_negocio']);
    }

    if (!empty($filtros['usuario_id'])) {
      $query->where('usuario_id', $filtros['usuario_id']);
    }

    return $query;
  }
}
