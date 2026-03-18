<x-layouts::app title="Vendedores">
    <div class="mb-8 flex justify-between items-center">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Vendedores</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <a href="{{ route('vendedores.create') }}">
            <div class="flex gap-2 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>Nuevo Vendedor</span>
            </div>
        </a>
    </div>
    <form method="GET" action="{{ route('vendedores.index') }}" class="mb-6">
        <div class="bg-neutral-primary-soft border rounded-xl rounded-base p-4">
            <div class="grid grid-cols-2 md:grid-cols-2 gap-4">

                <flux:input
                    name="search"
                    placeholder="Nombre o email..."
                    value="{{ request('search') }}">
                </flux:input>

                <flux:select name="clientes">
                    <flux:select.option value="">Todos</flux:select.option>
                    <flux:select.option value="con" :selected="request('clientes') == 'con'">Con clientes</flux:select.option>
                    <flux:select.option value="sin" :selected="request('clientes') == 'sin'">Sin clientes</flux:select.option>
                </flux:select>

            </div>
            <div class="flex justify-end gap-2 mt-4">
                @if (request()->hasAny(['search', 'clientes']))
                    <a href="{{ route('vendedores.index') }}">
                        <flux:button variant="ghost">Limpiar</flux:button>
                    </a>
                @endif
                <flux:button type="submit" variant="primary">Filtrar</flux:button>
            </div>
        </div>
    </form>

    <div class="flex justify-between items-center mb-2">
        <a href="{{ route('vendedores.index', array_merge(request()->query(), ['order' => request('order', 'desc') == 'desc' ? 'asc' : 'desc'])) }}"
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

    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border rounded-xl mb-4">
        @if (count($vendedores) == 0)
            <p class="text-body text-sm">No se han encontrado vendedores.</p>
        @else
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="text-sm bg-gray-200 text-body bg-neutral-secondary-soft border-b rounded-base border-default">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">ID</th>
                    <th scope="col" class="px-6 py-3 font-medium">NOMBRE</th>
                    <th scope="col" class="px-6 py-3 font-medium">EMAIL</th>
                    <th scope="col" class="px-6 py-3 font-medium">CLIENTES</th>
                    <th scope="col" class="px-6 py-3 font-medium" width="10px">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendedores as $vendedor)
                <tr class="bg-neutral-primary border-b border-default">
                    <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                        {{ $vendedor->id }}
                    </th>
                    <td class="px-6 py-4">{{ $vendedor->name }}</td>
                    <td class="px-6 py-4">{{ $vendedor->email }}</td>
                    <td class="px-6 py-4">{{ $vendedor->clientes->where('activo', 1)->count() }}</td>
                    <td class="px-6 py-4 grid grid-cols-2">
                        <a href="{{ route('vendedores.edit', $vendedor) }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>
                        <form class="delete-form" action="{{ route('vendedores.destroy', $vendedor->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-2 text-red-600 hover:text-red-800 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </form>
                        <a href="{{ route('vendedores.show', $vendedor) }}" class="inline-flex items-center gap-2 text-black hover:text-gray-700">
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

    @push('js')
    <script>
		let forms = document.querySelectorAll('.delete-form');

		forms.forEach(form => {
			form.addEventListener('submit', (e)=>{
				e.preventDefault();

				Swal.fire({
					title: "Quieres eliminar este vendedor?",
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
	</script>
    @endpush
</x-layouts::app>
