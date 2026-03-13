<?php

namespace App\Enums;

enum TipoCliente: string
{
    case TRADICIONAL = 'tradicional';

    case SUPERMERCADO = 'supermercado';

    case CADENA = 'cadena';

    case DISTRIBUIDOR = 'distribuidor';

     public function label(): string {
        return match($this) {
            self:: TRADICIONAL => 'Cliente Tradicional',
            self:: SUPERMERCADO => 'Supermercado',
            self:: CADENA => 'Cadena',
            self:: DISTRIBUIDOR => 'Distribuidor',
        };
    }
}
