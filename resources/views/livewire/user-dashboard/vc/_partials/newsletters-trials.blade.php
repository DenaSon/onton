<!-- RIGHT SECTION -->
<div class="space-y-4">

    <div class="card bg-base-100 shadow-sm p-4">

        <!-- Header -->
        <div class="flex items-center justify-between mb-3">
            <div>
                <h2 class="text-lg font-semibold">Latest newsletters</h2>
                <p class="text-xs text-base-content/60">
                    Newsletter titles related to this VC.
                    @if(!$isPremium)
                        Full content requires a trial or subscription.
                    @endif
                </p>
            </div>

            <span class="badge badge-outline text-xs">
                {{ $isPremium ? 'Full access' : 'Public view' }}
            </span>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="table table-sm">
                <thead>
                <tr>
                    <th>Subject</th>
                    <th>Received at</th>

                </tr>
                </thead>

                <tbody>

                @if($newsletters->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center py-4 text-sm opacity-70">
                            No newsletters found for this VC.
                        </td>
                    </tr>
                @else
                    @foreach($newsletters as $item)
                        <tr class="{{ $isPremium ? '' : 'opacity-80' }}">
                            <td>{{ $item->subject }}</td>

                            <td>
                                {{ $item->received_at?->format('Y-m-d') ?? '—' }}
                            </td>


                        </tr>
                    @endforeach
                @endif

                </tbody>
            </table>
        </div>


        <!-- Pagination for premium view -->
        @if($isPremium && $newsletters instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-4">
                {{ $newsletters->links() }}
            </div>
        @endif

    </div>

</div>
