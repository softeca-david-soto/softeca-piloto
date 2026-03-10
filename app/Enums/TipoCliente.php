<?php

namespace App\Enums;

enum TipoCliente: string
{
    case TRADICIONAL = 'tradicional';

    case SUPERMERCADO = 'supermercado';

    case CADENA = 'cadena';

    case DISTRIBUIDOR = 'distribuidor';
}
