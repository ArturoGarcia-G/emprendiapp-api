<?php

namespace App\Http\Controllers;

use App\Constantes\CodigoRes;
use App\Exceptions\ExceptionHandler;
use App\Services\InventarioMovimientoService;
use App\Utilerias\ApiResponse;
use Throwable;

class InventarioMovimientoController extends BaseController
{

  /**
   * Metodo que retorna listado de movimientos
   * @return response
   */
  public function listarMovimientos()
  {
    try {
      $esquemas = InventarioMovimientoService::listarMovimientos(
        $this->filtros,
        $this->orden,
        $this->columnas,
      );

      return $this->exitoResponse('Listado de movimientos obtenido correctamente.', $esquemas);
    } catch (Throwable $e) {
      $mensajeError = ExceptionHandler::manejarException($e, 'Ocurrio un error al listar los movimientos');
      return response(ApiResponse::build(CodigoRes::ERROR, $mensajeError));
    }
  }

  /**
   * Metodo para agregar movimiento
   * @return response
   */
  public function agregarMovimiento()
  {
    try {
      $this->validarRequest($this->datosRequest, [
        'inventarioMovimientoId' => 'required',
        'productoId' => 'required',
        'ventaId' => 'nullable',
        'cantidad' => 'required',
        'descripcion' => 'required',
        'tipo' => 'required',
      ]);

      InventarioMovimientoService::agregarMovimiento($this->datosRequest);

      return $this->exitoResponse('Movimiento agregado correctamente.');
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Ocurrio un error al agregar el movimiento.');
    }
  }
}
