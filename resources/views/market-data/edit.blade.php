<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Edit Entry</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Update submitted market data</p>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-8">
                <form method="POST" action="{{ route('market-data.update', $marketData) }}" class="space-y-6">
                    @csrf @method('PUT')
                    <div>
                        <label for="product_name" class="form-label">Product name</label>
                        <input type="text" name="product_name" id="product_name" value="{{ old('product_name', $marketData->product_name) }}" class="form-input-custom" required>
                        @error('product_name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="price" class="form-label">Price (₹)</label>
                            <input type="number" name="price" id="price" value="{{ old('price', $marketData->price) }}" class="form-input-custom" step="0.01" min="0.01" required>
                            @error('price')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-input-custom" required>@foreach($categories as $cat)<option value="{{ $cat->id }}" {{ old('category_id',$marketData->category_id)==$cat->id?'selected':'' }}>{{ $cat->name }}</option>@endforeach</select>
                            @error('category_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" id="location" value="{{ old('location', $marketData->location) }}" class="form-input-custom" required>
                            @error('location')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" value="{{ old('date', $marketData->date->format('Y-m-d')) }}" class="form-input-custom" max="{{ now()->format('Y-m-d') }}" required>
                            @error('date')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    @if(!auth()->user()->isAdmin())
                    <div class="bg-amber-50 dark:bg-amber-500/5 border border-amber-200/60 dark:border-amber-500/10 rounded-xl p-4 flex items-start gap-3">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.072 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        <p class="text-sm text-amber-700 dark:text-amber-300">Editing will reset the entry to "Pending" for re-review.</p>
                    </div>
                    @endif
                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('market-data.index') }}" class="btn-secondary">Cancel</a>
                        <button type="submit" class="btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
