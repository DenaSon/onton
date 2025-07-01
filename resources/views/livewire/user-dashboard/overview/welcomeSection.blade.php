<div>



{{--    <x-alert--}}
{{--        icon="o-light-bulb"--}}
{{--        title="Free Trial"--}}
{{--        description=" Start your 30-day free trial to access full newsletter features."--}}
{{--        color="info"--}}
{{--        soft--}}
{{--        shadow--}}
{{--        dismissible--}}
{{--        horizontal--}}
{{--        class="group border border-error/20 hover:shadow-lg transition duration-300 backdrop-blur-sm bg-warning bg-blend-soft-light"--}}
{{--    >--}}

{{--        <div--}}
{{--            class="absolute inset-0 z-0 bg-gradient-to-r from-info/10 to-info/5 blur-xl opacity-50 group-hover:opacity-80 transition duration-500 rounded-xl"></div>--}}

{{--        <x-slot:actions>--}}
{{--            <div class="flex gap-2 z-10">--}}
{{--                <x-button--}}
{{--                    label="Upgrade Now"--}}
{{--                    class="btn-sm btn-soft font-semibold shadow-sm hover:shadow-md hover:scale-105 transition duration-200"--}}
{{--                />--}}
{{--            </div>--}}
{{--        </x-slot:actions>--}}
{{--    </x-alert>--}}




    <x-alert
        icon="o-information-circle"
        title="Free Trial"
        description="You're currently on a Free Trial. Enjoy full access for 10 more days!"
        color="info"
        soft
        shadow
        dismissible
        horizontal
        class="group border border-info/20 hover:shadow-lg transition duration-300 backdrop-blur-sm"
    >

        <div
            class="absolute inset-0 z-0 bg-gradient-to-r from-info/10 to-info/5 blur-xl opacity-50 group-hover:opacity-80 transition duration-500 rounded-xl"></div>

        <x-slot:actions>
            <div class="flex gap-2 z-10">
                <x-button
                    label="Upgrade Now"
                    class="btn-xs btn-info font-semibold shadow-sm hover:shadow-md hover:scale-105 transition duration-200"
                />
            </div>
        </x-slot:actions>
    </x-alert>

</div>
