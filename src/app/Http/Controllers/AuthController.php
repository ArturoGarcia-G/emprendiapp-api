<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Throwable;

class AuthController extends BaseController
{

  /**
   * Metodo para iniciar sesion
   * @return response
   */
  public function login()
  {
    try {
      $this->validarRequest($this->datosRequest, [
        'usuario' => 'required|string',
        'password' => 'required|string',
        'pin' => 'required|string'
      ]);
      
      $response = AuthService::login($this->datosRequest);

      return $this->exitoResponse('Sesion iniciada correctamente.', $response);
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Ocurrio un error al iniciar sesion.');
    }
  }
}
