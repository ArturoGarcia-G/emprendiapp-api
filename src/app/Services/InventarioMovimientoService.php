<?php

namespace App\Services;

use Exception;
use App\Repositories\InventarioMovimientoRepo;
use App\Services\BO\InventarioMovimientoBO;

class InventarioMovimientoService
{
  /**
   * Método para obtener los productos
   * @param array $filtros
   * @param array $order
   * @param string $columnas
   * @throws Exception $e
   */
  public static function listarMovimientos($filtros = [], $order = [], $columnas = '')
  {
    return InventarioMovimientoRepo::listarMovimientos($filtros, $order, $columnas);
  }

  /**
   * Service que agrega un nuevo producto
   * @param array $datosRequest
   */
  public static function agregarMovimiento($datosRequest)
  {
    $datos = InventarioMovimientoBO::armarInsertMovimiento($datosRequest);
    return InventarioMovimientoRepo::agregarMovimiento($datos);
  }
}
