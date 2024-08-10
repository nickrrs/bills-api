<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'path', 'fileable_type', 'fileable_id', 'size', 'mime_type', 'extension', 'description'];

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}
