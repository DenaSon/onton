<x-form wire:submit="login" class="{{ $class }}">
    <x-hr/>

    <x-input
        label="Email"
        type="email"
        wire:model.defer="email"
        placeholder="Email address"
        icon="o-envelope"
    />

    <x-password
        label="Password"
        wire:model="password"
        placeholder="Password"
        right
    />


    <fieldset class="fieldset bg-base-100 border-base-300 rounded-box w-64 border p-4">
        <legend class="fieldset-legend">Login options</legend>
        <label class="label">
            <input wire:model="remember" type="checkbox" checked="checked" class="checkbox checkbox-primary"/>
            Remember me
        </label>
    </fieldset>


    <div class="card-actions justify-between items-center pt-4">
        <x-button label="Login" class="btn-primary w-full" type="submit" spinner="login"/>
    </div>

    <div class="text-center text-sm pt-2 text-base-content/70">
        <a wire:navigate href="{{ route('password.request') }}" class="link link-primary link-hover font-semibold">
            Forgot your password?
        </a>
    </div>

    <div class="text-center text-sm pt-4 text-base-content/70">
        Don’t have an account?
        <a wire:navigate href="{{ route('register') }}" class="link link-primary link-hover font-semibold">
            Sign Up
        </a>
    </div>
</x-form>
