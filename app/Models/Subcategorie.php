<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategorie extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'subcategories';

    protected $fillable = [
        'id',
        'title',
        'color',
        'categorie_id',
    ];

    public function categories(): HasMany
    {
        return $this->hasMany(Categorie::class);
    }
}
