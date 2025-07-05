<div class="flex items-center justify-center min-h-screen bg-base-200 px-4">
    <div class="bg-white dark:bg-base-100 shadow-2xl rounded-2xl p-8 max-w-md w-full text-center">

        <div class="flex justify-center mb-4">
            <x-icon name="o-check-circle" class="text-success w-16 h-16" />
        </div>


        <h2 class="text-2xl font-bold text-success mb-2">Trial Activated!</h2>


        <p class="text-gray-600 dark:text-gray-300 mb-4">
            Welcome, {{ Auth::user()->name }} <br>
            Your 30-day free trial is now active.
        </p>


        <div class="text-sm text-gray-500 dark:text-gray-400 mb-6">
            <p>Email: <span class="font-semibold">{{ Auth::user()->email }}</span></p>
            <p>Trial ends on:
                <span class="font-semibold">
                    {{ Auth::user()->trialEndsAt('default')?->format('F j, Y') }}
                </span>
            </p>
            <p>Plan: <span class="font-semibold capitalize">Startup Plan</span></p>
        </div>


        <div class="flex flex-col gap-2">
            <a wire:navigate.hover href="{{ route('panel.index') }}" class="btn btn-primary w-full">
                Go to Dashboard
            </a>

            <a wire:navigate href="{{ route('panel.payment.management') }}" class="btn btn-ghost btn-outline text-sm">
                Manage Subscription
            </a>

            <a href="{{ route('panel.profile.edit') }}" class="btn btn-ghost w-full">
                Update Profile
            </a>
        </div>
    </div>
</div>
