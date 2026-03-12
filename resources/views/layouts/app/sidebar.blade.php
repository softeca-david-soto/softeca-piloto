@php
    $groups = ['Platform' => [['name' => 'Dashboard',
								'icon' => 'home',
								'url' => route('dashboard'),
								'active' => request()->routeIs()],
								['name' => 'Clientes',
								 'icon' => 'user-group',
								  'url' => route('clientes.index2'),
								 'active' => request()->routeIs('clientes.*')],
								['name' => 'Productos',
								 'icon' => 'cube',
								  'url' => route('productos.index'),
								 'active' => request()->routeIs('productos.*')],
							]];

    if (auth()->user()->hasRole('admin') || auth()->user()->hasPermissionTo('VER_VENDEDORES') || auth()->user()->hasPermissionTo('VER_TODOS_CLIENTES') )
    {
        $groups['Admin Zone'] = [['name' => 'Provincias',
                                  'icon' => 'map-pin',
                                  'url' => route('provincias.index'),
                                  'active' => request()->routeIs('provincias.*')],
                                  ['name' => 'Vendedores',
                                  'icon' => 'briefcase',
                                  'url' => route('vendedores.index'),
                                  'active' => request()->routeIs('vendedores.*')],
                                  ['name' => 'Todos los Clientes',
                                  'icon' => 'wallet',
                                  'url' => route('clientes.index'),
                                  'active' => request()->routeIs('clientes.*')],
                                ];
    }

    // dd($groups);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>

                @foreach ($groups as $group => $links)
                <flux:sidebar.group :heading="__($group)" class="grid">

					@foreach ($links as $link)
                    <flux:sidebar.item icon="{{$link['icon']}}"  :current="$link['active']" wire:navigate>
                        {{ __($link['name']) }}
                    </flux:sidebar.item>
					@endforeach

                </flux:sidebar.group>
				@endforeach


            </flux:sidebar.nav>

            <flux:spacer />

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
