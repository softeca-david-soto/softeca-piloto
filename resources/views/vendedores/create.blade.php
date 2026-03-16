<x-layouts::app title="Nuevo Vendedor">
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('vendedores.index') }}">Vendedores</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Crear</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form action="{{ route('vendedores.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="space-y-4">
            <flux:input name="name" placeholder="Pablo Cuesta" label="Nombre" value="{{ old('name') }}"></flux:input>
            <flux:input name="email" placeholder="pablocuesta@embutidossoto.es" label="Email" value="{{ old('email') }}"></flux:input>
            <flux:input name="password" label="Contraseña" type="password"></flux:input>

            <div class="flex justify-end mt-4">
                <flux:button type="submit" variant="primary">Crear Vendedor</flux:button>
            </div>
        </div>
    </form>
</x-layouts::app>
