<?php

namespace App\Services;

use App\Constantes\UsuarioConsts;
use App\Exceptions\ValidacionException;
use App\Models\Usuario;
use Exception;
use App\Repositories\UsuarioRepo;
use App\Services\BO\UsuarioBO;

class UsuarioService
{
  /**
   * Método para obtener los usuarios
   * @param array $filtros
   * @param array $order
   * @param string $columnas
   * @throws Exception $e
   */
  public static function listarUsuarios($filtros = [], $order = [], $columnas = '')
  {
    return UsuarioRepo::listarUsuarios($filtros, $order, $columnas);
  }

  /**
   * Método para obtener un usuario
   * @param string $usuarioId
   * @param array $relaciones
   */
  public static function obtenerUsuario($usuarioId, $relaciones = []): Usuario
  {
    return UsuarioRepo::obtenerUsuario($usuarioId, $relaciones);
  }

  /**
   * Service que agrega un nuevo usuario
   * @param array $datosRequest
   */
  public static function agregarUsuario($datosRequest)
  {
    $datos = UsuarioBO::armarInsertUsuario($datosRequest);
    return UsuarioRepo::agregarUsuario($datos);
  }

  /**
   * Service que edita un usuario
   * @param string $usuarioId
   * @param array $datosRequest
   */
  public static function editarUsuario($usuarioId, $datosRequest)
  {
    return UsuarioRepo::editarUsuario($usuarioId, $datosRequest);
  }

  /**
   * Service que elimina un usuario
   * @param string $usuarioId
   */
  public static function eliminarUsuario($usuarioId)
  {
    $usuario = self::obtenerUsuario($usuarioId);
    if ($usuario->status != UsuarioConsts::STATUS_ACTIVO) {
      throw new ValidacionException('El usuario ya se encuentra eliminado');
    }
    return UsuarioRepo::eliminarUsuario($usuarioId);
  }
}
