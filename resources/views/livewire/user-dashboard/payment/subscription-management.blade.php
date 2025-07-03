<div>
    @php
        $cardShadow = $subscription && $subscription->valid() ? 'shadow-green-400' : 'shadow-primary';
    @endphp

    <x-card separator title="Subscription Overview" class="shadow-lg rounded-2xl mt-6 {{ $cardShadow }}">

        @if ($errors->has('rate_limit'))
            <x-alert icon="o-exclamation-triangle" type="error" description="{{ $errors->first('rate_limit') }}"
                     title="Slow down"/>
        @endif
        @if($subscription)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6"  wire:init="loadStripeSubscriptionData">
                <x-stat
                    title="Plan"
                    value="{{ $planName }}"
                    icon="o-check"
                    color="text-primary"
                    tooltip="Current subscription plan"
                />

                <x-stat
                    title="Status"
                    value="{{ $subscription->stripe_status ?? ($onTrial ? 'Trialing' : 'Inactive') }}"
                    icon="o-shield-check"
                    color="text-info"
                />

                <x-stat
                    title="Trial Ends"
                    value="{{ $trialEndsAt?->format('M d, Y') ?? '—' }}"
                    icon="o-clock"
                    color="text-warning"
                />

                <x-stat
                    title="Next Billing Date"
                    value="{{ $nextBillingDate?->format('M d, Y') ?? '...' }}"
                    icon="o-calendar-days"
                    color="text-accent"
                />
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="text-sm text-base-content/70">
                    Stripe Price ID: <code
                        class="bg-base-200 px-2 py-1 rounded">{{ $subscription->stripe_price ?? '—' }}</code>
                </div>

                <div class="flex gap-2">
                    @if($subscription->onGracePeriod())
                        <x-button spinner wire:click.debounce.250ms="resumeSubscription" label="Resume"
                                  icon="o-arrow-path" class="btn-success btn-sm"/>
                    @elseif($subscription->valid())
                        <x-button
                            wire:confirm="Are you sure you want to cancel your subscription? You will lose access to premium features."
                            wire:click.debounce.250ms="cancelSubscription"
                            label="Cancel Subscription"
                            icon="o-x-circle"
                            class="btn-error btn-sm"
                            spinner
                        />
                    @endif
                </div>
            </div>
        @else
            <div class="text-center py-10 text-gray-500">
                <span class="mb-4 text-gray-500">You currently have no active subscription.</span><br/>
                @livewire('components.payment.subscribe-button',['label' => 'Start Trial','class' => 'btn-xl btn-info mt-6','icon'=>'o-credit-card'])

            </div>
        @endif

        @if($subscription?->onGracePeriod())
            <x-hr/>
            <div class="text-warning">
                Your subscription will end on {{ $subscription->ends_at->format('M d, Y') }}.
            </div>
        @endif

    </x-card>


    <x-card title="Billing History" class="mt-8 rounded-2xl shadow-lg" wire:init="loadInvoices">
        @if($invoices === [])
            {{-- Loading state --}}
            <div class="text-center py-6 text-gray-400 animate-pulse">

                <span class="loading loading-dots loading-xs"></span>
                <span class="loading loading-dots loading-sm"></span>
                <span class="loading loading-dots loading-md"></span>
                <span class="loading loading-dots loading-lg"></span>
                <span class="loading loading-dots loading-xl"></span>

            </div>
        @elseif(empty($invoices))
            {{-- Loaded but empty --}}
            <div class="text-center text-gray-500 py-8">
                You don’t have any invoices yet.
            </div>
        @else
            {{-- Invoices List --}}
            <ul class="divide-y divide-base-200">
                @foreach($invoices as $invoice)
                    <li class="py-4 flex items-center justify-between">
                        <div>
                            <div class="font-medium text-base-content">
                                {{ $invoice['total'] }}
                            </div>
                            <div class="text-sm text-base-content/60">
                                Issued on {{ $invoice['date'] }}
                            </div>
                        </div>

                        <a
                            href="{{ $invoice['url'] }}"
                            target="_blank"
                            class="btn btn-sm btn-outline btn-primary"
                        >
                            View PDF
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </x-card>

</div>
