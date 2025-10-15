<?php

namespace App\Services;

use App\Constantes\ClienteConsts;
use App\Exceptions\ValidacionException;
use App\Models\Cliente;
use Exception;
use App\Repositories\ClienteRepo;
use App\Services\BO\ClienteBO;

class ClienteService
{
  /**
   * Método para obtener los clientes
   * @param array $filtros
   * @param array $order
   * @param string $columnas
   * @throws Exception $e
   */
  public static function listarClientes($filtros = [], $order = [], $columnas = '')
  {
    return ClienteRepo::listarClientes($filtros, $order, $columnas);
  }

  /**
   * Método para obtener un cliente
   * @param string $clienteId
   * @param array $relaciones
   */
  public static function obtenerCliente($clienteId, $relaciones = []): Cliente
  {
    return ClienteRepo::obtenerCliente($clienteId, $relaciones);
  }

  /**
   * Service que agrega un nuevo cliente
   * @param array $datosRequest
   */
  public static function agregarCliente($datosRequest)
  {
    $datos = ClienteBO::armarInsertCliente($datosRequest);
    return ClienteRepo::agregarCliente($datos);
  }

  /**
   * Service que edita un cliente
   * @param string $clienteId
   * @param array $datosRequest
   */
  public static function editarCliente($clienteId, $datosRequest)
  {
    return ClienteRepo::editarCliente($clienteId, $datosRequest);
  }

  /**
   * Service que elimina un cliente
   * @param string $clienteId
   * @param array $datosRequest
   */
  public static function eliminarCliente($clienteId)
  {
    $cliente = self::obtenerCliente($clienteId);
    if ($cliente->status != ClienteConsts::STATUS_ACTIVO) {
      throw new ValidacionException('El cliente ya se encuentra eliminado');
    }
    return ClienteRepo::eliminarCliente($clienteId);
  }
}
