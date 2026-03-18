<x-layouts::app title="Nuevo Vendedor">
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('vendedores.index') }}">Vendedores</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Crear</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form action="{{ route('vendedores.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="space-y-4">

            <div>
                <flux:label>Nombre <span class="text-red-500 font-semibold">*</span></flux:label>
                <flux:input name="name" placeholder="Pablo Cuesta" value="{{ old('name') }}"></flux:input>
            </div>

            <div>
                <flux:label>Email <span class="text-red-500 font-semibold">*</span></flux:label>
                <flux:input name="email" placeholder="pablocuesta@embutidossoto.es" value="{{ old('email') }}"></flux:input>
            </div>

            <div>
                <flux:label>Contraseña <span class="text-red-500 font-semibold">*</span></flux:label>
                <flux:input name="password" type="password"></flux:input>
            </div>

            <p class="text-xs text-zinc-400">
                <span class="text-red-500 font-semibold">*</span> Campos obligatorios
            </p>

            <div class="flex justify-end mt-4">
                <flux:button type="submit" variant="primary">Crear Vendedor</flux:button>
            </div>

        </div>
    </form>
</x-layouts::app>
