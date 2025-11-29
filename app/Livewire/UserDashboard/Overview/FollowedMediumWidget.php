<?php

namespace App\Livewire\UserDashboard\Overview;

use App\Models\Newsletter;
use Livewire\Component;

class FollowedMediumWidget extends Component
{
    public function render()
    {
        $user = auth()->user();


        $followedVcIds = $user->followedVCs()->pluck('vcs.id');


        $mediumUpdates = Newsletter::query()
            ->whereIn('vc_id', $followedVcIds)
            ->where('from_email', 'like', '%medium%')   // مثلاً xxx@medium.com
            ->with('vc:id,name')
            ->select('id', 'subject', 'from_email', 'received_at', 'vc_id')
            ->orderByDesc('received_at')
            ->limit(12)
            ->get();

        return view('livewire.user-dashboard.overview.followed-medium-widget', [
            'mediumUpdates' => $mediumUpdates,
        ]);
    }
}
