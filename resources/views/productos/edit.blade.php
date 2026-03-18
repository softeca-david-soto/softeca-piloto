<x-layouts::app title="Editar Producto">
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('productos.index') }}">Productos</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form action="{{ route('productos.update', $producto) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div class="space-y-4">

            <div>
                <flux:label>Nombre <span class="text-red-500 font-semibold">*</span></flux:label>
                <flux:input name="name" placeholder="Aceite de Oliva" value="{{ old('name', $producto->name) }}"></flux:input>
            </div>

            <div>
                <flux:label>Referencia <span class="text-red-500 font-semibold">*</span></flux:label>
                <flux:input name="reference" placeholder="REF-001" value="{{ old('reference', $producto->reference) }}"></flux:input>
            </div>

            <div>
                <flux:label>Stock <span class="text-red-500 font-semibold">*</span></flux:label>
                <flux:input name="stock" placeholder="0" type="number" value="{{ old('stock', $producto->stock) }}"></flux:input>
            </div>

            <div class="border border-default rounded-base p-4 space-y-4">
                <p class="text-sm font-medium text-body uppercase tracking-widest">Precios por tipo de cliente</p>
                @foreach ($tipos as $tipo)
                    <div>
                        <flux:label>{{ $tipo->label() }} <span class="text-red-500 font-semibold">*</span></flux:label>
                        <flux:input
                            name="precio_{{ $tipo->value }}"
                            placeholder="0.00"
                            type="number"
                            step="0.01"
                            value="{{ old('precio_' . $tipo->value, $producto->{'precio_' . $tipo->value}) }}">
                        </flux:input>
                    </div>
                @endforeach
            </div>

            <p class="text-xs text-zinc-400">
                <span class="text-red-500 font-semibold">*</span> Campos obligatorios
            </p>

            <div class="flex justify-end mt-4">
                <flux:button type="submit" variant="primary">Guardar Cambios</flux:button>
            </div>

        </div>
    </form>
</x-layouts::app>
