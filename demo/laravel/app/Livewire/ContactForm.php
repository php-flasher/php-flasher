<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $message = '';

    protected array $rules = [
        'name' => 'required|min:2',
        'email' => 'required|email',
        'message' => 'required|min:10',
    ];

    public function submit(): void
    {
        $this->validate();

        // Simulate form processing
        flash()->success('Message sent successfully!');
        flash()->info('We will respond within 24 hours.');

        $this->reset(['name', 'email', 'message']);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
