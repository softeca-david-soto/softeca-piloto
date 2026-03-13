<?php

namespace App\Models;

use App\Enums\TipoCliente;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
    'name',
    'email',
    'phone',
    'zipcode',
    'provincia_id',
    'vendedor_id',
    'tipo',
    ];

    protected $casts = [
        'tipo' => TipoCliente::class,
    ];

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'vendedor_id')->vendedores();
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }

    public function productos()
    {
       return $this->belongsToMany(Producto::class);
    }

}
