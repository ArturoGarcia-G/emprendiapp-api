<?php

namespace App\Services;

use Exception;
use App\Repositories\UsuarioRepo;

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
  public static function obtenerUsuario($usuarioId, $relaciones = [])
  {
    return UsuarioRepo::obtenerUsuario($usuarioId, $relaciones);
  }

  /**
   * Service que agrega un nuevo usuario
   * @param array $datosRequest
   */
  public static function agregarUsuario($datosRequest)
  {
    return UsuarioRepo::agregarUsuario($datosRequest);
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
   * @param array $datosRequest
   */
  public static function eliminarUsuario($usuarioId)
  {
    return UsuarioRepo::eliminarUsuario($usuarioId);
  }
}
