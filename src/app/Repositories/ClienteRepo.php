<?php

namespace App\Repositories;

use App\Constantes\ClienteConsts;
use App\Models\Cliente;
use App\Repositories\RH\ClienteRH;

class ClienteRepo
{

  /**
   * Repo para obtener clientes
   * @param array  $filtros
   * @param array $order
   * @param string $columnas
   * @return $clientes
   */
  public static function listarClientes($filtros = [], $order = [], $columnas = [])
  {
    $query = Cliente::query();

    ClienteRH::aplicarFiltros($query, $filtros);

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
   * Método para agregar un cliente
   * @param array $datosRequest
   */
  public static function agregarCliente(array $datosRequest)
  {
    $cliente = new Cliente();
    $cliente->fillCreate($datosRequest);
    $cliente->save();

    return $cliente;
  }

  /**
   * Método para obtener un cliente
   * @param string $clienteId
   * @param array $relaciones
   */
  public static function obtenerCliente($clienteId, $relaciones)
  {
    return Cliente::with($relaciones)->find($clienteId);
  }

  /**
   * Método para agregar un cliente
   * @param string $clienteId
   * @param array $datosRequest
   */
  public static function editarCliente(string $clienteId, array $datosRequest)
  {
    $cliente = Cliente::findOrFail($clienteId);
    $cliente->fill($datosRequest);
    $cliente->save();

    return $cliente;
  }

  public static function eliminarCliente(string $clienteId)
  {
    $cliente = Cliente::findOrFail($clienteId);
    $cliente->status = ClienteConsts::STATUS_ELIMINADO;
    $cliente->save();

    return $cliente;
  }
}
