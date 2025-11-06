<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $activeTab = 'todos';

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.dashboard')
            ->layout('layouts.dashboard');
    }
}
