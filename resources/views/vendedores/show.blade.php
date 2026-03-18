<x-layouts::app title="Vendedor">
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('vendedores.index') }}">Vendedores</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $vendedor->name }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <a href="{{ route('vendedores.edit', $vendedor) }}">
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
                <h1 class="text-3xl font-bold text-heading tracking-tight">{{ $vendedor->name }}</h1>
                <p class="text-body mt-1">{{ $vendedor->email }}</p>
            </div>
        </div>
    </div>

    <div class="bg-neutral-primary-soft border border-default rounded-base p-6">
        <h2 class="text-sm font-medium text-body uppercase tracking-widest mb-4">Clientes asociados</h2>

        @if ($vendedor->clientes->where('activo', 1)->isEmpty())
            <p class="text-body text-sm">Este vendedor no tiene clientes asignados.</p>
        @else
            <div class="relative overflow-x-auto rounded-base border border-default">
    <table class="w-full text-sm text-left text-body">
        <thead class="text-sm text-body bg-neutral-secondary-soft border-b border-default">
            <tr>
                <th class="px-6 py-3 font-medium" width="10px"></th>
                <th class="px-6 py-3 font-medium">NOMBRE</th>
                <th class="px-6 py-3 font-medium">TIPO</th>
                <th class="px-6 py-3 font-medium">PROVINCIA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vendedor->clientes->where('activo', 1) as $cliente)
            <tr class="bg-neutral-primary border-b border-default">
                <td class="px-6 py-4">
                    <a href="{{ route('clientes.show', $cliente) }}" class="inline-flex items-center text-black hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </a>
                </td>
                <td class="px-6 py-4 font-medium text-heading">{{ $cliente->name }}</td>
                <td class="px-6 py-4">{{ $cliente->tipo->label() }}</td>
                <td class="px-6 py-4">{{ $cliente->provincia->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
        @endif
    </div>
</x-layouts::app>
