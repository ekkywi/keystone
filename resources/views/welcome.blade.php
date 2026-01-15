<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Keystone Setup</title>

    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>

<body class="bg-slate-900 text-white flex items-center justify-center h-screen font-sans">

    <div class="text-center space-y-4">
        <h1 class="text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-indigo-500">
            Keystone IDP
        </h1>
        <p class="text-slate-400 text-lg">
            Running on <span class="font-mono text-cyan-400">Laravel 12</span> & <span class="font-mono text-indigo-400">Tailwind v4</span>
        </p>
        <div class="inline-block px-4 py-2 bg-slate-800 rounded-lg border border-slate-700 font-mono text-xs">
            System Status: ONLINE
        </div>
    </div>

</body>

</html>
