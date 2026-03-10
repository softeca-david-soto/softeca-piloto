<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }
}
