<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}

        @stack('js')

		@if (session('swal'))
			<script>
				Swal.fire(@json(session('swal')));
			</script>
		@endif
    </flux:main>
</x-layouts::app.sidebar>
