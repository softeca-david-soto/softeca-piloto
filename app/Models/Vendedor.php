<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Vendedor extends Authenticatable
{

    use HasRoles;
    protected $guard_name = 'web';

    protected $table = 'vendedores';

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
