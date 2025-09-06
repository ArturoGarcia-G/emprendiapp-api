<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponseTrait;
use App\Traits\ValidarRequestTrait;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Controllador base para petciones api
|-------------------------------------------------------------------------- 
*/

class BaseController extends Controller
{
  use ApiResponseTrait;
  use ValidarRequestTrait;
  protected string $columnas = '';
  protected array $filtros = [];
  protected array $orden = [];
  protected array $datosRequest;

  public function __construct(Request $request)
  {
    $this->datosRequest = $request->all();

    $this->columnas = $request->input('columnas', '');

    $this->filtros = $this->parseJsonInput($request->input('filtros', []));
    $this->orden   = $this->parseJsonInput($request->input('order', []));
  }

  private function parseJsonInput($input): array
  {
    if (is_string($input)) {
      $decoded = json_decode($input, true);
      return json_last_error() === JSON_ERROR_NONE ? $decoded : [];
    }
    return is_array($input) ? $input : [];
  }
}
