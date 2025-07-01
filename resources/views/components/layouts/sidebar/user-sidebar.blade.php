<x-menu activate-by-route>
    <x-menu-item
        separator
        title="Dashboard"
        icon="o-chart-pie"
        link="{{ route('panel.index') }}"
    />

    <x-menu-item

                 title="VC Directory"
                 icon="o-inbox-stack"
                 link="{{ route('panel.vc.directory') }}"
    />

    <x-menu-item
                 title="Bookmarks"
                 icon="o-bookmark"
                 link="#"
    />

    <x-menu-sub title="Settings" icon="o-cog-6-tooth">
        <x-menu-item
            title="Account Settings"
            icon="o-user-circle"
            link="#"
        />
        <x-menu-item
            title="Notification Preferences"
            icon="o-bell-alert"
            link="#"
        />
    </x-menu-sub>

    <x-menu-sub title="Subscription" icon="o-credit-card">
        <x-menu-item
            title="My Plan"
            icon="o-receipt-percent"
            link="#"
        />
        <x-menu-item
            title="Payment Success"
            icon="o-check-circle"
            link="#"
        />
        <x-menu-item
            title="Payment Failed"
            icon="o-x-circle"
            link="#"
        />
        <x-menu-item
            title="Invoices"
            icon="o-document-text"
            link="#"
        />
    </x-menu-sub>
</x-menu>
