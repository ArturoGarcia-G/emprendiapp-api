<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidacionException;
use App\Utilerias\TextoUtils;

trait ValidarRequestTrait
{
  /**
   * Valida datos con reglas dadas, lanza ValidacionException si falla.
   * @param array $datos Datos a validar
   * @param array $reglas Reglas de validación
   * @throws ValidacionException
   */
  public function validarRequest(array $datos, array $reglas)
  {
    $validator = Validator::make($datos, $reglas);

    if ($validator->stopOnFirstFailure()->fails()) {
      throw new ValidacionException(TextoUtils::obtenerMensajesValidator($validator->getMessageBag()));
    }
  }
}
