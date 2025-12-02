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
            ['title' => 'Home', 'route' => 'https://www.byblos.digital/', 'external' => true],
            ['title' => 'Investor Digest', 'route' => 'https://www.byblos.digital/s/investor-digest', 'external' => true],
            ['title' => 'The Tranches', 'route' => 'https://www.byblos.digital/s/the-tranches', 'external' => true],

            // Internal Laravel routes
            ['title' => 'VC Newsletter Aggregator', 'route' => route('feed.index'), 'external' => false],
            ['title' => 'VC Directory', 'route' => route('vc.directory'), 'external' => false],

            ['title' => 'Resources', 'route' => 'https://www.byblos.digital/s/resources', 'external' => true],
            ['title' => 'Contact', 'route' => 'https://www.byblos.digital/p/contact', 'external' => true],
            ['title' => 'About', 'route' => 'https://www.byblos.digital/about', 'external' => true],
        ];

        return view('components.ui.home.navbar', [
            'mainMenuItems' => $mainMenuItems,
        ]);
    }


}
