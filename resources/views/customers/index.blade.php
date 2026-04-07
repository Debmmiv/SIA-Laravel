<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Customer Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium" style="color: #f3f4f6;">Customer List</h3>
                    <a href="{{ route('customers.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                        + ADD NEW CUSTOMER
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-500/20 border border-green-500 text-green-400 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <div style="width: 100%; overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; background-color: #1f2937;">
                        <thead>
                            <tr style="border-bottom: 2px solid #374151;">
                                <th style="text-align: left !important; padding: 15px; font-size: 11px; color: #9ca3af; text-transform: uppercase; width: 50px;">ID</th>
                                <th style="text-align: left !important; padding: 15px; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Name</th>
                                <th style="text-align: left !important; padding: 15px; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Address</th>
                                <th style="text-align: left !important; padding: 15px; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Gender</th>
                                <th style="text-align: left !important; padding: 15px; font-size: 11px; color: #9ca3af; text-transform: uppercase;">DOB</th>
                                <th style="text-align: right !important; padding: 15px; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr style="border-bottom: 1px solid #374151;">
                                <td style="text-align: left !important; padding: 15px; color: #9ca3af; font-weight: bold;">{{ $customer->id }}</td>
                                <td style="text-align: left !important; padding: 15px; color: #e5e7eb;">{{ $customer->name }}</td>
                                <td style="text-align: left !important; padding: 15px; color: #9ca3af; font-style: italic;">{{ $customer->address }}</td>
                                <td style="text-align: left !important; padding: 15px; color: #e5e7eb;">{{ $customer->gender }}</td>
                                <td style="text-align: left !important; padding: 15px; color: #e5e7eb;">{{ $customer->dob }}</td>
                                <td style="text-align: right !important; padding: 15px; white-space: nowrap;">
                                    
                                    <a href="{{ route('customers.edit', $customer->id) }}" 
                                       style="color: #60a5fa !important; font-weight: 800; text-decoration: none; margin-right: 20px; font-size: 14px;">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display: inline;">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" 
                                                style="color: #f87171 !important; font-weight: 800; background: none; border: none; cursor: pointer; font-size: 14px;" 
                                                onclick="return confirm('Confirm deletion?')">
                                            Delete
                                        </button>
                                    </form>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>