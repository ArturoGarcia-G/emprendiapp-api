<?php

namespace App\Services;

use App\Constantes\ProductoConsts;
use App\Exceptions\ValidacionException;
use App\Models\Producto;
use Exception;
use App\Repositories\ProductoRepo;
use App\Services\BO\ProductoBO;

class ProductoService
{
  /**
   * Método para obtener los productos
   * @param array $filtros
   * @param array $order
   * @param string $columnas
   * @throws Exception $e
   */
  public static function listarProductos($filtros = [], $order = [], $columnas = '')
  {
    return ProductoRepo::listarProductos($filtros, $order, $columnas);
  }

  /**
   * Método para obtener un producto
   * @param string $productoId
   * @param array $relaciones
   */
  public static function obtenerProducto($productoId, $relaciones = []): Producto
  {
    return ProductoRepo::obtenerProducto($productoId, $relaciones);
  }

  /**
   * Service que agrega un nuevo producto
   * @param array $datosRequest
   */
  public static function agregarProducto($datosRequest)
  {
    $datos = ProductoBO::armarInsertProducto($datosRequest);
    return ProductoRepo::agregarProducto($datos);
  }

  /**
   * Service que edita un producto
   * @param string $productoId
   * @param array $datosRequest
   */
  public static function editarProducto($productoId, $datosRequest)
  {
    return ProductoRepo::editarProducto($productoId, $datosRequest);
  }

  /**
   * Service que elimina un producto
   * @param string $productoId
   * @param array $datosRequest
   */
  public static function eliminarProducto($productoId)
  {
    $producto = self::obtenerProducto($productoId);
    if ($producto->status != ProductoConsts::STATUS_ACTIVO) {
      throw new ValidacionException('El producto ya se encuentra eliminado');
    }
    return ProductoRepo::eliminarProducto($productoId);
  }
}
