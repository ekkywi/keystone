<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield("title", "Console") - {{ config("app.name", "Keystone") }}</title>

    @vite(["resources/css/app.css", "resources/js/app.js"])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        div:where(.swal2-container) div:where(.swal2-popup) {
            border-radius: 1rem !important;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
            padding: 2rem !important;
        }

        div:where(.swal2-container) button:focus {
            box-shadow: none !important;
        }
    </style>

    @stack("styles")
</head>

<body class="font-sans text-slate-900 antialiased bg-white">

    @yield("content")

    @stack("scripts")

</body>

</html>
