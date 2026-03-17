<x-layouts::app>
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('clientes.index') }}">Clientes</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Crear</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <form action="{{ route('clientes.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
        @csrf
        <div class="space-y-4">
            <flux:input name="name" placeholder="David Soto" label="Nombre" value="{{ old('name') }}"></flux:input>
            <flux:input name="email" placeholder="davidsoto@mail.es" label="Email" value="{{ old('email') }}"></flux:input>
            <flux:input name="phone" placeholder="645251575" label="Telefono" value="{{ old('phone') }}"></flux:input>
            <flux:select name="provincia_id" label="Provincia">
                @foreach ($provincias as $provincia)
                    <flux:select.option
                        value="{{ $provincia->id }}"
                        :selected="old('provincia_id') == $provincia->id">
                        {{ $provincia->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>
            <flux:input name="zipcode" placeholder="09007" label="Codigo Postal" value="{{ old('zipcode') }}"></flux:input>
            @if (auth()->user()->hasRole('admin'))
                <flux:select name="vendedor_id" label="Comercial" :disabled="auth()->user()->hasRole('comercial')">
                    @foreach ($vendedores as $vendedor)
                        <flux:select.option
                            value="{{ $vendedor->id }}"
                            :selected="old('vendedor_id', auth()->user()->hasRole('comercial') ? auth()->id() : null) == $vendedor->id">
                            {{ $vendedor->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            @endif
            <flux:select name="tipo" label="Tipo de Cliente">
                @foreach (App\Enums\TipoCliente::cases() as $tipo)
                    <flux:select.option
                        value="{{ $tipo->value }}"
                        :selected="old('tipo') == $tipo->value">
                        {{ $tipo->label() }}
                    </flux:select.option>
                @endforeach
            </flux:select>
            <div class="space-y-2">
                <flux:label>Productos</flux:label>
                <div class="border border-default rounded-base divide-y divide-default">
                    @foreach ($productos as $producto)
                    <label class="flex items-center gap-3 px-4 py-3 hover:bg-neutral-secondary-soft cursor-pointer">
                        <flux:checkbox
                            name="productos[]"
                            value="{{ $producto->id }}"
                            :checked="in_array($producto->id, old('productos', []))">
                        </flux:checkbox>
                        <div class="flex justify-between w-full">
                            <span class="text-sm text-heading font-medium">{{ ucfirst($producto->name) }}</span>
                            <span class="text-sm text-body">{{ $producto->reference }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <flux:button type='submit' variant="primary">Crear Cliente</flux:button>
            </div>
        </div>
    </form>
</x-layouts::app>
