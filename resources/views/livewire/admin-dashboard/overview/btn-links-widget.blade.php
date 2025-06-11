<div class="flex flex-wrap gap-2">
    <x-button  link="{{ route('core.vc-firms.index') }}"  class="btn btn-xs btn-primary">
        <x-heroicon-o-plus class="w-4 h-4 mr-1"/>
        Manage VCs

    </x-button>
    <x-button link="{{ route('core.users.index') }}" class="btn btn-xs btn-secondary">
        <x-heroicon-o-user-group class="w-4 h-4 mr-1"/>
        Manage Users
    </x-button>
    <x-button link="{{ route('core.analysis.overview') }}" class="btn btn-xs btn-accent">
        <x-heroicon-o-chart-bar class="w-4 h-4 mr-1"/>
        View Analytics
    </x-button>
    <a href="https://dashboard.stripe.com" target="_blank" class="btn btn-xs btn-outline">
        <x-heroicon-o-link class="w-4 h-4 mr-1"/>
        Stripe Dashboard
    </a>
</div>
