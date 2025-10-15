<?php

namespace App\Services\BO;

use Illuminate\Support\Facades\Auth;

class ClienteBO
{
  /**
   * Método para armar insert para agregar un cliente
   * @param array $datosRequest
   */
  public static function armarInsertCliente($datosRequest)
  {
    $folio = 123; //TODO: Actualizar folio
    $insert['folio_global'] = $folio;
    $insert['folio_local'] = $folio;
    $insert['cliente_id'] = $datosRequest['clienteId'];
    $insert['telefono'] = $datosRequest['telefono'];
    $insert['nombre'] = $datosRequest['nombre'];
    $insert['negocio_id'] = Auth::guard('sanctum')->user()->negocio_id;

    return $insert;
  }
}
