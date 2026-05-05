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
        <div>
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-input-custom" placeholder="Min. 8 characters" required>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>
        <div>
            <label for="password_confirmation" class="form-label">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-input-custom" placeholder="••••••••" required>
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
