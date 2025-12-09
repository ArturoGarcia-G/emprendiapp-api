<?php

namespace App\Services\BO;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioBO
{
  /**
   * Método para armar insert para agregar un usuario
   * @param array $datosRequest
   */
  public static function armarInsertUsuario($datosRequest)
  {
    $folio = 123; //TODO: Actualizar folio
    $insert['folio_global'] = $folio;
    $insert['folio_local'] = $folio;
    $insert['usuario_id'] = $datosRequest['usuarioId'] ?? null;
    $insert['nombre_completo'] = $datosRequest['nombreCompleto'];
    $insert['usuario'] = $datosRequest['usuario'];
    $insert['password'] = Hash::make($datosRequest['password']);
    $insert['negocio_id'] = Auth::guard('sanctum')->user()->negocio_id;

    return $insert;
  }
}