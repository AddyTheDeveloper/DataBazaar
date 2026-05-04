<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Submit Market Data</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Add a new price observation</p>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-8">
                <form method="POST" action="{{ route('market-data.store') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label for="product_name" class="form-label">Product name</label>
                        <input type="text" name="product_name" id="product_name" value="{{ old('product_name') }}" class="form-input-custom" placeholder="e.g., Basmati Rice, Tomatoes" required>
                        @error('product_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="price" class="form-label">Price (₹)</label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" class="form-input-custom" placeholder="0.00" step="0.01" min="0.01" required>
                            @error('price')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-input-custom" required>
                                <option value="">Select category</option>
                                @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ old('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>@endforeach
                            </select>
                            @error('category_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="location" class="form-label">Market location</label>
                            <input type="text" name="location" id="location" value="{{ old('location') }}" class="form-input-custom" placeholder="e.g., Mumbai, Delhi" required>
                            @error('location')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="date" class="form-label">Date of observation</label>
                            <input type="date" name="date" id="date" value="{{ old('date', now()->format('Y-m-d')) }}" class="form-input-custom" max="{{ now()->format('Y-m-d') }}" required>
                            @error('date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="bg-primary-50 dark:bg-primary-500/5 border border-primary-200/60 dark:border-primary-500/10 rounded-xl p-4 flex items-start gap-3">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-sm text-primary-700 dark:text-primary-300">Your submission will be reviewed by an admin before appearing publicly.</p>
                    </div>
                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('market-data.index') }}" class="btn-secondary">Cancel</a>
                        <button type="submit" class="btn-primary">Submit Entry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
