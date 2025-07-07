<?php

namespace App\View\Components\Ui\Home;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Mary\Traits\Toast;
use function Laravel\Prompts\alert;

class Pricing extends Component
{

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }



    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.home.pricing');
    }
}
