<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $fillable = [
        'name',
    ];

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }
}
