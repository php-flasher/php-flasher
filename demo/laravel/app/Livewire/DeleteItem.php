<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;

class DeleteItem extends Component
{
    protected $listeners = [
        'sweetalert:confirmed' => 'onConfirmed',
        'sweetalert:denied' => 'onDenied',
    ];

    public function confirmDelete(): void
    {
        sweetalert()
            ->showDenyButton()
            ->showCancelButton()
            ->confirmButtonText('Yes, delete it!')
            ->denyButtonText('Keep it')
            ->warning('Are you sure you want to delete this item?');
    }

    public function onConfirmed(array $payload): void
    {
        // Simulate deletion
        flash()->success('Item has been deleted successfully!');
    }

    public function onDenied(array $payload): void
    {
        flash()->info('The item was kept safe.');
    }

    public function render()
    {
        return view('livewire.delete-item');
    }
}
