<?php

namespace App\Livewire\UserDashboard\Overview;

use App\Models\Newsletter;
use Livewire\Component;

class FollowedNewslettersWidget extends Component
{
    public function render()
    {
        $user = auth()->user();

        $newsletters = Newsletter::query()
            ->whereIn('vc_id', $user->followedVCs()->pluck('vcs.id'))
            ->with('vc:id,name')
            ->select('id', 'subject', 'from_email', 'received_at', 'vc_id')
            ->orderByDesc('received_at')
            ->limit(12)
            ->get();

        return view('livewire.user-dashboard.overview.followed-newsletters-widget', [
            'newsletters' => $newsletters,
        ]);
    }
}
