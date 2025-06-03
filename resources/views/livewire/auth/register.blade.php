<x-form wire:submit="register" class="{{ $class }}">
    <x-hr/>
    <x-input label="Name" wire:model.defer="name" placeholder="Your full name" icon="o-user"/>

    <x-input label="Email" type="email" wire:model.defer="email" placeholder="Email address" icon="o-envelope"/>

    <x-password label="Password" wire:model="password" placeholder="Password" right/>

    <div class="card-actions justify-between items-center pt-2">
        <x-button label="Register" class="btn-primary w-full" type="submit" spinner="register"/>
    </div>


    <div class="text-center text-sm pt-4 text-base-content/70">
        Already have an account?
        <a wire:navigate.hover href="{{ route('login') }}" class="link link-primary link-hover font-semibold">Sign In</a>
    </div>

</x-form>




