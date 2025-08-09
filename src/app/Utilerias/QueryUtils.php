<?php

namespace App\Utilerias;

use Illuminate\Support\Facades\DB;
use stdClass;

class QueryUtils
{
    /**
     * Método para reemplazar los espacios en blanco y * de una cadena por %
     * @param $cadena
     * @return string
     */
    private static function stringReplaceIlike($cadena): string
    {
        $cadenaNueva = str_replace(' ', '%', $cadena);
        $cadenaNueva = str_replace('*', '%', $cadenaNueva);

        return $cadenaNueva;
    }

    /**
     * Método para realiza la búsqueda iLike
     * @param $busqueda
     * @param int $arrayLength
     * @return array
     */
    public static function busquedaIlike($busqueda, int $arrayLength): array
    {
        $busquedaArray = [];
        for ($i = 0; $i < $arrayLength; $i++) {
            $busquedaArray[] = "%".self::stringReplaceIlike($busqueda)."%";
        }

        return $busquedaArray;
    }

    /**
     * Función que genera una condcion SQL para filtrar fechas
     * @param Builder $query
     * @param string  $campo
     * @param string  $fechaInicio
     * @param string  $fechaFin
     */
    public static function queryFecha(&$query,  string $campo, $fechaInicio, $fechaFin = null)
    {
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $query->whereBetween($campo, [$fechaInicio . ' ' . '00:00:00', $fechaFin . ' ' . '23:59:59']);
        }

        if (!empty($fechaInicio) && empty($fechaFin)) {
            $query->where($campo, '>=', $fechaInicio . ' ' . '00:00:00');
        }

        if (empty($fechaInicio) && !empty($fechaFin)) {
            $query->where($campo, '<=', $fechaFin . ' ' . '23:59:59');
        }
    }

    /**
     * Función que genera una condcion SQL para filtrar fechas
     * @param Builder $query
     * @param string  $campo
     * @param string  $fechaInicio
     * @param string  $fechaFin
     */
    public static function queryFechaMes(&$query,  string $campo, $fechaInicio, $fechaFin = null)
    {
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $query->whereBetween($campo, [$fechaInicio, $fechaFin]);
        }

        if (!empty($fechaInicio) && empty($fechaFin)) {
            $query->where($campo, '>=', $fechaInicio);
        }

        if (empty($fechaInicio) && !empty($fechaFin)) {
            $query->where($campo, '<=', $fechaFin);
        }
    }

    /**
     * Función que genera una condcion SQL para filtrar fechas con orWhere
     * @param Builder $query
     * @param string  $campo
     * @param string  $fechaInicio
     * @param string  $fechaFin
     */
    public static function queryFechaOr(&$query,  string $campo, $fechaInicio, $fechaFin = null)
    {
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $query->orWhereBetween($campo, [$fechaInicio . ' ' . '00:00:00', $fechaFin . ' ' . '23:59:59']);
        }

        if (!empty($fechaInicio) && empty($fechaFin)) {
            $query->orWhere($campo, '>=', $fechaInicio . ' ' . '00:00:00');
        }

        if (empty($fechaInicio) && !empty($fechaFin)) {
            $query->orWhere($campo, '<=', $fechaFin . ' ' . '23:59:59');
        }
    }


    /**
     * Función que genera una condcion SQL para filtrar por totales
     * @param Builder $query
     * @param string  $campo
     * @param string  $totalInicio
     * @param string  $totalFin
     */
    public static function queryTotales(&$query,  string $campo, $totalInicio, $totalFin = null)
    {
        if (!empty($totalInicio) && !empty($totalFin)) {
            $query->whereBetween($campo, [$totalInicio, $totalFin]);
        }

        if (!empty($totalInicio) && empty($totalFin)) {
            $query->where($campo, '>=', $totalInicio);
        }

        if (empty($totalInicio) && !empty($totalFin)) {
            $query->where($campo, '<=', $totalFin);
        }
    }

    /**
     * Método para obtener el maximo de un folio con y sin ceros
     * siguiendo la numeración 0001 - 9999
     * @param $nombreTabla
     * @param $nombreColumnaFolio
     * @param string $nombreColumnaSerie
     * @param string $serie [string - serie a buscar si validacionSerie es true]
     * @param false $validacionSerie [boolean - si es verdadero aplica where = $nombreColumnaSerie]
     * @return stdClass
     */
    public static function obtenerFolioSerieMax(
        $nombreTabla,
        $nombreColumnaFolio,
        $nombreColumnaSerie = "",
        $serie = "",
        $validacionSerie = false,
        $validacionRaw = []
    ) {
        $respuesta = new stdClass();

        if (!$validacionSerie && empty($validacionRaw)) {
            $query = DB::connection('clienteDB')->table($nombreTabla)->max($nombreColumnaFolio);
        } elseif (!empty($validacionRaw)) {
            $query = DB::connection('clienteDB')->table($nombreTabla)
                ->whereRaw($validacionRaw["validacion"])
                ->max($nombreColumnaFolio);
        } else {
            $query = DB::connection('clienteDB')->table($nombreTabla)
                ->where($nombreColumnaSerie, $serie)
                ->max($nombreColumnaFolio);
        }

        $max = $query + 1;

        $respuesta->folio = $max;
        // $respuesta->folioConCeros = str_pad($max, 4, '0', STR_PAD_LEFT); //agrega 0 a la izquierda 4 posiciones

        return $respuesta;
    }
}
