<?php

namespace App\Services\BO;

use Illuminate\Support\Facades\Auth;

class InventarioMovimientoBO
{
  /**
   * Método para armar insert para agregar un movimiento de inventario
   * @param array $datosRequest
   */
  public static function armarInsertMovimiento($datosRequest)
  {
    $insert = [];
    $insert['inventario_movimiento_id'] = $datosRequest['inventarioMovimientoId'];
    $insert['producto_id'] = $datosRequest['productoId'];
    $insert['venta_id'] = $datosRequest['ventaId'] ?? null;
    $insert['cantidad'] = $datosRequest['cantidad'];
    $insert['descripcion'] = $datosRequest['descripcion'];
    $insert['tipo'] = $datosRequest['tipo'];
    $insert['negocio_id'] = Auth::guard('sanctum')->user()->negocio_id;

    return $insert;
  }

}
