<x-nav sticky>

    <x-slot:brand>
        {{-- Drawer toggle for "main-drawer" --}}
        <label for="main-drawer" class="lg:hidden mr-3">
            <x-icon name="o-bars-3" class="cursor-pointer"/>
        </label>

        {{-- Brand --}}
        <a href="{{ route('home') }}" class="text-primary font-bold text-lg font-alfa">
            Byblos
        </a>
    </x-slot:brand>

    {{-- Right side actions --}}
    <x-slot:actions>


        @livewire('admin-dashboard.notification.drawer-notification')

        <x-button label="Add VC" icon="o-plus-circle" link="{{ route('core.vc-firms.create') }}" class="btn-ghost btn-sm" responsive/>

        <label class="text-gray-400">|</label>

        <x-theme-toggle/>

        <x-dropdown icon="o-user" class="btn-circle">

            <x-menu-item title="Dashboard" link="{{ route('core.index') }}" icon="o-squares-2x2"/>

            <x-menu-item title="My Profile" link="" icon="o-user"/>


            <x-menu-separator/>

            <x-menu-item title="Help Center" link="{{ route('core.docs.index') }}" icon="o-question-mark-circle"/>


            <x-menu-separator/>

            <x-menu-item link="{{ route('logout') }}" title="Logout"
                         icon="o-arrow-right-start-on-rectangle"/>

        </x-dropdown>


    </x-slot:actions>
</x-nav>
