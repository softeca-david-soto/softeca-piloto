@php
    if (auth()->user()->hasRole('admin'))
    {
        $color = "bg-orange-700";
    }
    else
        $color = "bg-green-700";
@endphp

<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="mt-80">
            <h1 class="mb-4 text-4xl font-bold tracking-tight text-heading md:text-5xl lg:text-6xl">Hola, <mark class="px-2 pb-0.5 text-white {{ $color }}  rounded-base">{{ auth()->user()->name }}</mark><span class="inline-block translate-y-20">¿Qué quieres hacer hoy?</span></h1>
        </div>
    </div>
</x-layouts::app>
