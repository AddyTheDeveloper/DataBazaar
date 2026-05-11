<!DOCTYPE html>
<html lang="en" x-data :class="{ 'dark': $store.darkMode.on }">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 — DataBazaar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 dark:bg-slate-950 transition-colors">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="text-center max-w-md">
            <div class="w-20 h-20 rounded-2xl bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.072 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
            <h1 class="text-7xl font-extrabold gradient-text">500</h1>
            <p class="text-xl font-semibold text-slate-800 dark:text-slate-200 mt-4">Server Error</p>
            <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm leading-relaxed">Something went wrong on our end. Our team has been notified and we're working on a fix. Please try again later.</p>
            <div class="mt-8 flex items-center justify-center gap-3">
                <a href="/" class="btn-primary">← Back to Home</a>
                <button onclick="location.reload()" class="btn-secondary">Try Again</button>
            </div>
        </div>
    </div>
</body>
</html>
