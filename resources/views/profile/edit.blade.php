<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">Profile Settings</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Manage your account information and security</p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="card p-6 sm:p-8">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="card p-6 sm:p-8">
                @include('profile.partials.update-password-form')
            </div>

            <div class="card p-6 sm:p-8 border-red-200/60 dark:border-red-500/20">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
