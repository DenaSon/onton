<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Mary\Traits\Toast;

class PricePlan extends Component
{
    use Toast;
    public $planId;
    public ?string $label;
    public $labelClass;

    public ?string $title;

    public ?string $price;

    public ?string $per;

    public function saveNewsletterEmail(): void
    {
        $this->success(
            'Plan <u>updated</u>',
            'Avtive ONTON Radar Plan  : <strong> Successfully </strong>',
            position: 'bottom-end',
            icon: 'o-heart',
            css: 'bg-primary text-base-100'
        );
    }

    public function render()
    {
        return view('livewire.home.price-plan');
    }
}
