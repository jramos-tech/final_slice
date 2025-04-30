<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Character Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="container mx-auto mt-10 bg-gray-100 p-6">
    <div class="mb-4">
        <a href="{{ route('characters.index') }}" class="text-blue-500 hover:text-blue-700">← Back to characters</a>
    </div>

    <div class="bg-white p-6 rounded shadow-md">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $character->class_name }}</h1>
        <p class="text-gray-700 mb-2"><strong>Description:</strong> {{ $character->description }}</p>
        <p class="text-gray-700 mb-2"><strong>Abilities:</strong> {{ $character->abilities }}</p>
        <p class="text-gray-700 mb-4"><strong>Rarity:</strong> {{ $character->rarity }}</p>

        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Special Skills</h2>
        <ul class="list-disc pl-6">
            @foreach ($character->skills as $skill)
                <li class="mb-4">
                    <strong class="text-gray-800">{{ $skill->name }}</strong> 
                    <span class="text-sm text-gray-600">(Power Level: {{ $skill->power_level }})</span>
                    <p class="text-gray-700">{{ $skill->description }}</p>
                </li>
            @endforeach
        </ul>
        <p class="text-gray-700 mb-4"><strong>Battles won:</strong> {{ $character->battles_won }}</p>
        <p class="text-gray-700 mb-4"><strong>Total battles:</strong> {{ $character->total_battles }}</p>
    </div>
</body>
</html>