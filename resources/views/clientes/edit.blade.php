<x-layouts::app>
    <flux:breadcrumbs class="mb-4">
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('clientes.index') }}">Clientes</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <form action="{{ route('clientes.update', $cliente) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="space-y-4">

            <div>
                <flux:label>Nombre <span class="text-red-500 font-semibold">*</span></flux:label>
                <flux:input name="name" placeholder="David Soto" value="{{ old('name', $cliente->name) }}"></flux:input>
            </div>

            <div>
                <flux:label>Email <span class="text-red-500 font-semibold">*</span></flux:label>
                <flux:input name="email" placeholder="davidsoto@mail.es" value="{{ old('email', $cliente->email) }}"></flux:input>
            </div>

            <div>
                <flux:label>Teléfono <span class="text-red-500 font-semibold">*</span></flux:label>
                <flux:input name="phone" placeholder="645251575" value="{{ old('phone', $cliente->phone) }}"></flux:input>
            </div>

            <div>
                <flux:label>Provincia <span class="text-red-500 font-semibold">*</span></flux:label>
                <flux:select name="provincia_id">
                    @foreach ($provincias as $provincia)
                        <flux:select.option
                            value="{{ $provincia->id }}"
                            :selected="old('provincia_id', $cliente->provincia_id) == $provincia->id">
                            {{ $provincia->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <flux:input name="zipcode" placeholder="09007" label="Código Postal" value="{{ old('zipcode', $cliente->zipcode) }}"></flux:input>

            @if (auth()->user()->hasRole('admin'))
                <div>
                    <flux:label>Comercial <span class="text-red-500 font-semibold">*</span></flux:label>
                    <flux:select name="vendedor_id" :disabled="auth()->user()->hasRole('comercial')">
                        @foreach ($vendedores as $vendedor)
                            <flux:select.option
                                value="{{ $vendedor->id }}"
                                :selected="old('vendedor_id', $cliente->vendedor_id) == $vendedor->id">
                                {{ $vendedor->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            @endif

            <div>
                <flux:label>Tipo de Cliente <span class="text-red-500 font-semibold">*</span></flux:label>
                <flux:select name="tipo">
                    @foreach (App\Enums\TipoCliente::cases() as $tipo)
                        <flux:select.option
                            value="{{ $tipo->value }}"
                            :selected="old('tipo', $cliente->tipo->value) == $tipo->value">
                            {{ $tipo->label() }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <div class="space-y-2">
                <flux:label>Productos</flux:label>
                <div class="border border-default rounded-base divide-y divide-default">
                    @foreach ($productos as $producto)
                    <label class="flex items-center gap-3 px-4 py-3 hover:bg-neutral-secondary-soft cursor-pointer">
                        <flux:checkbox
                            name="productos[]"
                            value="{{ $producto->id }}"
                            :checked="in_array($producto->id, old('productos', $cliente->productos->pluck('id')->toArray()))">
                        </flux:checkbox>
                        <div class="flex justify-between w-full">
                            <span class="text-sm text-heading font-medium">{{ ucfirst($producto->name) }}</span>
                            <span class="text-sm text-body">{{ $producto->reference }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <p class="text-xs text-zinc-400">
                <span class="text-red-500 font-semibold">*</span> Campos obligatorios
            </p>

            <div class="flex justify-end mt-4">
                <flux:button type='submit' variant="primary">Guardar cambios</flux:button>
            </div>

        </div>
    </form>
</x-layouts::app>
