<?php

namespace App\Livewire\UserDashboard\Vc\Components;

use App\Models\Vc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Mary\Traits\Toast;

class FollowUnfollowBtn extends Component
{
    use Toast;
    public Vc $vc;
    public bool $isFollowing = false;

    public function mount(Vc $vc, array $followedVcIds = [])
    {
        $this->vc = $vc;
        $this->isFollowing = in_array($vc->id, $followedVcIds);
    }


    public function toggleFollow(): void
    {

        $user = auth()->user();

        $vcKey = 'follow-vc:' . $user->id . ':' . $this->vc->id;
        $globalKey = 'follow-vc:global:' . $user->id;

        if (RateLimiter::tooManyAttempts($vcKey, 5)) {
            $this->info('Too fast', 'You are toggling follow on this VC too often. Wait a few seconds.');
            return;
        }

        if (RateLimiter::tooManyAttempts($globalKey, 12)) {
            $this->warning('Rate limited', 'You are following too many VC firms too quickly. Please slow down.');
            return;
        }

        RateLimiter::hit($vcKey, 30);
        RateLimiter::hit($globalKey, 60);

        if ($this->isFollowing) {
            $user->followedVCs()->detach($this->vc->id);
            $this->isFollowing = false;
        } else {
            $user->followedVCs()->syncWithoutDetaching([$this->vc->id]);
            $this->isFollowing = true;
        }


    }


    public function render()
    {
        return view('livewire.user-dashboard.vc.components.follow-unfollow-btn');
    }
}
