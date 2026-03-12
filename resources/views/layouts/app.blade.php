<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}

		@if (session('swal'))
			<script>
				Swal.fire(@json(session('swal')));
			</script>
		@endif
    </flux:main>
</x-layouts::app.sidebar>
