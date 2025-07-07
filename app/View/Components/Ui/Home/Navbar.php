<?php

namespace App\View\Components\Ui\Home;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{


    public function __construct()
    {

    }

    public function render(): View|Closure|string
    {

        $mainMenuItems = [
            ['title' => 'Home', 'route' => route('home'),'class' => 'font-bold'],
            ['title' => 'Features', 'route' => '#1'],
            ['title' => 'About Us', 'route' => '#3'],
            ['title' => 'Contact Us', 'route' => '#4'],
            ['title' => 'FAQ', 'route' => '#5'],
            ['title' => 'Terms of Service', 'route' => '#'],
            ['title' => 'Privacy Policy', 'route' => '#'],
        ];



        return view('components.ui.home.navbar', [
            'mainMenuItems' => $mainMenuItems,
        ]);
    }
}
