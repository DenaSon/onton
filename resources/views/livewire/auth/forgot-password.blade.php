
<x-form method="POST" class="{{ $class }}" wire:submit="sendResetLink">
    <x-hr/>
    <x-input
        label="Email"
        type="email"
        wire:model="email"
        placeholder="Enter your email address"
        icon="o-envelope"
        autofocus
    />


    <div class="card-actions justify-between items-center pt-2">
        <x-button spinner="sendResetLink" label="Send Reset Link" class="btn-primary w-full" type="submit"/>
    </div>


    <div class="text-center text-sm pt-4 text-base-content/70">
        Remember your password?
        <a wire:navigate href="{{ route('login') }}" class="link link-primary link-hover font-semibold">
            Back to Login
        </a>
    </div>



</x-form>
