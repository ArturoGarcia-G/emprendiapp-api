<?php

namespace App\Services;

use App\Exceptions\ValidacionException;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use stdClass;

class AuthService
{
  /**
   * Método para iniciar sesion
   * @param array $datosRequest
   */
  public static function login($datosRequest)
  {
    $negocio = NegocioService::obtenerNegocioPorPin($datosRequest['pin']);
    if (empty($negocio)) {
      throw new ValidacionException('Credenciales o PIN incorrecto');
    }
    $usuario = Usuario::where('usuario', $datosRequest['usuario'])
      ->where('negocio_id', $negocio->negocio_id)
      ->first();

    if (!$usuario || !Hash::check($datosRequest['password'], $usuario->password)) {
      throw new ValidacionException('Credenciales o pin incorrectos');
    }

    $token = $usuario->createToken('app-token')->plainTextToken;

    $response = new stdClass();
    $response->access_token = $token;
    $response->token_type = 'Bearer';
    $response->usuario = $usuario;

    return $response;
  }
}
