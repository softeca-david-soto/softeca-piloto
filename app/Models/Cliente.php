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
       return $this->belongsToMany(Producto::class, 'cliente_producto')->withPivot('precio');
    }

    public function syncProductosConPrecio(array $productoIds): void
    {
        $productos = Producto::whereIn('id', $productoIds)->get();

        $this->productos()->sync(
            $productos->mapWithKeys(fn($producto) => [
                $producto->id => ['precio' => $producto->{'precio_' . $this->tipo->value}]
            ])->toArray()
        );
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', 1);
    }


}
