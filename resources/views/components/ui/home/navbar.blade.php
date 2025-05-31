<!-- Sticky navbar wrapper -->
<div class="sticky top-0 z-50 bg-base-100 shadow-lg">
    <div class="container mx-auto">
        <div class="navbar">
            <div class="navbar-start">
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
                <a class="btn btn-ghost text-xl">ONTON Radar</a>
            </div>

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

            <div class="navbar-end">
                @auth
                    <x-button class="btn-primary" label="Dashboard" icon="o-squares-2x2"/>
                @endauth
                @guest
                    <x-button class="btn-primary" label="Sign Up" icon="o-user-plus"/>
                @endguest
            </div>
        </div>
    </div>
</div>

