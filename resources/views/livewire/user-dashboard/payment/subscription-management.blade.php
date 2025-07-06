<div>
    @php
        $cardShadow = ($subscription && $subscription->valid()) ? 'shadow-green-400' : 'shadow-primary';
        $showBillingHistory = $subscription && ($subscription->valid() || $subscription->onTrial());
    @endphp

    <x-card progress-indicator separator title="Subscription Overview"
            class="shadow rounded-2xl mt-6 {{ $cardShadow }}">
        @if ($errors->has('rate_limit'))
            <x-alert icon="o-exclamation-triangle" type="error" description="{{ $errors->first('rate_limit') }}"
                     title="Slow down"/>
        @endif

        @if($subscription)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6" wire:init="loadStripeSubscriptionData">
                <x-stat
                    title="Plan Price"
                    value="{{ $planPrice ? $planPrice . ' ' . $planCurrency : '—' }}"
                    icon="o-currency-dollar"
                    color="text-success"
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
                    Status:
                    <span class="font-semibold">
        {{ ucfirst($subscription->stripe_status ?? 'inactive') }}
    </span>
                    <small class="block text-xs text-gray-400">
                        @if($subscription->onGracePeriod())
                            Subscription canceled — ends {{ $subscription->ends_at?->format('M d, Y') }}
                            ({{ $subscription->ends_at?->diffForHumans() }})
                        @elseif($subscription->onTrial())
                            Trial ends on {{ $subscription->trial_ends_at?->format('M d, Y') }}
                            ({{ $subscription->trial_ends_at?->diffForHumans() }})
                        @else
                            Active subscription — started {{ $subscription->created_at->format('M d, Y') }}
                            ({{ $subscription->created_at->diffForHumans() }})
                        @endif
                    </small>
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


    </x-card>

    @if($showBillingHistory)
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
    @endif

</div>
