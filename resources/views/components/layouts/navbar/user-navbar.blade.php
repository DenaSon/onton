<x-nav sticky>

    {{-- BRAND --}}
    <x-slot:brand>
        <label for="main-drawer" class="lg:hidden mr-3">
            <x-icon name="o-bars-3" class="cursor-pointer"/>
        </label>

        <a href="{{ route('home') }}" class="text-primary font-bold text-lg font-alfa">
            Byblos
        </a>
    </x-slot:brand>


    <ul class="hidden lg:flex items-center gap-6 font-medium text-sm ml-10">
        <li><a href="{{ route('home') }}" class="hover:text-primary">Home</a></li>
        <li><a href="#" class="hover:text-primary">Investor Digest</a></li>
        <li><a href="#" class="hover:text-primary">The Tranches</a></li>
        <li><a wire:navigate.hover href="{{ route('feed.index') }}" class="hover:text-primary">VC Newsletter
                Aggregator</a></li>
        <li><a wire:navigate.hover href="{{ route('vc.directory') }}" class="hover:text-primary">VC Directory</a></li>
        <li><a href="" class="hover:text-primary">Resources</a></li>
        <li><a href="" class="hover:text-primary">Contact</a></li>
        <li><a href="" class="hover:text-primary">About</a></li>
    </ul>

    {{-- ACTIONS --}}
    <x-slot:actions>

        <x-button label="Feed" icon="o-rss"
                  link="{{ route('feed.index') }}"
                  class="btn-ghost btn-sm" responsive/>

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
            <x-menu-item link="{{ route('logout') }}" title="Logout" icon="o-arrow-right-start-on-rectangle"/>
        </x-dropdown>

    </x-slot:actions>

</x-nav>
