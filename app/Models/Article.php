<?php

namespace App\Models;

use App\Concerns\HasSlug;
use App\Concerns\HasTags;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    use HasTags;
    use HasSlug;

    protected function sluggable(): string
    {
        return 'title';
    }
}
