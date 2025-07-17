<x-nav sticky>

    <x-slot:brand>

        <label for="main-drawer" class="lg:hidden mr-3">
            <x-icon name="o-bars-3" class="cursor-pointer"/>
        </label>


        <a href="{{ route('home') }}" class="text-primary font-bold text-lg font-alfa">
            Byblos
        </a>

    </x-slot:brand>


    <x-slot:actions>

        <x-button label="Feed" icon="o-rss" link="{{ route('panel.feed.index') }}" class="btn-ghost btn-sm" responsive/>


        <x-theme-toggle/>
        <label class="text-gray-300">|</label>

        @livewire('components.dashboard.navbar-notification')

        <x-dropdown icon="o-user" class="btn-circle">

            <x-menu-item title="Dashboard" link="{{ route('panel.index') }}" icon="o-squares-2x2"/>

            <x-menu-item title="My Profile" link="{{ route('panel.profile.edit') }}" icon="o-user"/>

            <x-menu-item title="Settings" link="{{ route('panel.setting.delivery') }}" icon="o-cog-6-tooth"/>

            <x-menu-separator/>

            <x-menu-item title="Help Center" link="{{ route('panel.help.index') }}" icon="o-question-mark-circle"/>


            <x-menu-separator/>

            <x-menu-item link="{{ route('logout') }}" title="Logout"
                         icon="o-arrow-right-start-on-rectangle"/>

        </x-dropdown>


    </x-slot:actions>
</x-nav>
