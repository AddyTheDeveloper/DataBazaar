<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Create your account</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1.5">Start exploring market data in seconds</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5" x-data="formSubmit" @submit="submit">
        @csrf
        <div>
            <label for="name" class="form-label">Full name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-input-custom" placeholder="John Doe" required autofocus>
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>
        <div>
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input-custom" placeholder="you@example.com" required>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>
        <div x-data="{ showPassword: false }">
            <label for="password" class="form-label">Password</label>
            <div class="relative">
                <input id="password" :type="showPassword ? 'text' : 'password'" name="password" class="form-input-custom pr-10" placeholder="Min. 8 characters" required>
                <button type="button" @click="showPassword = !showPassword" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%);" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                    <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>
        <div x-data="{ showConfirmPassword: false }">
            <label for="password_confirmation" class="form-label">Confirm password</label>
            <div class="relative">
                <input id="password_confirmation" :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" class="form-input-custom pr-10" placeholder="••••••••" required>
                <button type="button" @click="showConfirmPassword = !showConfirmPassword" style="position: absolute; right: 0.75rem; top: 50%; transform: translateY(-50%);" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                    <svg x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                </button>
            </div>
        </div>
        <button type="submit" class="btn-primary w-full justify-center py-3" :disabled="submitting" :class="{ 'opacity-75 cursor-wait': submitting }">
            <svg x-show="submitting" class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
            <span x-show="!submitting">Create Account</span>
            <span x-show="submitting" x-cloak>Creating...</span>
        </button>
        <p class="text-center text-sm text-slate-500 dark:text-slate-400">
            Already have an account?
            <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 font-semibold">Sign in</a>
        </p>
    </form>
</x-guest-layout>
