<?php

namespace App\Repositories;

use App\Models\Usuario;
use App\Repositories\RH\UsuarioRH;

class UsuarioRepo
{

  /**
   * Repo para obtener usuarios
   * @param array  $filtros
   * @param array $order
   * @param string $columnas
   * @return $usuarios
   */
  public static function listarUsuarios($filtros = [], $order = [], $columnas = [])
  {
    $query = Usuario::query();

    UsuarioRH::aplicarFiltros($query, $filtros);

    if (!empty($columnas)) {
      $query->select($columnas);
    }

    if (!empty($order)) {
      foreach ($order as $columna => $direccion) {
        $query->orderBy($columna, $direccion);
      }
    }

    return $query->get();
  }

  /**
   * Método para agregar un usuario
   * @param array $datosRequest
   */
  public static function agregarUsuario(array $datosRequest)
  {
    $usuario = new Usuario();
    $usuario->fill($datosRequest);
    $usuario->save();

    return $usuario;
  }

  /**
   * Método para obtener un usuario
   * @param string $usuarioId
   * @param array $relaciones
   */
  public static function obtenerUsuario($usuarioId, $relaciones)
  {
    return Usuario::with($relaciones)->find($usuarioId);
  }

  /**
   * Método para agregar un usuario
   * @param string $usuarioId
   * @param array $datosRequest
   */
  public static function editarUsuario(string $usuarioId, array $datosRequest)
  {
    $usuario = Usuario::findOrFail($usuarioId);
    $usuario->fill($datosRequest);
    $usuario->save();

    return $usuario;
  }

  public static function eliminarUsuario(string $usuarioId)
  {
    $usuario = Usuario::findOrFail($usuarioId);
    $usuario->status = 'eliminado';
    $usuario->save();

    return $usuario;
  }
}
