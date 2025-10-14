<?php

namespace App\Http\Controllers;

use App\Constantes\CodigoRes;
use App\Exceptions\ExceptionHandler;
use App\Exceptions\ValidacionException;
use App\Services\ProductoService;
use App\Utilerias\ApiResponse;
use Throwable;

class ProductoController extends BaseController
{

  /**
   * Metodo que retorna listado de productos
   * @return response
   */
  public function listarProductos()
  {
    try {
      $productos = ProductoService::listarProductos(
        $this->filtros,
        $this->orden,
        $this->columnas,
      );

      return $this->exitoResponse('Listado de productos obtenido correctamente.', $productos);
    } catch (Throwable $e) {
      $mensajeError = ExceptionHandler::manejarException($e, 'Ocurrio un error al listar los productos');
      return response(ApiResponse::build(CodigoRes::ERROR, $mensajeError));
    }
  }

  /**
   * Metodo que retorna un producto
   * @return response
   */
  public function obtenerProducto($productoId)
  {
    try {
      $producto = ProductoService::obtenerProducto(
        $productoId
      );

      return $this->exitoResponse('Producto obtenido correctamente.', $producto);
    } catch (Throwable $e) {
      $mensajeError = ExceptionHandler::manejarException($e, 'Ocurrio un error al obtener producto');
      return response(ApiResponse::build(CodigoRes::ERROR, $mensajeError));
    }
  }

  /**
   * Metodo para agregar producto
   * @return response
   */
  public function agregarProducto()
  {
    try {
      $this->validarRequest($this->datosRequest, [
        'nombre' => 'required',
        'stockInicial' => 'required',
        'precio' => 'required',
        'costo' => 'required',
        'sku' => 'nullable',
      ]);

      ProductoService::agregarProducto($this->datosRequest);

      return $this->exitoResponse('Producto agregado correctamente.');
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Ocurrio un error al agregar el producto.');
    }
  }

  /**
   * Metodo para editar producto
   * @return response
   */
  public function editarProducto($productoId)
  {
    try {
      $this->validarRequest($this->datosRequest, [
        'nombre' => 'required',
        'precio' => 'required',
        'costo' => 'required',
        'sku' => 'nullable',
      ]);

      ProductoService::editarProducto($productoId, $this->datosRequest);

      return $this->exitoResponse('Producto editado correctamente.');
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Ocurrio un error al editar el producto.');
    }
  }

  /**
   * Metodo para eliminar producto
   * @return response
   */
  public function eliminarProducto($productoId = null)
  {
    try {
      if ($productoId == null) {
        throw new ValidacionException('El parametro productoId es necesario.');
      }

      ProductoService::eliminarProducto($productoId);

      return $this->exitoResponse('Producto eliminado correctamente.');
    } catch (Throwable $e) {
      return $this->errorResponse($e, 'Ocurrio un error al eliminar el producto.');
    }
  }
}
