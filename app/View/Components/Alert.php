<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Create a new component instance.
     */
    public $type;
    public $message;

    public function __construct($type = 'info')
    {
        $this->type = $type;
        $this->message = session($type);
    }

    public function render()
    {
        return view('components.alert');
    }
}
