<div class="contents">
    <x-button
        spinner
        wire:click.debounce.150ms="subscribe"
        class="{{ $class ?? '' }}"
        label="{{ $label ?? '' }}"
        icon="{{ $icon ?? '' }}"
    />
</div>




