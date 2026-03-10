<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    protected $fillable = [
        'name',
        'reference',
        'stock',
    ];

    protected $casts = [
        'stock' => 'int',
    ];
    public function clientes()
    {
        return $this->belongsToMany(Cliente::class);
    }
}
