<x-layouts::app title="Cliente">
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('clientes.index') }}">Clientes</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $cliente->name }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <a href="{{ route('clientes.edit', $cliente) }}">
            <div class="flex gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                <span>Editar</span>
            </div>
        </a>
    </div>

    <div class="bg-neutral-primary-soft border border-default rounded-base p-6 mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold text-heading tracking-tight">{{ $cliente->name }}</h1>
                <p class="text-body mt-1">ID #{{ $cliente->id }}</p>
            </div>
            <flux:badge color="blue">{{ $cliente->tipo->label() }}</flux:badge>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

        <div class="bg-neutral-primary-soft border border-default rounded-base p-6">
            <h2 class="text-sm font-medium text-body uppercase tracking-widest mb-4">Contacto</h2>
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-body shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                    <span class="text-heading">{{ $cliente->email }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-body shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                    </svg>
                    <span class="text-heading">{{ $cliente->phone }}</span>
                </div>
                @if ($cliente->zipcode)
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-body shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    <span class="text-heading">{{ $cliente->zipcode }}, {{ $cliente->provincia->name }}</span>
                </div>
                @else
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-body shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    <span class="text-heading">{{ $cliente->provincia->name }}</span>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-neutral-primary-soft border border-default rounded-base p-6">
            <h2 class="text-sm font-medium text-body uppercase tracking-widest mb-4">Comercial</h2>
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-body shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <span class="text-heading">{{ $cliente->vendedor->name }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-body shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                    </svg>
                    <span class="text-heading">{{ $cliente->tipo->label() }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-neutral-primary-soft border border-default rounded-base p-6">
        <h2 class="text-sm font-medium text-body uppercase tracking-widest mb-4">Productos</h2>

        @if ($cliente->productos->isEmpty())
            <p class="text-body text-sm">No hay productos asociados a este cliente.</p>
        @else
            <div class="relative overflow-x-auto rounded-base border border-default">
                <table class="w-full text-sm text-left text-body">
                    <thead class="text-sm text-body bg-neutral-secondary-soft border-b border-default">
                        <tr>
                            <th class="px-6 py-3 font-medium">REFERENCIA</th>
                            <th class="px-6 py-3 font-medium">NOMBRE</th>
                            <th class="px-6 py-3 font-medium">PRECIO</th>
                            <th class="px-6 py-3 font-medium">STOCK</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cliente->productos as $producto)
                        <tr class="bg-neutral-primary border-b border-default">
                            <td class="px-6 py-4 font-medium text-heading">{{ $producto->reference }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('productos.show', $producto) }}" class="hover:underline">
                                   {{  ucfirst($producto->name)  }}
                                </a>
                            </td>
                            <td class="px-6 py-4">{{ number_format($producto->pivot->precio, 2, ',').' €' }}</td>
                            <td class="px-6 py-4">{{ $producto->stock }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</x-layouts::app>
