<div class="flex items-center justify-center min-h-screen bg-base-200 px-4">
    <div class="bg-white dark:bg-base-100 shadow-2xl rounded-2xl p-8 max-w-md w-full text-center">

        <div class="flex justify-center mb-4">
            <x-icon name="o-x-circle" class="text-error w-16 h-16"/>
        </div>


        <h2 class="text-2xl font-bold text-error mb-2">Trial Activation Failed</h2>


        <p class="text-gray-600 dark:text-gray-300 mb-4">
            Unfortunately, your trial could not be activated.<br>
            No payment was made and your card has not been charged.
        </p>


        <div class="text-sm text-gray-500 dark:text-gray-400 mb-6">
            This might be due to an invalid card, canceled checkout, or a connection issue.
        </div>


        <div class="flex flex-col gap-2">
            @livewire('components.payment.subscribe-button',['class' => 'btn btn-info btn-outline w-full','label' => ' Try Again'])
            <a href="{{ route('panel.index') }}" class="btn btn-outline w-full">
                Back to Dashboard
            </a>
{{--            <a href="" class="btn btn-ghost text-sm">--}}
{{--                Contact Support--}}
{{--            </a>--}}
        </div>
    </div>
</div>
