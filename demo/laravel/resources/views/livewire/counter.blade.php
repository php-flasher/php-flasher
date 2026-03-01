<div class="flex items-center justify-center space-x-4">
    <button wire:click="decrement"
            class="w-12 h-12 bg-rose-500 hover:bg-rose-600 text-white rounded-full flex items-center justify-center text-2xl font-bold transition-colors">
        -
    </button>

    <div class="w-24 h-24 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center">
        <span class="text-4xl font-bold text-white">{{ $count }}</span>
    </div>

    <button wire:click="increment"
            class="w-12 h-12 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full flex items-center justify-center text-2xl font-bold transition-colors">
        +
    </button>
</div>

<div class="flex justify-center mt-4">
    <button wire:click="reset"
            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-medium transition-colors">
        Reset
    </button>
</div>
