<!-- Sticky navbar wrapper -->
<div class="sticky top-0 z-50 bg-base-100 shadow-lg">
    <div class="container mx-auto">
        <div class="navbar">
            <!-- START -->
            <div class="navbar-start">
                <!-- Mobile menu dropdown -->
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                        <x-icon name="o-bars-4"/>
                    </div>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-10 mt-3 w-52 p-2 shadow">
                        {{--                        @foreach($mainMenuItems as $item)--}}
                        {{--                            <x-menu-item--}}
                        {{--                                :title="$item['title']"--}}
                        {{--                                :link="$item['route']"--}}
                        {{--                                :icon="$item['icon'] ?? null"--}}
                        {{--                                :class="$item['class'] ?? ''"--}}
                        {{--                            />--}}
                        {{--                        @endforeach--}}
                    </ul>
                </div>

                <!-- Logo -->
                <a wire:navigate href="{{ route('home') }}" class="text-center leading-tight">
                    <div class="font-alfa text-xl text-primary tracking-wide">Byblos

                    </div>
                </a>


            </div>

            <!-- CENTER -->
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1">
                    {{--                    @foreach($mainMenuItems as $item)--}}
                    {{--                        <x-menu-item--}}
                    {{--                            :title="$item['title']"--}}
                    {{--                            :link="$item['route']"--}}
                    {{--                            :icon="$item['icon'] ?? null"--}}
                    {{--                            :class="$item['class'] ?? ''"--}}
                    {{--                        />--}}
                    {{--                    @endforeach--}}
                </ul>
            </div>

            <!-- END -->
            <div class="navbar-end gap-3">

                <x-theme-toggle/>
                <label class="text-base-300">|</label>

                @guest

                    <x-button
                        link="{{ route('login') }}"
                        class="btn-outline btn-sm"

                        label="Sign In"
                    />


                    <x-button
                        link="{{ route('register') }}"
                        class="btn-primary btn-sm"

                        label="Sign Up"
                    />
                @endguest


            @auth
                    <x-dropdown label="{{ Auth::user()->firstName() ?? 'User' }}">

                        <x-menu-item title="Dashboard" link="{{ route('panel.index') }}" icon="o-squares-2x2"/>

                        <x-menu-item title="My Profile" link="{{ route('panel.profile.edit') }}" icon="o-user"/>

                        <x-menu-item title="Settings" link="{{ route('panel.setting.delivery') }}" icon="o-cog-6-tooth"/>

                        <x-menu-separator/>

                        <x-menu-item title="Help Center" link="{{ route('panel.help.index') }}" icon="o-question-mark-circle"/>


                        <x-menu-separator/>

                        <x-menu-item link="{{ route('logout') }}" title="Logout"
                                     icon="o-arrow-right-start-on-rectangle"/>

                    </x-dropdown>
                @endauth
            </div>
        </div>
    </div>
</div>
