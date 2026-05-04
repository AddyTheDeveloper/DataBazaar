<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Create your account</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1.5">Start exploring market data in seconds</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
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
        <button type="submit" class="btn-primary w-full justify-center py-3">Create Account</button>
        <p class="text-center text-sm text-slate-500 dark:text-slate-400">
            Already have an account?
            <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 font-semibold">Sign in</a>
        </p>
    </form>
</x-guest-layout>
