<?php

namespace App\Utilerias;

use DomainException;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\MessageBag;
use PDOException;
use Ramsey\Uuid\Uuid;
use Throwable;

class TextoUtils
{
  /**
   * Metodo para obtener mensajes de clase validator
   * @param MessageBag $excepciones
   * @return string $mensajes
   */
  public static function obtenerMensajesValidator(MessageBag $excepciones)
  {
    $mensajes = "";

    foreach ($excepciones->all() as $excepcion)
      $mensajes .= $excepcion . '<br>';

    return $mensajes;
  }

  /**
   * Método que retorna un string limpio de caracteres especiales
   * @param $cadena Texto a limpiar
   * @return false|string
   */
  public static function limpiarCadena($cadena)
  {
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby';
    $cadena = mb_convert_encoding($cadena,  'ISO-8859-1', 'UTF-8');
    $cadena = strtr($cadena, mb_convert_encoding($originales,  'ISO-8859-1', 'UTF-8'), $modificadas);
    return mb_convert_encoding($cadena, 'UTF-8', 'ISO-8859-1');
  }


  public static function generarUUIDv4()
  {
    // Generar un UUIDv4
    $uuid = Uuid::uuid4();

    // Obtiene la representación en cadena del UUID
    $uuidString = $uuid->toString();

    return $uuidString;
  }

  /**
   * Metodo para agregar log de error
   * @param Exception $e | Excepcion producida
   * @param string $level | Nivel de error (error,debug,warning)
   * @param string $clase | Clases y metodo del error
   */
  public static function agregarLog(Throwable $e, $level, $codigoInterno)
  {
    $codigoExcepcion = $e->getCode();
    $lineaError   = $e->getLine();
    $mensajeError = $e->getMessage();
    $archivo = $e->getFile();

    Log::channel('errorlog')->{$level}("CodigoInterno: {$codigoInterno}");
    Log::channel('errorlog')->{$level}("Linea: {$lineaError}");
    Log::channel('errorlog')->{$level}("Archivo: {$archivo}");
    Log::channel('errorlog')->{$level}("CodigoExcepcion: {$codigoExcepcion}");
    if ($e == $e instanceof QueryException || $e == $e instanceof PDOException) {
      $mensajeDB = SQLResponse::obtenerMensaje($codigoExcepcion);
      Log::channel('errorlog')->{$level}("DB: $mensajeDB");
    }
    if ($level == 'error') {
      $stackTrace = $e->getTraceAsString();
      Log::channel('errorlog')->{$level}("Stacktrace: {$stackTrace}");
    }
    if ($e == $e instanceof DomainException) {
      $translations = include base_path('app/Translations/es_ES.php');
      $mensajeError = $translations[$mensajeError] ?? $mensajeError;
    }
    Log::channel('errorlog')->{$level}("Mensaje: {$mensajeError}");
    Log::channel('errorlog')->{$level}('=================================================================================');
    if ($level == 'debug' || $level == 'warning') {
      return $mensajeError;
    }
  }

  /**
   * Utileria que capitaliza la cadena mandada y si encuentra guiones bajos los transforma por espacios
   * @param string $cadena
   * @return string
   */
  public static function capitalizarTexto($cadena)
  {
    $cadenaConEspacios = str_replace('_', ' ', $cadena);

    return ucfirst($cadenaConEspacios);
  }

  public static function generarNumeroAleatorio()
  {
    // Genera un número aleatorio de 6 dígitos entre 0 y 999999
    $numeroAleatorio = mt_rand(0, 999999);

    // Rellena con ceros a la izquierda si el número generado tiene menos de 6 dígitos
    $numeroAleatorio = str_pad($numeroAleatorio, 6, '0', STR_PAD_LEFT);

    return $numeroAleatorio;
  }
}
