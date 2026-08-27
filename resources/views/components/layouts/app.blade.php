@props(['title' => 'cc-practice'])
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-100 text-gray-900">
        <div class="min-h-screen">
            <nav class="bg-white shadow">
                <div class="max-w-4xl mx-auto px-4 py-4">
                    <a href="{{ route('daily-reports.index') }}" class="font-semibold text-gray-800 hover:text-gray-600">
                        日報一覧
                    </a>
                </div>
            </nav>

            <main class="max-w-4xl mx-auto px-4 py-8">
                @if (session('status'))
                    <div class="mb-6 rounded-md bg-green-50 border border-green-200 px-4 py-3 text-green-800">
                        {{ session('status') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
