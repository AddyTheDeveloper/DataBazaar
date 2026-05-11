<!DOCTYPE html>
<html lang="en" x-data :class="{ 'dark': $store.darkMode.on }">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 — DataBazaar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 dark:bg-slate-950 transition-colors">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="text-center max-w-md">
            <div class="w-20 h-20 rounded-2xl bg-primary-50 dark:bg-primary-500/10 flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-primary-500 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h1 class="text-7xl font-extrabold gradient-text">404</h1>
            <p class="text-xl font-semibold text-slate-800 dark:text-slate-200 mt-4">Page Not Found</p>
            <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm leading-relaxed">The page you're looking for doesn't exist or has been moved to a different location.</p>
            <div class="mt-8 flex items-center justify-center gap-3">
                <a href="/" class="btn-primary">← Back to Home</a>
                <button onclick="history.back()" class="btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
</body>
</html>
