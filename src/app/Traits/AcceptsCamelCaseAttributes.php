<?php

namespace App\Traits;

trait AcceptsCamelCaseAttributes
{
    /**
     * Sobrescribe setAttribute para aceptar tanto snake_case como camelCase
     */
    public function setAttribute($key, $value)
    {
        // Si viene en camelCase -> convertir a snake_case
        $snakeKey = \Illuminate\Support\Str::snake($key);

        return parent::setAttribute($snakeKey, $value);
    }

    /**
     * Sobrescribe fill para que use setAttribute (y así dispare mutators)
     */
    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }
}
