<!DOCTYPE html>
<html lang="en" x-data="{ dark: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': dark }">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — DataBazaar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-slate-50 dark:bg-slate-950 transition-colors">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="text-center max-w-md">
            <div class="w-20 h-20 rounded-2xl bg-red-50 dark:bg-red-500/10 flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-red-500 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            </div>
            <h1 class="text-7xl font-extrabold gradient-text">403</h1>
            <p class="text-xl font-semibold text-slate-800 dark:text-slate-200 mt-4">Access Denied</p>
            <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm leading-relaxed">You don't have permission to access this resource. Please contact an administrator if you believe this is an error.</p>
            <div class="mt-8 flex items-center justify-center gap-3">
                <a href="/" class="btn-primary">← Back to Home</a>
                <button onclick="history.back()" class="btn-secondary">Go Back</button>
            </div>
        </div>
    </div>
</body>
</html>
