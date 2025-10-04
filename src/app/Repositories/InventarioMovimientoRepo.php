<?php

namespace App\Repositories;

use App\Models\InventarioMovimiento;
use App\Repositories\RH\InventarioMovimientoRH;

class InventarioMovimientoRepo
{

  /**
   * Repo para obtener movimientos de inventario
   * @param array  $filtros
   * @param array $order
   * @param string $columnas
   * @return $movimientos
   */
  public static function listarMovimientos($filtros = [], $order = [], $columnas = [])
  {
    $query = InventarioMovimiento::query();

    InventarioMovimientoRH::aplicarFiltros($query, $filtros);

    if (!empty($columnas)) {
      $query->select($columnas);
    }

    if (!empty($order)) {
      foreach ($order as $columna => $direccion) {
        $query->orderBy($columna, $direccion);
      }
    }

    return $query->get();
  }

  /**
   * Método para agregar un producto
   * @param array $datosRequest
   */
  public static function agregarMovimiento(array $datosRequest)
  {
    $producto = new InventarioMovimiento();
    $producto->fillCreate($datosRequest);
    $producto->save();

    return $producto;
  }
}
