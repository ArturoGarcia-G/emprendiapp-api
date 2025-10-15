<?php

namespace App\Http\Controllers;

use App\Constantes\CodigoRes;
use App\Exceptions\ExceptionHandler;
use App\Exceptions\ValidacionException;
use App\Services\ClienteService;
use App\Utilerias\ApiResponse;
use Throwable;

class ClienteController extends BaseController
{

  /**
   * Metodo que retorna listado de clientes
   * @return response
   */
  public function listarClientes()
  {
    try {
      $clientes = ClienteService::listarClientes(
        $this->filtros,
        $this->orden,
        $this->columnas,
      );

      return $this->exitoResponse('Listado de clientes obtenido correctamente.', $clientes);
    } catch (Throwable $e) {
      $mensajeError = ExceptionHandler::manejarException($e, 'Ocurrio un error al listar los clientes');
      return response(ApiResponse::build(CodigoRes::ERROR, $mensajeError));
    }
  }

  /**
   * Metodo que retorna un cliente
   * @return response
   */
  public function obtenerCliente($clienteId)
  {
    try {
      $cliente = ClienteService::obtenerCliente(
        $clienteId
      );

      return $this->exitoResponse('Cliente obtenido correctamente.', $cliente);
    } catch (Throwable $e) {
      $mensajeError = ExceptionHandler::manejarException($e, 'Ocurrio un error al obtener cliente');
      return response(ApiResponse::build(CodigoRes::ERROR, $mensajeError));
    }
  }

  /**
   * Metodo para agregar cliente
   * @return response
   */
  public function agregarCliente()
  {
    try {
      $this->validarRequest($this->datosRequest, [
        'nombre' => 'required',
        'telefono' => 'nullable',
      ]);

      ClienteService::agregarCliente($this->datosRequest);

      return $this->exitoResponse('Cliente agregado correctamente.');
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Ocurrio un error al agregar el cliente.');
    }
  }

  /**
   * Metodo para editar cliente
   * @return response
   */
  public function editarCliente($clienteId)
  {
    try {
      $this->validarRequest($this->datosRequest, [
        'nombre' => 'required',
        'telefono' => 'nullable',
      ]);

      ClienteService::editarCliente($clienteId, $this->datosRequest);

      return $this->exitoResponse('Cliente editado correctamente.');
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Ocurrio un error al editar el cliente.');
    }
  }

  /**
   * Metodo para eliminar cliente
   * @return response
   */
  public function eliminarCliente($clienteId = null)
  {
    try {
      if ($clienteId == null) {
        throw new ValidacionException('El parametro clienteId es necesario.');
      }

      ClienteService::eliminarCliente($clienteId);

      return $this->exitoResponse('Cliente eliminado correctamente.');
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Ocurrio un error al eliminar el cliente.');
    }
  }
}
