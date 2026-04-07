<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                
                <form action="{{ route('customers.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label>Full Name</label>
                        <input type="text" name="name" class="block w-full border-gray-300 dark:bg-gray-900 rounded-md shadow-sm">
                    </div>
                    
                    <div>
                        <label>Address</label>
                        <textarea name="address" class="block w-full border-gray-300 dark:bg-gray-900 rounded-md shadow-sm"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label>Gender</label>
                            <select name="gender" class="block w-full border-gray-300 dark:bg-gray-900 rounded-md shadow-sm">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div>
                            <label>Date of Birth</label>
                            <input type="date" name="dob" class="block w-full border-gray-300 dark:bg-gray-900 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Save Customer
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>