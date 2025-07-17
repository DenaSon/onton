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
        title="Feed"
        icon="o-rss"
        link="{{ route('panel.feed.index') }}"
    />

    <x-menu-sub title="Settings" icon="o-cog-6-tooth">
        <x-menu-item
            title="Account Settings"
            icon="o-user"
            link="{{ route('panel.profile.edit') }}"
        />
        <x-menu-item
            title="Delivery Setting"
            icon="o-bell-alert"
            link="{{ route('panel.setting.delivery') }}"
        />
    </x-menu-sub>

    <x-menu-sub title="Subscription" icon="o-credit-card">
        <x-menu-item
            title="My Plan"
            icon="o-receipt-percent"
            link="{{ route('panel.payment.management') }}"
        />

    </x-menu-sub>

<x-menu-separator/>
    <x-menu-item
        separator
        title="Help"
        icon="o-question-mark-circle"
        link="{{ route('panel.help.index') }}"
    />

</x-menu>
