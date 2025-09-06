<?php

namespace App\Services;

use Exception;
use App\Repositories\NegocioRepo;

class NegocioService
{
  /**
   * Método para obtener un negocio
   * @param string $negocioId
   * @param array $relaciones
   */
  public static function obtenerNegocio($negocioId)
  {
    return NegocioRepo::obtenerNegocio($negocioId);
  }

  /**
   * Método para obtener un negocio por su pin
   * @param string $pin
   */
  public static function obtenerNegocioPorPin($pin)
  {
    return NegocioRepo::obtenerNegocioPorPin($pin);
  }
}
