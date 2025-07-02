<x-nav sticky>

    <x-slot:brand>
        {{-- Drawer toggle for "main-drawer" --}}
        <label for="main-drawer" class="lg:hidden mr-3">
            <x-icon name="o-bars-3" class="cursor-pointer"/>
        </label>

        {{-- Brand --}}
        <div class="text-primary font-bold text-sm font-sans">Byblos</div>
    </x-slot:brand>

    {{-- Right side actions --}}
    <x-slot:actions>

        <x-button label="Feed" icon="o-rss" link="{{ route('panel.feed.index') }}" class="btn-ghost btn-sm" responsive/>
        <x-button label="VC List" icon="o-inbox-stack" link="###" class="btn-ghost btn-sm" responsive/>


        <label>|</label>
        <x-theme-toggle/>

        <x-dropdown icon="o-user" class="btn-circle">

            <x-menu-item title="Dashboard" link="{{ route('panel.index') }}" icon="o-squares-2x2"/>

            <x-menu-item title="My Profile" link="#" icon="o-user"/>

            <x-menu-item title="Settings" link="#" icon="o-cog-6-tooth"/>

            <x-menu-separator/>

            <x-menu-item title="Help Center" link="#" icon="o-question-mark-circle"/>


            <x-menu-separator/>

            <x-menu-item link="{{ route('logout') }}" title="Logout"
                         icon="o-arrow-right-start-on-rectangle"/>

        </x-dropdown>


    </x-slot:actions>
</x-nav>
