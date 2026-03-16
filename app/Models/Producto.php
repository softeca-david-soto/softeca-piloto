<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    protected $fillable = [
        'name',
        'reference',
        'stock',
        'precio_tradicional',
        'precio_supermercado',
        'precio_cadena',
        'precio_distribuidor',
    ];

    protected $casts = [
        'stock' => 'int',
    ];
    public function clientes()
    {
        return $this->belongsToMany(Cliente::class, 'cliente_producto')->withPivot('precio');
    }
}
