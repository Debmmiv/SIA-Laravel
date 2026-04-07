<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Customer: ') . $customer->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                
                <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-medium">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $customer->name) }}" 
                               class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium">Address</label>
                        <textarea name="address" rows="3" 
                                  class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm">{{ old('address', $customer->address) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium">Gender</label>
                            <select name="gender" class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm">
                                <option value="Male" @selected(old('gender', $customer->gender) == 'Male')>Male</option>
                                <option value="Female" @selected(old('gender', $customer->gender) == 'Female')>Female</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium">Date of Birth</label>
                            <input type="date" name="dob" value="{{ old('dob', $customer->dob) }}" 
                                   class="block w-full mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-bold transition">
                            Update Record
                        </button>
                        <a href="{{ route('customers.index') }}" class="text-sm text-gray-400 hover:underline">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>