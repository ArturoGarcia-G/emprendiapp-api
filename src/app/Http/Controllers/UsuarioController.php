<?php

namespace App\Http\Controllers;

use App\Constantes\CodigoRes;
use App\Exceptions\ExceptionHandler;
use App\Exceptions\ValidacionException;
use App\Services\UsuarioService;
use App\Utilerias\ApiResponse;
use Throwable;

class UsuarioController extends BaseController
{

  /**
   * Metodo que retorna listado de usuarios
   * @return response
   */
  public function listarUsuarios()
  {
    try {
      $esquemas = UsuarioService::listarUsuarios(
        $this->filtros,
        $this->orden,
        $this->columnas,
      );

      return $this->exitoResponse('Listado de usuarios obtenido correctamente.', $esquemas);
    } catch (Throwable $e) {
      $mensajeError = ExceptionHandler::manejarException($e, 'Ocurrio un error al listar los usuarios');
      return response(ApiResponse::build(CodigoRes::ERROR, $mensajeError));
    }
  }

  /**
   * Metodo para agregar usuario
   * @return response
   */
  public function agregarUsuario()
  {
    try {
      $this->validarRequest($this->datosRequest, [
        'nombreCompleto' => 'required',
        'usuario' => 'required',
      ]);

      UsuarioService::agregarUsuario($this->datosRequest);

      return $this->exitoResponse('Usuario agregado correctamente.');
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Ocurrio un error al agregar el usuario.');
    }
  }

  /**
   * Metodo para editar usuario
   * @return response
   */
  public function editarUsuario()
  {
    try {
      $this->validarRequest($this->datosRequest, [
        'usuarioId' => 'required',
        'nombreCompleto' => 'required',
      ]);

      UsuarioService::editarUsuario($this->datosRequest['usuarioId'], $this->datosRequest);

      return $this->exitoResponse('Usuario editado correctamente.');
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Ocurrio un error al editar el usuario.');
    }
  }

  /**
   * Metodo para eliminar usuario
   * @return response
   */
  public function eliminarUsuario($usuarioId = null)
  {
    try {
      if ($usuarioId == null) {
        throw new ValidacionException('El parametro usuarioId es necesario.');
      }

      UsuarioService::eliminarUsuario($usuarioId);

      return $this->exitoResponse('Usuario eliminado correctamente.');
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Ocurrio un error al eliminar el usuario.');
    }
  }
}
