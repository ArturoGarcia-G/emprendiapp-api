<?php

namespace App\Exceptions;

use Throwable;
use App\Utilerias\TextoUtils;
use ArithmeticError;
use DomainException;
use Illuminate\Database\QueryException;
use App\Exceptions\ValidacionException;
use PDOException;

class ExceptionHandler
{
  public static function manejarException(Throwable $e, $mensajeModulo)
  {
    $codigo = TextoUtils::generarNumeroAleatorio();
    $codigo = $mensajeModulo." [".$codigo."]";
    switch ($e) {
      case $e instanceof BusinessException:
        $codigo = TextoUtils::agregarLog($e, 'warning', $codigo);
        break;
      case $e instanceof ValidacionException:
        $codigo = TextoUtils::agregarLog($e, 'debug', $codigo);
        break;
      case $e instanceof QueryException:
      case $e instanceof PDOException:
        TextoUtils::agregarLog($e, 'error', $codigo);
        break;
      case $e instanceof ArithmeticError:
      case $e instanceof DomainException:
        TextoUtils::agregarLog($e, 'warning', $codigo);
          break;
      default:
        TextoUtils::agregarLog($e, 'error', $codigo);

    }
    return $codigo;
  }

}
