<?php

namespace App\Repositories;

use App\Models\Negocio;

class NegocioRepo
{

  /**
   * Método para obtener un negocio
   * @param string $negocioId
   * @param array $relaciones
   */
  public static function obtenerNegocio($negocioId)
  {
    return Negocio::find($negocioId);
  }

  /**
   * Método para obtener un negocio por PIN
   * @param string $pin
   * @return Negocio|null
   */
  public static function obtenerNegocioPorPin($pin)
  {
    return Negocio::where('pin', $pin)->first();
  }
}
