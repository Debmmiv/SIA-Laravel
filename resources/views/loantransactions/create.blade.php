<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Loan Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                
                <form action="{{ route('loantransactions.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium">Customer</label>
                        <select name="customer_id" class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm">
                            <option value="">-- Select Customer --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Loan</label>
                        <select name="loan_id" class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm">
                            <option value="">-- Select Loan --</option>
                            @foreach($loans as $loan)
                                <option value="{{ $loan->id }}" {{ old('loan_id') == $loan->id ? 'selected' : '' }}>
                                    {{ $loan->description }} (₱{{ number_format($loan->amount, 2) }})
                                </option>
                            @endforeach
                        </select>
                        @error('loan_id') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Amount Paid</label>
                            <input type="number" step="0.01" name="amount_paid" value="{{ old('amount_paid') }}" class="block w-full mt-1 border-gray-300 dark:bg-gray-900 rounded-md shadow-sm">
                            @error('amount_paid') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Date Paid</label>
                            <input type="date" name="date_paid" value="{{ old('date_paid') }}" class="block w-full mt-1 border-gray-300 dark:bg-gray-900 rounded-md shadow-sm">
                            @error('date_paid') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Save Transaction
                        </button>
                        <a href="{{ route('loantransactions.index') }}" class="text-sm text-gray-400 hover:underline">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
