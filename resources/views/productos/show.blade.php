<x-layouts::app title="Producto">
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('productos.index') }}">Productos</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ ucfirst($producto->name) }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        @can('CREAR_PRODUCTOS')
        <a href="{{ route('productos.edit', $producto) }}">
            <div class="flex gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                <span>Editar</span>
            </div>
        </a>
        @endcan
    </div>

    <div class="bg-neutral-primary-soft border border-default rounded-base p-6 mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold text-heading tracking-tight">{{ ucfirst($producto->name) }}</h1>
                <p class="text-body mt-1">{{ $producto->reference }}</p>
            </div>
            <flux:badge color="{{ $producto->stock > 50 ? 'green' : 'red' }}">
                Stock: {{ $producto->stock }}
            </flux:badge>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

        <div class="bg-neutral-primary-soft border border-default rounded-base p-6">
            <h2 class="text-sm font-medium text-body uppercase tracking-widest mb-4">Precios por tipo de cliente</h2>
            <div class="space-y-3">
                @foreach ($tipos as $tipo)
                <div class="flex justify-between items-center">
                    <span class="text-sm text-body">{{ $tipo->label() }}</span>
                    <span class="text-sm font-medium text-heading">
                        {{ number_format($producto->{'precio_' . $tipo->value}, 2) }} €
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-neutral-primary-soft border border-default rounded-base p-6">
            <h2 class="text-sm font-medium text-body uppercase tracking-widest mb-4">Información</h2>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-body">Referencia</span>
                    <span class="text-sm font-medium text-heading">{{ $producto->reference }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-body">Stock disponible</span>
                    <span class="text-sm font-medium text-heading">{{ $producto->stock }} uds.</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-body">Clientes asociados</span>
                    <span class="text-sm font-medium text-heading">{{ $producto->clientes->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-neutral-primary-soft border border-default rounded-base p-6">
        <h2 class="text-sm font-medium text-body uppercase tracking-widest mb-4">Clientes con este producto</h2>

        @if ($clientes->isEmpty())
            <p class="text-body text-sm">No hay clientes asociados a este producto.</p>
        @else
            <div class="relative overflow-x-auto rounded-base border border-default">
                <table class="w-full text-sm text-left text-body">
                    <thead class="text-sm text-body bg-neutral-secondary-soft border-b border-default">
                        <tr>
                            <th class="px-6 py-3 font-medium">CLIENTE</th>
                            <th class="px-6 py-3 font-medium">TIPO</th>
                            <th class="px-6 py-3 font-medium">PRECIO ASIGNADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                        <tr class="bg-neutral-primary border-b border-default">
                            <td class="px-6 py-4 font-medium text-heading">
                                <a href="{{ route('clientes.show', $cliente) }}" class="hover:underline">
                                    {{ $cliente->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ $cliente->tipo->label() }}</td>
                            <td class="px-6 py-4">{{ number_format($cliente->pivot->precio, 2) }} €</td>
                            {{-- {{ dd($cliente->pivot) }} --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts::app>
