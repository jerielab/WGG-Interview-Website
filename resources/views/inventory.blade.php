@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <div class="mb-8 flex flex-col items-center text-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Inventory Dashboard</h1>
            <p class="text-slate-500">Manage your seasonal stock and monitor inventory levels.</p>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-slate-500">Total Items</span>
                <div class="p-2 bg-emerald-50 rounded-lg">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-slate-900">{{ $items->count() }}</div>
            <div class="mt-1 text-xs text-emerald-600 font-medium flex items-center">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                </svg>
                12% from last month
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-slate-500">Total Stock</span>
                <div class="p-2 bg-blue-50 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-slate-900">{{ $items->sum('stock_quantity') }}</div>
            <p class="mt-1 text-xs text-slate-400">Total units in warehouse</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-slate-500">Low Stock Items</span>
                <div class="p-2 bg-amber-50 rounded-lg">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-slate-900">{{ $items->where('stock_quantity', '<=', 10)->where('stock_quantity', '>', 0)->count() }}</div>
            <p class="mt-1 text-xs text-amber-600 font-medium italic">Requires attention</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-slate-500">Out of Stock</span>
                <div class="p-2 bg-red-50 rounded-lg">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-slate-900">{{ $items->where('stock_quantity', 0)->count() }}</div>
            <p class="mt-1 text-xs text-red-600 font-medium italic">Restock immediately</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-12 gap-8 items-start">
        <!-- Add Item Form -->
        <section class="lg:col-span-4 bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden sticky top-24 h-fit">
            <div class="p-6 border-b border-slate-100 bg-emerald-50/30">
                <h2 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add New Item
                </h2>
            </div>

            <div class="p-6">
                <form action="{{ route('items.store') }}" method="POST" class="space-y-5" id="create-form">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Item Name</label>
                        <input
                            type="text"
                            name="name"
                            placeholder="e.g. Winter Jacket"
                            class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 text-base py-3 px-4 transition-all placeholder:text-slate-400 shadow-sm"
                            required
                        >
                        @error('name')
                            <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-sm font-semibold text-slate-700">Initial Stock</label>
                            <span id="create-stock-status" class="text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded-md bg-slate-100 text-slate-500">
                                Unknown
                            </span>
                        </div>
                        <input
                            type="number"
                            min="0"
                            name="stock_quantity"
                            id="create-stock-quantity"
                            placeholder="0"
                            class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 text-base py-3 px-4 transition-all shadow-sm"
                            required
                        >
                        @error('stock_quantity')
                            <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Season Category</label>
                        <select
                            name="category"
                            class="w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 text-base py-3 px-4 transition-all shadow-sm"
                            required
                        >
                            <option value="" disabled selected>Select a season</option>
                            <option value="Spring">🌸 Spring</option>
                            <option value="Summer">☀️ Summer</option>
                            <option value="Autumn">🍂 Autumn</option>
                            <option value="Winter">❄️ Winter</option>
                            <option value="Unspecified">🌍 Unspecified</option>
                        </select>
                        @error('category')
                            <p class="text-xs text-red-600 mt-1.5 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button
                        type="submit"
                        class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl bg-emerald-600 text-white text-sm font-bold hover:bg-emerald-700 transition-all shadow-md shadow-emerald-200 active:scale-[0.98]"
                    >
                        Create Item
                    </button>
                </form>
            </div>
        </section>

        <!-- Inventory List -->
        <section class="lg:col-span-8 bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 bg-emerald-50/30 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-slate-900">Current Stock</h2>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-md">
                        {{ $items->count() }} Total Items
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-[11px] uppercase tracking-wider text-slate-400 font-bold">
                            <th class="px-6 py-4">Item Details</th>
                            <th class="px-6 py-4 text-center">Stock Level</th>
                            <th class="px-6 py-4 text-center">Category</th>
                            <th class="px-6 py-4 text-right whitespace-nowrap">Quick Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($items as $item)
                            <tr class="group hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <form action="{{ route('items.update', $item) }}" method="POST" id="edit-form-{{ $item->id }}" class="flex flex-col gap-1">
                                        @csrf
                                        @method('PUT')
                                        <input
                                            type="text"
                                            name="name"
                                            value="{{ $item->name }}"
                                            class="p-0 border-0 bg-transparent focus:ring-0 font-semibold text-slate-900 w-full hover:bg-white hover:shadow-sm rounded transition-all focus:bg-white focus:px-2"
                                            required
                                        >
                                        <span class="text-xs text-slate-400 italic">Last updated: {{ $item->updated_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="flex items-center bg-slate-100 rounded-xl p-1 border border-slate-200 shadow-inner">
                                            <button 
                                                type="button"
                                                onclick="this.parentNode.querySelector('input').stepDown(); this.parentNode.querySelector('input').dispatchEvent(new Event('input'))"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-emerald-600 hover:border-emerald-200 transition-all active:scale-90 shadow-sm"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4" />
                                                </svg>
                                            </button>
                                            
                                            <input
                                                type="number"
                                                min="0"
                                                name="stock_quantity"
                                                value="{{ $item->stock_quantity }}"
                                                class="w-12 border-0 bg-transparent text-center focus:ring-0 font-bold text-slate-900 text-base [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none edit-stock-quantity"
                                                data-status-target="status-pill-{{ $item->id }}"
                                                required
                                            >
                                            
                                            <button 
                                                type="button"
                                                onclick="this.parentNode.querySelector('input').stepUp(); this.parentNode.querySelector('input').dispatchEvent(new Event('input'))"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-600 hover:text-emerald-600 hover:border-emerald-200 transition-all active:scale-90 shadow-sm"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        @php
                                            $status = $item->stock_status;
                                            $statusClasses = match ($status) {
                                                'Out of Stock' => 'bg-red-50 text-red-700 ring-1 ring-red-200',
                                                'Low Stock'    => 'bg-amber-50 text-amber-700 ring-1 ring-amber-200',
                                                default        => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                            };
                                        @endphp
                                        <span
                                            id="status-pill-{{ $item->id }}"
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-tight {{ $statusClasses }}"
                                        >
                                            {{ $status }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <select
                                        name="category"
                                        class="text-xs rounded-lg border-slate-200 bg-slate-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all py-1 pl-2 pr-8"
                                        required
                                    >
                                        <option value="Spring" {{ $item->category === 'Spring' ? 'selected' : '' }}>🌸 Spring</option>
                                        <option value="Summer" {{ $item->category === 'Summer' ? 'selected' : '' }}>☀️ Summer</option>
                                        <option value="Autumn" {{ $item->category === 'Autumn' ? 'selected' : '' }}>🍂 Autumn</option>
                                        <option value="Winter" {{ $item->category === 'Winter' ? 'selected' : '' }}>❄️ Winter</option>
                                        <option value="Unspecified" {{ $item->category === 'Unspecified' ? 'selected' : '' }}>🌍 Unspecified</option>
                                    </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            form="edit-form-{{ $item->id }}"
                                            type="submit"
                                            class="p-2 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-emerald-600 hover:border-emerald-200 hover:bg-emerald-50 transition-all shadow-sm"
                                            title="Save Changes"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>

                                        <form
                                            action="{{ route('items.destroy', $item) }}"
                                            method="POST"
                                            onsubmit="return confirm('Remove this item from inventory?');"
                                            class="inline"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="p-2 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all shadow-sm"
                                                title="Delete Item"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="h-full">
                                <td colspan="4" class="px-6 py-12 text-center h-full align-middle">
                                    <div class="flex flex-col items-center justify-center gap-3 h-full min-h-[250px]">
                                        <div class="p-4 bg-emerald-50 rounded-full">
                                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <p class="text-slate-500 font-medium">No items in inventory yet.</p>
                                        <p class="text-slate-400 text-xs">Start by adding your first product using the form.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <script>
        function computeStockStatus(quantity) {
            const value = parseInt(quantity, 10);

            if (isNaN(value)) {
                return { label: 'Unknown', classes: 'bg-slate-50 text-slate-500 ring-1 ring-slate-200' };
            }

            if (value === 0) {
                return { label: 'Out of Stock', classes: 'bg-red-50 text-red-700 ring-1 ring-red-200' };
            }

            if (value <= 10) {
                return { label: 'Low Stock', classes: 'bg-amber-50 text-amber-700 ring-1 ring-amber-200' };
            }

            return { label: 'In Stock', classes: 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' };
        }

        const createQuantityInput = document.getElementById('create-stock-quantity');
        const createStatusSpan = document.getElementById('create-stock-status');

        if (createQuantityInput && createStatusSpan) {
            const updateCreateStatus = () => {
                const { label, classes } = computeStockStatus(createQuantityInput.value);
                createStatusSpan.textContent = label;
                createStatusSpan.className = 'text-[10px] uppercase tracking-wider font-bold px-2 py-0.5 rounded-md ' + classes;
            };

            createQuantityInput.addEventListener('input', updateCreateStatus);
        }

        document.querySelectorAll('.edit-stock-quantity').forEach((input) => {
            input.addEventListener('input', () => {
                const targetId = input.getAttribute('data-status-target');
                const pill = document.getElementById(targetId);

                if (!pill) {
                    return;
                }

                const { label, classes } = computeStockStatus(input.value);
                pill.textContent = label;
                pill.className = 'inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-tight ' + classes;
            });
        });
    </script>
@endsection