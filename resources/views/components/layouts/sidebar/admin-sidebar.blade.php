<x-menu activate-by-route active-bg-color="font-semibold text-primary">

    <x-menu-item title="Dashboard" icon="o-chart-pie" link="{{ route('core.index') }}" exact/>

    <x-menu-sub title="Users" icon="o-users">
        <x-menu-item title="All Users" icon="o-user-circle" link="{{ route('core.users.index') }}"/>
        <x-menu-item title="Suspended Users" icon="o-user-minus"
                     link="{{ route('core.users.index',['filter' => 'suspended']) }}"/>
    </x-menu-sub>

    <x-menu-sub title="VC Firms" icon="o-circle-stack">
        <x-menu-item title="All VC Firms" icon="o-rectangle-group" link="{{ route('core.vc-firms.index') }}"/>
        <x-menu-item title="Add New VC" icon="o-plus-circle" link="{{ route('core.vc-firms.create') }}"/>
    </x-menu-sub>

    <x-menu-sub title="Crawler" icon="o-globe-alt">
        <x-menu-item title="Newsletters" icon="o-newspaper" link="{{ route('core.newsletters.index') }}"/>
        {{--        <x-menu-item title="Job Status" icon="o-play-circle" link="#" />--}}
        {{--        <x-menu-item title="Error Logs" icon="o-exclamation-triangle" link="" />--}}
    </x-menu-sub>

    {{--    <x-menu-sub title="Notifications" icon="o-bell">--}}
    {{--        <x-menu-item title="Notification Log" icon="o-list-bullet" link="#" />--}}
    {{--        <x-menu-item title="Send Notification" icon="o-paper-airplane" link="#" />--}}
    {{--    </x-menu-sub>--}}

    <x-menu-sub title="System Monitoring" icon="o-cpu-chip">
        <x-menu-item title="SystemPulse" icon="o-computer-desktop" link="{{ url('/pulse') }}" external/>
        <x-menu-item title="Activity Logs" icon="o-clipboard-document-list" link="{{ route('core.activity-logs') }}"/>
    </x-menu-sub>

    <x-menu-sub title="Analytics" icon="o-chart-bar">
        <x-menu-item title="Overview" icon="o-chart-pie" link="{{ route('core.analysis.overview') }}"/>

    </x-menu-sub>

    <x-menu-item title="Documentation" icon="o-book-open" link="{{ route('core.docs.index') }}"/>

    <x-menu-item
        title="Logout"
        icon="o-arrow-left-on-rectangle"
        x-data
        x-on:click.prevent="
        if (confirm('Are you sure you want to log out?')) {
            window.location.href = '{{ route('logout') }}';
        }
    "
        href="#"
    />

</x-menu>
