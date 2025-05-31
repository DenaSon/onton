<?php

namespace App\View\Components\ui\home;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    public array $mainMenuItems;

    public function __construct()
    {
        $this->mainMenuItems = [
            ['title' => 'Home', 'route' => route('home'), 'icon' => 'o-home','class' => 'font-bold'],
            ['title' => 'Features', 'route' => '#1'],
            ['title' => 'Pricing', 'route' => '#2'],
            ['title' => 'About Us', 'route' => '#3'],
            ['title' => 'Contact Us', 'route' => '#4'],
            ['title' => 'FAQ', 'route' => '#5'],
            ['title' => 'Blog', 'route' => '#6'],
            ['title' => 'Terms of Service', 'route' => '#'],
            ['title' => 'Privacy Policy', 'route' => '#'],
        ];
    }

    public function render(): View|Closure|string
    {
        return view('components.ui.home.navbar', [
            'mainMenuItems' => $this->mainMenuItems,
        ]);
    }
}
