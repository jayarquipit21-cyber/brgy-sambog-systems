@php use App\Services\HolidaysService; @endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>National Holidays — Brgy. Sambog</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100">
    <div class="max-w-4xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-extrabold font-outfit mb-4">Upcoming National Holidays</h1>
        <p class="text-sm text-zinc-600 mb-6">These dates are observed nationally and appointments are closed by default on these days.</p>

        <div class="space-y-3">
            @if(isset($holidays) && count($holidays))
                @foreach($holidays as $h)
                    <div class="p-4 bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-zinc-500">{{ \Illuminate\Support\Carbon::parse($h['date'])->format('M d, Y') }}</div>
                                <div class="font-bold text-zinc-900 dark:text-white">{{ $h['name'] }}</div>
                            </div>
                            <div class="text-xs text-zinc-400">National Holiday</div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="p-4 bg-white dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-800 text-sm text-zinc-500">No upcoming national holidays found.</div>
            @endif
        </div>

        <div class="mt-6">
            <a href="{{ route('home') }}" class="text-sm text-brand hover:underline">Back to homepage</a>
        </div>
    </div>
</body>
</html>