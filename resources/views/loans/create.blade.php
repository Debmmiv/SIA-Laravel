<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Loan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                
                <form action="{{ route('loans.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium">Description</label>
                        <input type="text" name="description" value="{{ old('description') }}" class="block w-full mt-1 border-gray-300 dark:bg-gray-900 rounded-md shadow-sm">
                        @error('description') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Amount</label>
                            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" class="block w-full mt-1 border-gray-300 dark:bg-gray-900 rounded-md shadow-sm">
                            @error('amount') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Term (months)</label>
                            <input type="number" name="term" value="{{ old('term') }}" class="block w-full mt-1 border-gray-300 dark:bg-gray-900 rounded-md shadow-sm">
                            @error('term') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Interest (%)</label>
                            <input type="number" step="0.01" name="interest" value="{{ old('interest') }}" class="block w-full mt-1 border-gray-300 dark:bg-gray-900 rounded-md shadow-sm">
                            @error('interest') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Date Granted</label>
                            <input type="date" name="dategranted" value="{{ old('dategranted') }}" class="block w-full mt-1 border-gray-300 dark:bg-gray-900 rounded-md shadow-sm">
                            @error('dategranted') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Save Loan
                        </button>
                        <a href="{{ route('loans.index') }}" class="text-sm text-gray-400 hover:underline">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
