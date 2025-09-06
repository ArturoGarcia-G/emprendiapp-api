<?php

namespace App\Utilerias;

class SQLResponse
{

  /**
   * Obtenemos mensaje de respuesta de acuerdo al codigo de sql obtenido
   * @param $codigo
   * @return string
   */
  public static function obtenerMensaje(string $codigo)
  {
    $mensaje = '';
    switch ($codigo) {
      case '42703':
        $mensaje = 'Columna no encontrada';
        break;

      case '42P01':
        $mensaje = 'Tabla/alias sin definir';
        break;

      case '22012':
        $mensaje = 'División por cero';
        break;

      case '23502':
        $mensaje = 'Valor nulo en columna';
      break;

      default:
        $mensaje = 'Sin definir código db error';
        break;
    }
    return $mensaje;
  }
}
