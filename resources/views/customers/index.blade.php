<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Customer Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-medium mb-4" style="color: #f3f4f6;">Customer List</h3>

                {{-- Top Bar: Add Button + Search + Export PDF --}}
                <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('customers.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 transition"
                           id="btn-add-customer">
                            Add Customer
                        </a>

                        <a href="{{ route('customers.exportPdf', ['search' => $search]) }}" 
                           class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 transition"
                           id="btn-export-pdf">
                            📄 Export PDF
                        </a>
                    </div>

                    <form method="GET" action="{{ route('customers.index') }}" class="flex items-center gap-2" id="search-form">
                        <input type="text" 
                               name="search" 
                               value="{{ $search }}" 
                               placeholder="Search customers..." 
                               class="px-3 py-2 border border-gray-600 rounded bg-gray-700 text-gray-200 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                               style="min-width: 200px;"
                               id="search-input">
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded hover:bg-blue-700 transition"
                                id="btn-search">
                            Search
                        </button>
                        @if($search)
                            <a href="{{ route('customers.index') }}" 
                               class="px-3 py-2 bg-gray-600 text-gray-200 text-sm rounded hover:bg-gray-500 transition"
                               id="btn-clear-search">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-500/20 border border-green-500 text-green-400 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Table --}}
                <div style="width: 100%; overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; background-color: #1f2937;">
                        <thead>
                            <tr style="border-bottom: 2px solid #374151; background-color: #e5e7eb;">
                                <th style="text-align: left !important; padding: 12px 15px; font-size: 12px; color: #111827; font-weight: 700; text-transform: uppercase;">ID</th>
                                <th style="text-align: left !important; padding: 12px 15px; font-size: 12px; color: #111827; font-weight: 700; text-transform: uppercase;">Name</th>
                                <th style="text-align: left !important; padding: 12px 15px; font-size: 12px; color: #111827; font-weight: 700; text-transform: uppercase;">Address</th>
                                <th style="text-align: left !important; padding: 12px 15px; font-size: 12px; color: #111827; font-weight: 700; text-transform: uppercase;">Gender</th>
                                <th style="text-align: left !important; padding: 12px 15px; font-size: 12px; color: #111827; font-weight: 700; text-transform: uppercase;">DOB</th>
                                <th style="text-align: center !important; padding: 12px 15px; font-size: 12px; color: #111827; font-weight: 700; text-transform: uppercase;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                            <tr style="border-bottom: 1px solid #374151;">
                                <td style="text-align: left !important; padding: 12px 15px; color: #9ca3af; font-weight: bold;">{{ $customer->id }}</td>
                                <td style="text-align: left !important; padding: 12px 15px; color: #e5e7eb;">{{ $customer->name }}</td>
                                <td style="text-align: left !important; padding: 12px 15px; color: #9ca3af; font-style: italic;">{{ $customer->address }}</td>
                                <td style="text-align: left !important; padding: 12px 15px; color: #e5e7eb;">{{ $customer->gender }}</td>
                                <td style="text-align: left !important; padding: 12px 15px; color: #e5e7eb;">{{ $customer->dob }}</td>
                                <td style="text-align: center !important; padding: 12px 15px; white-space: nowrap;">
                                    <a href="{{ route('customers.edit', $customer->id) }}" 
                                       style="display: inline-block; padding: 5px 15px; background-color: #22c55e; color: white; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: 600; margin-right: 5px;">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display: inline;">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" 
                                                style="padding: 5px 15px; background-color: #ef4444; color: white; border-radius: 4px; border: none; cursor: pointer; font-size: 13px; font-weight: 600;" 
                                                onclick="return confirm('Confirm deletion?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 30px; color: #9ca3af; font-style: italic;">
                                    No customers found{{ $search ? ' matching "' . $search . '"' : '' }}.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Footer --}}
                @if($customers->total() > 0)
                <div class="flex flex-wrap items-center justify-between mt-4 gap-3">
                    <div style="color: #9ca3af; font-size: 14px;">
                        Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} results
                    </div>
                    <div>
                        {{ $customers->links() }}
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>