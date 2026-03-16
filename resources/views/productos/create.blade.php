<x-layouts::app title="Nuevo Producto">
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('productos.index') }}">Productos</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Crear</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form action="{{ route('productos.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="space-y-4">
            <flux:input name="name" placeholder="Aceite de Oliva" label="Nombre" value="{{ old('name') }}"></flux:input>
            <flux:input name="reference" placeholder="00AA" label="Referencia" value="{{ old('reference') }}"></flux:input>
            <flux:input name="stock" placeholder="0" label="Stock" type="number" value="{{ old('stock', 0) }}"></flux:input>

            <div class="border border-default rounded-base p-4 space-y-4">
                <p class="text-sm font-medium text-body uppercase tracking-widest">Precios por tipo de cliente</p>
                @foreach ($tipos as $tipo)
                <flux:input
                    name="precio_{{ $tipo->value }}"
                    label="{{ $tipo->label() }}"
                    placeholder="0.00"
                    type="number"
                    step="0.01"
                    value="{{ old('precio_' . $tipo->value) }}">
                </flux:input>
                @endforeach
            </div>

            <div class="flex justify-end mt-4">
                <flux:button type="submit" variant="primary">Crear Producto</flux:button>
            </div>
        </div>
    </form>
</x-layouts::app>
