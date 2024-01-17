<?php

namespace App\Models;

use ArrayAccess;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    public static function findOrCreate(string|array|ArrayAccess $names): Collection|static
    {
        if (is_string($names)) {
            return static::query()->firstOrCreate([
                'name' => $names,
                'slug' => Str::slug($names),
            ]);
        }

        return collect($names)->map(function ($name) {
            if ($name instanceof Tag) {
                return $name;
            }

            return static::findOrCreate($name);
        });
    }
}
