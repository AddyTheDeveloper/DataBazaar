<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Welcome back</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1.5">Sign in to your DataBazaar account</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input-custom" placeholder="you@example.com" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-input-custom" placeholder="••••••••" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded-md border-slate-300 dark:border-slate-600 text-primary-600 focus:ring-primary-500/20 dark:bg-slate-800" name="remember">
                <span class="text-sm text-slate-600 dark:text-slate-400">Remember me</span>
            </label>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-700 dark:text-primary-400 font-medium">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="btn-primary w-full justify-center py-3">Sign In</button>

        <p class="text-center text-sm text-slate-500 dark:text-slate-400">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 font-semibold">Create one</a>
        </p>
    </form>
</x-guest-layout>
