<?php

namespace App\Traits;

use App\Constantes\CodigoRes;
use App\Exceptions\ExceptionHandler;
use App\Utilerias\ApiResponse;

trait ApiResponseTrait
{
  protected function exitoResponse($message, $data = null)
  {
    return response(ApiResponse::build(CodigoRes::EXITO, $message, $data));
  }

  protected function errorResponse($e, $message, $data = null)
  {
    $mensajeError = ExceptionHandler::manejarException($e, $message);
    return response(ApiResponse::build(CodigoRes::ERROR, $mensajeError, $data));
  }
}
