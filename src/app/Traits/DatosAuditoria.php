<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

trait DatosAuditoria
{
  protected static function bootAutoAuthor()
  {
    static::creating(function ($model) {
      $model->registro_fecha = now();
      $model->registro_autor_id = Auth::id() ?? self::systemUserId();
      if (property_exists($model, 'status') && empty($model->status)) {
        $model->status = 'activo';
      }
    });

    static::updating(function ($model) {
      $model->actualizacion_fecha = now();
      $model->actualizacion_autor_id = Auth::id() ?? self::systemUserId();

      // Evitar sobrescribir registro original
      unset($model->attributes['registro_fecha']);
      unset($model->attributes['registro_autor_id']);
    });
  }

  /**
   * Devuelve el UUID del usuario "system"
   */
  protected static function systemUserId(): string
  {
    // Usuario "system" con UUID fijo o buscado dinámicamente
    $system = Usuario::where('usuario', 'system')->first();
    return $system?->usuario_id ?? '0198c57a-2658-710d-80f2-300d9e908a32';
  }
}
