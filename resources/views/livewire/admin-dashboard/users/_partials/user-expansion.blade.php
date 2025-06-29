<table class="table w-full shadow-md rounded-box table-zebra">
    <thead class="font-semibold">
    <tr>
        <th>Subscription</th>
        <th>Plan</th>
        <th>Start Date</th>
        <th>Ends At</th>
        <th>Trial</th>
        <th>Last Payment</th>
        <th>Stripe Status</th>
    </tr>
    </thead>
    <tbody>
    @php
        /** @var Subscription|null $subscription */
        use App\Models\Cashier\Subscription;$subscription = $user->subscription('default');
    @endphp
    <tr class="hover:bg-base-100 border-t border-base-300">
        <td>{{ $subscription && $subscription->active() ? 'Yes' : 'No' }}</td>
        <td>{{ $subscription?->stripe_price ?? 'N/A' }}</td>
        <td>{{ $subscription?->created_at?->toDateString() ?? '—' }}</td>
        <td>{{ $subscription?->ends_at?->toDateString() ?? '—' }}</td>
        <td>{{ $subscription?->isTrialing() ? 'Yes' : 'No' }}</td>
        <td>{{ $subscription?->nextBillingDate()?->toDateString() ?? '—' }}</td>
        <td class="capitalize">{{ $subscription?->getStatusLabel() ?? 'N/A' }}</td>
    </tr>
    </tbody>
</table>

