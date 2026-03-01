<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public int $count = 0;

    public function increment(): void
    {
        $this->count++;
        flash()->success("Count increased to {$this->count}!");
    }

    public function decrement(): void
    {
        $this->count--;
        flash()->warning("Count decreased to {$this->count}");
    }

    public function reset(): void
    {
        $this->count = 0;
        flash()->info('Counter has been reset.');
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
