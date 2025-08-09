<?php

namespace App\Utilerias;

use Carbon\Carbon;
use DateTime;

class FechaUtils
{
  /**
   * Utileria para manejar fechas
   * @param string $zonaHoraria Zona horaria del cliente
   * @return string $fechaActual
   */
  public static function fechaActual(string $zonaHoraria = null)
  {
    $zonaHoraria = $zonaHoraria ?? env('APP_TIMEZONE', 'America/Mexico_City');
    $fechaActual = Carbon::now($zonaHoraria)->toDateTimeString();

    return $fechaActual;
  }

  /**
   * Utileria para obtener la fecha actual del servidor con milisegundos
   * @return string $fechaActual
   */
  public static function fechaActualMilisegundos(){
    $timeZone = env('APP_TIMEZONE', 'America/Mexico_City');
    return Carbon::now($timeZone)->format('Y-m-d H:i:s.u');
  }

  /**
   * Utileria para retornar la fecha actual en milisegundos
   * @param string $zonaHoraria Zona horaria del cliente
   * @return string $fechaActual
   */
  public static function fechaUnixMilisegundos(string $zonaHoraria = null)
  {
    $zonaHoraria = $zonaHoraria ?? env('APP_TIMEZONE', 'America/Mexico_City');
    return Carbon::now($zonaHoraria)->timestamp * 1000;
  }

  /**
   * Utileria para manejar fechas
   * @param string $fecha Fecha a crear
   * @param string $zonaHoraria Zona horaria del cliente
   * @return Carbon $fecha
   */
  public static function obtenerFechaObj(string $fecha = null, string $zonaHoraria = null)
  {
    $zonaHoraria = $zonaHoraria ?? env('APP_TIMEZONE', 'America/Mexico_City');
    if (empty($fecha))
      return Carbon::now($zonaHoraria);

    return Carbon::parse($fecha, $zonaHoraria);
  }

  /**
   * Utileria para formatear fechas
   * @param string $fecha Fecha a crear
   * @param int $formato Formato de fecha
   * @param bool $showHora Mostrar hora
   * @param string $zonaHoraria Zona horaria del cliente
   * @return Carbon $fecha
   */
  public static function formatearFecha(string $fecha, int $formato = 1, bool $showHora = false, string $zonaHoraria = null)
  {
    if (empty($fecha))
      return "";

    $zonaHoraria = $zonaHoraria ?? env('APP_TIMEZONE', 'America/Mexico_City');

    $fechaObj = Carbon::parse($fecha, $zonaHoraria)->locale('es_ES');

    $hora = $showHora ? $fechaObj->format('H:i') : '';

    switch ($formato) {
        // DD/MES/YYYY
      case 1:
        return "{$fechaObj->isoFormat('DD/MMM/YY')} {$hora}";
        // DD/MM/YYYY
      case 2:
        return "{$fechaObj->isoFormat('DD/MM/YYYY')} {$hora}";
        // YYYYMM
      case 3:
        return $fechaObj->format('Ym');
      case 4:
        return "{$fechaObj->isoFormat('YYYY-MM-DD')}";
        // YYYYMM
    }
  }

  /**
   * Utileria para calcular diferencia de dias entre dos fechas
   * @param string $fechaLimite
   * @param string $fechaValidar
   * @param string $zonaHoraria Zona horaria del cliente
   * @param boolval $diaString
   * @return string $diasDiferencia
   */
  public static function calcularDiasDiferencia(string $fechaLimite, string $fechaValidar = null, string $zonaHoraria = null, $diaString = true)
  {
    $zonaHoraria = $zonaHoraria ?? env('APP_TIMEZONE', 'America/Mexico_City');

    $fechaLimite = Carbon::parse($fechaLimite, $zonaHoraria);

    if (empty($fechaValidar))
      $fechaValidar = Carbon::now($zonaHoraria);
    else
      $fechaValidar = Carbon::parse($fechaValidar, $zonaHoraria);

    $diasDiferencia = $fechaLimite->diffInDays($fechaValidar);

    if ($diaString) {
      return "{$diasDiferencia} días";
    } else {
      return $diasDiferencia;
    }
  }

  /**
   * Utileria para calcular diferencia de minutos entre dos fechas
   * @param string $fechaInicio
   * @param string $fechaFin
   * @return string $minutosDiferencia
   */
  public static function diferenciaMinutos($fechaInicio, $fechaFin)
  {
    // Convierte las cadenas de fecha en objetos Carbon
    $fechaInicio = Carbon::parse($fechaInicio);
    $fechaFin = Carbon::parse($fechaFin);

    // Calcula la diferencia en minutos
    return $fechaInicio->diffInMinutes($fechaFin);
  }

  public static function obtenerFechaFactura($zonaHoraria)
  {
    // Convierte la fecha a un objeto DateTime
    $fechaObj = new DateTime(self::fechaActual($zonaHoraria));

    // Formatea la fecha en el formato requerido por el SAT
    $fechaSAT = $fechaObj->format('Y-m-d\TH:i:s');

    return $fechaSAT;
  }

  /**
   * Método que valida 2 fechas
   * @param Carbon $inicioOperaciones
   * @param Carbon $aplicacionFecha
   * @return bool
   */
  public static function validarFechas($inicioOperaciones, $aplicacionFecha)
  {
    $operacionAnio = $inicioOperaciones->year;
    $operacionMes = $inicioOperaciones->month;
    $aplicacionAnio = $aplicacionFecha->year;
    $aplicacionMes = $aplicacionFecha->month;

    return $operacionAnio == $aplicacionAnio && $operacionMes == $aplicacionMes;
  }

  /**
   * Método para calcular año entre dos fechas
   * @param mixed $mes
   * @param mixed $anio
   * @param Carbon $inicioOperaciones
   * @param Carbon $aplicacionFecha
   * @return $anio
   */
  public static function calcularAnio($mes, $anio, $inicioOperaciones, $aplicacionFecha)
  {
    if (!self::validarFechas($inicioOperaciones, $aplicacionFecha)) {
      if ($mes == 1) {
        return $anio - 1;
      } else {
        return $anio;
      }
    } else {
      return $anio;
    }
  }

  /**
   * Método para calcular mes entre dos fechas
   * @param mixed $mes
   * @param Carbon $inicioOperaciones
   * @param Carbon $aplicacionFecha
   * @return $mes
   */
  public static function calcularMes($mes, $inicioOperaciones, $aplicacionFecha)
  {
    if (!self::validarFechas($inicioOperaciones, $aplicacionFecha)) {
      if ($mes == 1) {
        return 12;
      } else {
        return $mes - 1;
      }
    } else {
      return $mes;
    }
  }

  /**
   * Método que obtiene el nombre del mes dependiendo del mes seleccionado
   * @param int $mes
   * @return string $mes
   */
  public static function obtenerNombreMes($mes)
  {
    Carbon::setLocale('es');
    return Carbon::create()->month($mes)->translatedFormat('F');
  }

  /**
   * Método para obtener la fecha del primer dia del mes en curso
   * @param string $zonaHoraria Zona horaria del cliente
   * @return string $primerDiaMes
   */
  public static function obtenerPrimerDiaMes($zonaHoraria = null)
  {
    $zonaHoraria = $zonaHoraria ?? env('APP_TIMEZONE', 'America/Mexico_City');
    $anioMesActual = Carbon::now($zonaHoraria)->format("Y-m");

    return $anioMesActual . "-01 00:00:00";
  }

  /**
   * Método para obtener el año de una fecha
   * @param string $zonaHoraria Zona horaria del cliente
   * @return string $primerDiaMes
   */
  public static function obtenerAnio($fecha)
  {
    $fecha = Carbon::parse($fecha);
    $anio = $fecha->year;

    return $anio;
  }

  /**
   * Método para obtener el año de una fecha
   * @param string $zonaHoraria Zona horaria del cliente
   * @return string $primerDiaMes
   */
  public static function obtenerMes($fecha)
  {
    $fecha = Carbon::parse($fecha);
    $mes = $fecha->format('m');

    return $mes;
  }

  /**
   * Método para agregar horas y minutos a una fecha
   */
  public static function asignarHoraYMinutos($fecha, $hora, $minutos)
  {
    // Convertir la fecha en un objeto Carbon
    $fechaObj = Carbon::parse($fecha);

    // Establecer la hora y los minutos proporcionados
    $fechaObj->setTime($hora, $minutos);

    return $fechaObj;
  }


  public static function obtenerHora($fecha)
  {
    if (!$fecha instanceof Carbon) {
      $fecha = Carbon::createFromFormat('Y-m-d H:i:s', $fecha);
    }

    // Obtener la hora como un número entero
    return $fecha->hour;
  }

  public static function obtenerMinutos($fecha)
  {
    if (!$fecha instanceof Carbon) {
      $fecha = Carbon::createFromFormat('Y-m-d H:i:s', $fecha);
    }

    // Obtener la hora como un número entero
    return $fecha->minute;
  }

  public static function obtenerHoraActual()
  {

    $zonaHoraria = $zonaHoraria ?? env('APP_TIMEZONE', 'America/Mexico_City');
    $fechaActual = Carbon::now($zonaHoraria);

    // Obtener la hora con minutos
    return $fechaActual->format('H:i');
  }

  /**
   * Método que compra dos fechas si son iguales
   * @param mixed $date1
   * @param mixed $date2
   * @param boolval $validarHoras
   */
  public static function compararDosFechas($date1, $date2, $validarHoras = false)
  {
    if ($validarHoras) {
      return Carbon::parse($date1)->eq(Carbon::parse($date2));
    } else {
      return Carbon::parse($date1)->startOfDay()->eq(Carbon::parse($date2)->startOfDay());
    }
  }

  /**
   * Método que valida si una fecha ya vencio repecto a otra o a la fecha actual
   */
  public static function vencioFecha($fechaValidar, $fechaVencimiento = null)
  {
    if (!empty($fechaVencimiento)) {
      $fechaLimite = new DateTime($fechaVencimiento);
    } else {
      $fechaLimite = new DateTime();
    }

    $fecha = new DateTime($fechaValidar);

    return $fecha < $fechaLimite;
  }
}
