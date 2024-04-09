<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class Eventous extends Component
{
    public function render()
    {
        return <<<'HTML'
            <div>
                <button wire:click="delete">delete</button>
            </div>
        HTML;
    }

    public function delete()
    {
        sweetalert()
            ->showDenyButton()
            ->info('confirm or deny action');
    }

    #[On('sweetalert:confirmed')]
    public function onSweetalertConfirmed(array $payload): void
    {
        toastr()->success('sweetalert was confirmed');
    }
}
