 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chirper</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="flex gap-4 items-center">
                    <a href="/" class="font-bold text-xl">Chirper</a>
                    <a href="{{ route('chirps.trash') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 underline bg-gray-200 px-3 py-1 rounded">🗑️ Trash</a>
                </div>
                <span class="">{{ auth()->user()->name ?? '' }}</span>
            </div>
        </nav>
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>