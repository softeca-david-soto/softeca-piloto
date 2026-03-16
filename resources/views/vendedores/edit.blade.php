<x-layouts::app title="Editar Vendedor">
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('vendedores.index') }}">Vendedores</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form action="{{ route('vendedores.update', $vendedor) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <flux:input name="name" placeholder="Pablo Cuesta" label="Nombre" value="{{ old('name', $vendedor->name) }}"></flux:input>
            <flux:input name="email" placeholder="pablo@empresa.es" label="Email" value="{{ old('email', $vendedor->email) }}"></flux:input>

            <div class="border border-default rounded-base p-4 space-y-4">
                <p class="text-sm font-medium text-body uppercase tracking-widest">Cambiar contraseña <span class="normal-case font-normal">(dejar en blanco para mantener)</span></p>
                <flux:input name="password" label="Nueva Contraseña" type="password"></flux:input>
            </div>

            <div class="flex justify-end mt-4">
                <flux:button type="submit" variant="primary">Guardar Cambios</flux:button>
            </div>
        </div>
    </form>
</x-layouts::app>
