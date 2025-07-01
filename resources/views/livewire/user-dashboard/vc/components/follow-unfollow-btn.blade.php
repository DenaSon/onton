<div>
    @if ($isFollowing)
        <x-button
            icon="o-eye-slash"
            label="Unfollow"
            wire:click="toggleFollow"
            spinner
            class="btn-sm btn-outline btn-error hover:bg-error hover:text-white transition-transform transform hover:scale-105"
        />
    @else
        <x-button
            icon="o-eye"
            label="Follow"
            wire:click="toggleFollow"
            spinner
            class="btn-sm btn-outline btn-primary hover:bg-primary hover:text-white transition-transform transform hover:scale-105"
        />
    @endif
</div>
