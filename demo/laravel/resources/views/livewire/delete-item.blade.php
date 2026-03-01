<div class="flex flex-col items-center space-y-4">
    <div class="flex items-center space-x-4">
        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
        <div>
            <h4 class="font-semibold text-gray-800">Important Document.pdf</h4>
            <p class="text-sm text-gray-500">2.4 MB - Modified today</p>
        </div>
    </div>

    <button wire:click="confirmDelete"
            class="px-6 py-2 bg-rose-600 hover:bg-rose-700 text-white font-medium rounded-lg transition-colors flex items-center space-x-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
        </svg>
        <span>Delete File</span>
    </button>
</div>
