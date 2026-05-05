<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Bulk Upload</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Import market data from a CSV file</p>
    </x-slot>
    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card p-8">
                <form method="POST" action="{{ route('market-data.upload') }}" enctype="multipart/form-data" class="space-y-6" x-data="formSubmit" @submit="submit">
                    @csrf
                    <div x-data="{ fileName: '' }" class="border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl p-10 text-center hover:border-primary-300 dark:hover:border-primary-600 transition-colors cursor-pointer" @click="$refs.fileInput.click()">
                        <svg class="w-10 h-10 text-slate-300 dark:text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        <p class="text-sm text-slate-600 dark:text-slate-400"><span class="text-primary-600 dark:text-primary-400 font-semibold">Click to upload</span> or drag and drop</p>
                        <p class="text-xs text-slate-400 mt-1.5" x-text="fileName || 'CSV file, max 2MB'"></p>
                        <input type="file" name="csv_file" x-ref="fileInput" @change="fileName = $event.target.files[0]?.name" accept=".csv,.txt" class="hidden">
                    </div>
                    @error('csv_file')<p class="text-xs text-red-600">{{ $message }}</p>@enderror

                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-5">
                        <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">Required CSV format</h4>
                        <code class="text-xs text-slate-600 dark:text-slate-400 block bg-white dark:bg-slate-800 rounded-lg p-4 font-mono border border-slate-200/60 dark:border-slate-700/50">product_name,price,category,location,date<br>Tomatoes,45.00,Vegetables,Mumbai,2024-01-15</code>
                        <p class="text-xs text-slate-500 mt-3">Category names must match existing categories exactly.</p>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('market-data.index') }}" class="btn-secondary">Cancel</a>
                        <button type="submit" class="btn-primary" :disabled="submitting" :class="{ 'opacity-75 cursor-wait': submitting }">
                            <svg x-show="submitting" class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                            <span x-show="!submitting">Upload & Import</span>
                            <span x-show="submitting" x-cloak>Uploading...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
