<?php

namespace App\Livewire\UserDashboard\Overview;

use App\Models\Newsletter;
use Livewire\Component;

class FollowedSubstackWidget extends Component
{
    public function render()
    {
        $user = auth()->user();

        $followedVcIds = $user->followedVCs()->pluck('vcs.id');

        $substackNewsletters = Newsletter::query()
            ->whereIn('vc_id', $followedVcIds)
            ->where('from_email', 'like', '%substack%')
            ->with('vc:id,name')
            ->select('id', 'subject', 'from_email', 'received_at', 'vc_id')
            ->orderByDesc('received_at')
            ->limit(12)
            ->get();

        return view('livewire.user-dashboard.overview.followed-substack-widget', [
            'substackNewsletters' => $substackNewsletters,
        ]);
    }
}
