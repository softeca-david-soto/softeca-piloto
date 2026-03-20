<x-layouts::app title="Clientes">
	<div class="mb-8 flex justify-between items-center">
		<flux:breadcrumbs >
			<flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
			@if ($todos)
            <flux:breadcrumbs.item>Todos Clientes</flux:breadcrumbs.item>
            @else
            <flux:breadcrumbs.item>Mis Clientes</flux:breadcrumbs.item>
            @endif
		</flux:breadcrumbs>

        <div class="flex justify-end">
            <a href="{{ route('clientes.create') }}">
                <div class="flex gap-2 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    <span>
                        New Client
                    </span>

                </div>
            </a>
        </div>
	</div>
    <form method="GET" action="{{ route('clientes.index') }}" class="mb-6">
    <div class="bg-neutral-primary-soft border rounded-xl rounded-base p-4">
        <div class="grid grid-cols-3 md:grid-cols-3 gap-4">

            <flux:select name="tipo" placeholder="Tipo de cliente">
                <flux:select.option value="">Todos los tipos</flux:select.option>
                @foreach (App\Enums\TipoCliente::cases() as $tipo)
                    <flux:select.option
                        value="{{ $tipo->value }}"
                        :selected="request('tipo') == $tipo->value">
                        {{ $tipo->label() }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:select name="provincia_id" placeholder="Provincia">
                <flux:select.option value="">Todas las provincias</flux:select.option>
                @foreach ($provincias as $provincia)
                    <flux:select.option
                        value="{{ $provincia->id }}"
                        :selected="request('provincia_id') == $provincia->id">
                        {{ $provincia->name }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:select name="producto_id" placeholder="Producto">
                <flux:select.option value="">Todos los productos</flux:select.option>
                @foreach ($productos as $producto)
                    <flux:select.option
                        value="{{ $producto->id }}"
                        :selected="request('producto_id') == $producto->id">
                        {{ ucfirst($producto->name) }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            @if (auth()->user()->hasRole('admin'))
                <div class="col-start-1 col-end-2">
                    <flux:select name="vendedor_id" placeholder="Comercial" class="col-span-2 mt-4">
                        <flux:select.option value="">Todos los comerciales</flux:select.option>
                        @foreach ($vendedores as $vendedor)
                            <flux:select.option
                                value="{{ $vendedor->id }}"
                                :selected="request('vendedor_id') == $vendedor->id">
                                {{ $vendedor->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            @endif
        </div>
        <div class="flex justify-end gap-2 mt-4">
            @if (request()->hasAny(['tipo', 'provincia_id', 'producto_id', 'vendedor_id']))
                <a href="{{ route('clientes.index') }}">
                    <flux:button variant="ghost">Limpiar</flux:button>
                </a>
            @endif
            <flux:button type="submit" variant="primary">Filtrar</flux:button>
        </div>
    </div>
</form>
    @can('VER_TODOS_CLIENTES')
    <div id="panel-asignacion" class="hidden mb-4 bg-neutral-primary-soft border border-default rounded-xl p-4 flex items-center gap-4">
        <span class="text-sm text-body"><span id="count-seleccionados">0</span> clientes seleccionados</span>
        <select id="select-comercial" name="vendedor_id" class="w-64">
            @foreach ($vendedores as $vendedor)
                <option value="{{ $vendedor->id }}">{{ $vendedor->name }}</option>
            @endforeach
        </select>
        <flux:button id="btn-asignar" variant="primary" size="sm">Asignar comercial</flux:button>
        <flux:button id="btn-cancelar" variant="ghost" size="sm">Cancelar</flux:button>
    </div>
    @endcan
    <div class="flex justify-between mb-2">
        <div class="flex justify-between items-center ">
            <a href="{{ route('clientes.index', array_merge(request()->query(), ['order' => request('order', 'desc') == 'desc' ? 'asc' : 'desc'])) }}"
            class="inline-flex items-center gap-1.5 text-xs text-body hover:text-heading transition-colors">
                @if (request('order', 'desc') == 'desc')
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0-3.75-3.75M17.25 21 21 17.25" />
                    </svg>
                    <span>Más recientes primero</span>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h5.25m5.25-.75L17.25 9m0 0L21 12.75M17.25 9v12" />
                    </svg>
                    <span>Más antiguos primero</span>
                @endif
            </a>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('clientes.plantilla') }}"
                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold
                    bg-gray-50 text-gray-700 border border-gray-200
                    hover:bg-gray-100 hover:border-gray-300 hover:shadow-sm
                    active:scale-95 transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Descargar Plantilla


            </a>
            <a href="{{ route('clientes.export', request()->all()) }}"
                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold
                    bg-emerald-50 text-emerald-700 border border-emerald-200
                    hover:bg-emerald-100 hover:border-emerald-300 hover:shadow-sm
                    active:scale-95 transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m6.75 12-3-3m0 0-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                Exportar
            </a>
            <flux:modal.trigger name="import-modal">
                <button type="button"
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold
                        bg-blue-50 text-blue-700 border border-blue-200
                        hover:bg-blue-100 hover:border-blue-300 hover:shadow-sm
                        active:scale-95 transition-all duration-150 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    Importar
                </button>
            </flux:modal.trigger>

            <flux:modal name="import-modal" class="md:w-112.5">
                <form action="{{ route('clientes.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <flux:heading size="lg">Importar Clientes</flux:heading>
                        <flux:subheading>Selecciona un archivo .xlsx o .csv con el formato correcto.</flux:subheading>
                    </div>
                    <div class="rounded-lg border border-blue-100 bg-blue-50/50 p-4 space-y-3">
                        <div class="flex items-center gap-2 text-blue-800 font-semibold text-xs uppercase tracking-wider">
                            <svg xmlns="http://www.w3.org" viewBox="0 0 20 20" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a1 1 0 0 0 0 2v3a1 1 0 0 0 1 1h1a1 1 0 1 0 0-2v-3a1 1 0 0 0-1-1H9Z" clip-rule="evenodd" />
                            </svg>
                            Reglas de importación
                        </div>
                        <ul class="space-y-2 text-xs text-blue-700/80 leading-relaxed">

                            <li class="flex gap-2">
                                <span class="font-bold text-blue-800">Crear:</span>
                                Deja el campo <code class="bg-blue-100 px-1 rounded text-blue-900">id</code> vacío para registrar un nuevo cliente.
                            </li>
                            <li class="flex gap-2">
                                <span class="font-bold text-blue-800">Actualizar:</span>
                                Indica el <code class="bg-blue-100 px-1 rounded text-blue-900">id</code> de un cliente que ya te pertenezca para modificarlo.
                            </li>
                            <li class="flex gap-2">
                                <span class="font-bold text-blue-800">Seguridad:</span>
                                @if(auth()->user()->hasRole('comercial'))
                                    Todo nuevo registro se asignará automáticamente a tu usuario.
                                @else
                                    Usa la columna <code class="bg-blue-100 px-1 rounded text-blue-900">vendedor_id</code> para asignar comerciales.
                                @endif
                            </li>
                            @if(auth()->user()->hasRole('admin'))
                                <li class="flex gap-2">
                                    <span class="font-bold text-blue-800">Admin:</span>
                                    Debes indicar el <code class="bg-blue-100 px-1 rounded text-blue-900">vendedor_id</code> numérico para asignar cada cliente.
                                </li>
                            @else
                                <li class="flex gap-2">
                                    <span class="font-bold text-blue-800">Comercial:</span>
                                    Puedes dejar vendedor_id vacío. El sistema te asignará los clientes automáticamente.
                                </li>
                            @endif
                            <li class="flex gap-2">
                                <span class="font-bold text-blue-800">Productos:</span>
                                Separa los IDs de productos con comas (ej: 1,4,12).
                            </li>
                        </ul>
                    </div>

                    <flux:input type="file" name="file" label="Archivo Excel" required accept=".xlsx,.xls,.csv" />

                    <div class="flex gap-2">
                        <flux:spacer />
                        <flux:modal.close>
                            <flux:button variant="ghost">Cancelar</flux:button>
                        </flux:modal.close>
                        <flux:button type="submit" variant="primary">Subir y Procesar</flux:button>
                    </div>
                </form>
            </flux:modal>

        </div>
    </div>
    @if (session()->has('success'))
        <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center gap-2">
            <svg xmlns="http://www.w3.org" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('import_errors'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl overflow-hidden">
            <div class="bg-red-100 px-4 py-2 border-b border-red-200 flex items-center gap-2 text-red-800 font-bold text-sm">
                <svg xmlns="http://www.w3.org" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                No se ha guardado ningún dato. Corrige los siguientes errores:
            </div>
            <div class="p-4 max-h-60 overflow-y-auto">
                <ul class="space-y-2">
                    @foreach (session()->get('import_errors') as $failure)
                        <li class="text-xs text-red-700 flex flex-col">
                            <span class="font-bold uppercase tracking-wider">Fila {{ $failure->row() }} - Columna "{{ $failure->attribute() }}":</span>
                            <div class="flex flex-col ml-2">
                                @foreach ($failure->errors() as $error)
                                    <span>• {{ $error }}</span>
                                @endforeach
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
            {{ session('error') }}
        </div>
    @endif
	<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border rounded-xl mb-4">
    @if (count($clientes) == 0)
            <p class="text-body text-sm">No se han encontrado clientes.</p>
    @else
    <table class="w-full text-sm text-left rtl:text-right text-body">
	<thead class="text-sm text-body bg-gray-200 border-b rounded-base border-default">
		<tr>
            @can('VER_TODOS_CLIENTES')
            <th scope="col" class="px-6 py-3 font-medium w-8"></th>
            @endcan
			<th scope="col" class="px-6 py-3 font-medium">
				ID
			</th>
			<th scope="col" class="px-6 py-3 font-medium">
				NOMBRE
			</th>
            @can('VER_TODOS_CLIENTES')
            <th scope="col" class="px-6 py-3 font-medium">
                COMERCIAL
            </th>
            @endcan
            <th scope="col" class="px-6 py-3 font-medium">
                TIPO
            </th>
            <th scope="col" class="px-6 py-3 font-medium">
                PROVINCIA
            </th>
			<th scope="col" class="px-6 py-3 font-medium" width="10px">
				ACTIONS
			</th>
		</tr>
	</thead>
	<tbody>

		@foreach ($clientes as $cliente)
		<tr class="bg-neutral-primary border-b border-default fila-cliente">
            @can('VER_TODOS_CLIENTES')
            <td class="px-6 py-4">
                <input type="checkbox" class="checkbox-cliente cursor-pointer" value="{{ $cliente->id }}">
            </td>
            @endcan
			<th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
				{{ $cliente->id }}
			</th>
			<td class="px-6 py-4">
                {{ $cliente->name }}
			</td>
            @can('VER_TODOS_CLIENTES')
                @if ($cliente->vendedor == null)
                    <td class="px-6 py-4 italic">
                        <p>No asignado</p>
                    </td>
                @else
                    <td class="px-6 py-4">
                        {{ $cliente->vendedor->name }}
                    </td>
                @endif
            @endcan
            <td class="px-6 py-4">
				{{ $cliente->tipo->label()  }}
			</td>
            <td class="px-6 py-4">
				{{ $cliente->provincia->name }}
			</td>
			<td class="px-6 py-4 grid grid-cols-2">
                <a href="{{ route('clientes.edit', ['cliente' => $cliente]) }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800"">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                </a>
                <form class="delete-form" action="{{ route('clientes.destroy', $cliente->id) }}" method="POST">

					@csrf

					@method('DELETE')

					<button type="submit" class="inline-flex items-center gap-2 text-red-600 hover:text-red-800 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
				</form>
                <a href="{{ route('clientes.show', ['cliente' => $cliente]) }}" class="inline-flex items-center gap-2 text-black hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </a>
            </td>
		</tr>

		@endforeach
	</tbody>
    </table>
    @endif
</div>

<div class="mt-4">
	{{ $clientes->links() }}
</div>

@push('js')
	<script>
		let forms = document.querySelectorAll('.delete-form');

		forms.forEach(form => {
			form.addEventListener('submit', (e)=>{
				e.preventDefault();

				Swal.fire({
					title: "Quieres eliminar este cliente?",
					text: "Este cambio no es reversible",
					icon: "warning",
					showCancelButton: true,
					confirmButtonColor: "#3085d6",
					cancelButtonColor: "#d33",
					confirmButtonText: "Si, eliminalo"
					}).then((result) => {
					if (result.isConfirmed) {
						form.submit();
					}
				});

			});
		});

        document.addEventListener('DOMContentLoaded', function () {

        jQuery('#select-comercial').select2({
            theme: 'tailwindcss-4',
            placeholder: 'Seleccionar comercial...',
            width: '16rem',
        });

        const panel = document.getElementById('panel-asignacion');
        const countEl = document.getElementById('count-seleccionados');
        const btnCancelar = document.getElementById('btn-cancelar');
        const btnAsignar = document.getElementById('btn-asignar');

        function actualizarPanel() {
            const seleccionados = document.querySelectorAll('.checkbox-cliente:checked');
            countEl.textContent = seleccionados.length;
            panel.classList.toggle('hidden', seleccionados.length === 0);
        }

        document.querySelectorAll('.fila-cliente').forEach(fila => {
            fila.addEventListener('dblclick', function () {
                const checkbox = this.querySelector('.checkbox-cliente');
                checkbox.checked = !checkbox.checked;
                actualizarPanel();
            });

            const checkbox = fila.querySelector('.checkbox-cliente');
            if (checkbox) {
                checkbox.addEventListener('change', actualizarPanel);
            }
        });

        btnCancelar.addEventListener('click', function () {
            document.querySelectorAll('.checkbox-cliente').forEach(cb => cb.checked = false);
            actualizarPanel();
        });

        btnAsignar.addEventListener('click', function () {
            const ids = Array.from(document.querySelectorAll('.checkbox-cliente:checked'))
                            .map(cb => cb.value);
            const vendedorId = jQuery('#select-comercial').val();

            if (!vendedorId) {
                alert('Selecciona un comercial');
                return;
            }

            fetch('{{ route('clientes.asignarVendedor') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ clientes: ids, vendedor_id: vendedorId })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            });
        });
    });
	</script>
@endpush
</x-layouts::app>

