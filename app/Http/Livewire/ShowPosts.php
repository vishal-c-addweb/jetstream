<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowPosts extends Component
{
    public function render()
    {
        return <<<'blade'
            <div>
                 <livewire:counter />
            </div>
        blade;
    }
}
