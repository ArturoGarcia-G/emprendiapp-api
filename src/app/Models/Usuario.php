<?php

namespace App\Models;

use App\Constantes\UsuarioConsts;
use App\Traits\AcceptsCamelCaseAttributes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
  use HasApiTokens, Notifiable, HasUuids, AcceptsCamelCaseAttributes;

  protected $table = 'usuarios';
  protected $primaryKey = 'usuario_id';
  protected $keyType = 'string';
  public $incrementing = false;
  public $timestamps = false;

  // Campos asignables para creación (se puede ajustar en el Service)
  protected $fillableCreate = [
    'nombre_completo',
    'usuario',
    'password',
    'status',
    'registro_fecha',
    'registro_autor_id',
    'id_negocio',
  ];

  // Campos asignables para actualización (excluye id_negocio, status, registro_*)
  protected $fillableUpdate = [
    'nombre_completo',
    'usuario',
    'password',
    'actualizacion_fecha',
    'actualizacion_autor_id',
  ];

  protected $hidden = ['password'];

  // Mutador para encriptar password automáticamente
  public function setPasswordAttribute($valor)
  {
    if (!empty($valor)) {
      $this->attributes['password'] = bcrypt($valor);
    }
  }

  // Eventos para asignar fechas y autores automáticos
  protected static function booted()
  {
    static::creating(function ($usuario) {
      $usuario->registro_fecha = now();
      $usuario->registro_autor_id = Auth::id() ?? 1;
      if (empty($usuario->status)) {
        $usuario->status = UsuarioConsts::STATUS_ACTIVO;
      }
      if (empty($usuario->id_negocio)) {
        $usuario->id_negocio = 1;
      }
    });

    static::updating(function ($usuario) {
      $usuario->actualizacion_fecha = now();
      $usuario->actualizacion_autor_id = Auth::id() ?? 1;
      // Evitar actualizar id_negocio y registro_fecha/id_autor
      unset($usuario->attributes['id_negocio']);
      unset($usuario->attributes['registro_fecha']);
      unset($usuario->attributes['registro_autor_id']);
      // No cambiar status aquí, eso será solo en método eliminar lógico
    });
  }

  // Método para obtener fillable según contexto
  public function fillCreate(array $attributes)
  {
    return $this->fill(array_intersect_key($attributes, array_flip($this->fillableCreate)));
  }

  public function fillUpdate(array $attributes)
  {
    return $this->fill(array_intersect_key($attributes, array_flip($this->fillableUpdate)));
  }

  public function setNombreCompletoAttribute($valor)
  {
    $this->attributes['nombre_completo'] = $valor;
  }
}
