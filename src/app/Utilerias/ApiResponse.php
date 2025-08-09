<?php

namespace App\Utilerias;

class ApiResponse
{

    /**
     * Construye una respuesta estructurada del api
     * @param int $codigo
     * @param string $mensaje
     * @param mixed $datos
     * @return array
     */
    public static function build(int $codigo, string $mensaje, $datos = null)
    {
        $respuesta = [];

        $respuesta['codigo']  = $codigo;
        $respuesta['mensaje'] = $mensaje;
        $respuesta['data']   = $datos;

        return $respuesta;
    }
}
