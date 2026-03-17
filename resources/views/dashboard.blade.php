@php
    if (auth()->user()->hasRole('admin'))
    {
        $color = "bg-orange-700";
    }
    else
        $color = "bg-green-700";

    $response = Http::get('https://www.positive-api.online/phrase/esp');
@endphp

<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="mt-60">
            <h1 class="mb-4 text-4xl font-bold tracking-tight text-heading md:text-5xl lg:text-6xl">Hola, <mark class="px-2 pb-0.5 text-white {{ $color }}  rounded-base">{{ auth()->user()->name }}</mark><span class="inline-block translate-y-20">¿Qué quieres hacer hoy?</span></h1>
    </div>
    <div class="flex justify-center items-center mr-60">
        <div class="w-full max-w-md px-8 py-4 mt-45 bg-white rounded-lg shadow-lg dark:bg-gray-800">
                <h2 class="mt-2 text-xl font-semibold text-gray-800 dark:text-white md:mt-0">Frase Inspiradora</h2>

                <p class="mt-2 text-sm text-gray-600 dark:text-gray-200">{{ $response->json()['text'] }}</p>
            </div>
        </div>
    </div>
</x-layouts::app>
