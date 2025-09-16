<?php

namespace App\Repositories;

use App\Constantes\ProductoConsts;
use App\Models\Producto;
use App\Repositories\RH\ProductoRH;

class ProductoRepo
{

  /**
   * Repo para obtener productos
   * @param array  $filtros
   * @param array $order
   * @param string $columnas
   * @return $productos
   */
  public static function listarProductos($filtros = [], $order = [], $columnas = [])
  {
    $query = Producto::query();

    ProductoRH::aplicarFiltros($query, $filtros);

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
  public static function agregarProducto(array $datosRequest)
  {
    $producto = new Producto();
    $producto->fillCreate($datosRequest);
    $producto->save();

    return $producto;
  }

  /**
   * Método para obtener un producto
   * @param string $productoId
   * @param array $relaciones
   */
  public static function obtenerProducto($productoId, $relaciones)
  {
    return Producto::with($relaciones)->find($productoId);
  }

  /**
   * Método para agregar un producto
   * @param string $productoId
   * @param array $datosRequest
   */
  public static function editarProducto(string $productoId, array $datosRequest)
  {
    $producto = Producto::findOrFail($productoId);
    $producto->fill($datosRequest);
    $producto->save();

    return $producto;
  }

  public static function eliminarProducto(string $productoId)
  {
    $producto = Producto::findOrFail($productoId);
    $producto->status = ProductoConsts::STATUS_ELIMINADO;
    $producto->save();

    return $producto;
  }
}
