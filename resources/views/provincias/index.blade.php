<x-layouts::app title="Provincias">
	<div class="mb-8 flex justify-between items-center">
		<flux:breadcrumbs >
			<flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
			<flux:breadcrumbs.item>Provincias</flux:breadcrumbs.item>
		</flux:breadcrumbs>

	</div>
	<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default mb-4">
<table class="w-full text-sm text-left rtl:text-right text-body">
	<thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
		<tr class="bg-gray-200">
			<th scope="col" class="px-6 py-3 font-medium">
				ID
			</th>
			<th scope="col" class="px-6 py-3 font-medium">
				NAME
			</th>
		</tr>
	</thead>
	<tbody>

		@foreach ($provincias as $provincia)
		<tr class="bg-neutral-primary border-b border-default">
			<th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
				{{ $provincia->id }}
			</th>
			<td class="px-6 py-4">
				{{ $provincia->name }}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
</x-layouts::app>
