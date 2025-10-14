<?php

namespace App\Services\BO;

use Illuminate\Support\Facades\Auth;

class ProductoBO
{
  /**
   * Método para armar insert para agregar un producto
   * @param array $datosRequest
   */
  public static function armarInsertProducto($datosRequest)
  {
    $insert = $datosRequest;
    $folio = 123; //TODO: Actualizar folio
    $insert['folio'] = $folio;
    $insert['producto_id'] = $datosRequest['productoId'];
    $insert['stock'] = $datosRequest['stockInicial'];
    $insert['negocio_id'] = Auth::guard('sanctum')->user()->negocio_id;

    return $insert;
  }

}
