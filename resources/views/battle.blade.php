<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPG Battle!</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="container mx-auto mt-10 bg-gray-100 p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Battle!</h1>
    <div class="flex justify-end mb-6">
        <a href="{{ route('characters.index') }}" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 shadow-md">
            Back to Characters
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($characters as $character)
            <div class="bg-white p-4 rounded shadow-md hover:shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700">{{ $character->class_name }} <span class="text-sm text-gray-500">({{ $character->rarity }})</span></h2>
                <p class="text-gray-600 mt-2">{{ $character->description }}</p>
                <a href="{{ route('characters.show', $character->id) }}" class="text-blue-500 hover:underline mt-4 block">
                    View Details
                </a>
            </div>
        @endforeach
    </div>
    <div class="mt-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Battle Results</h2>
        @if ($battleResults)
            <p class="text-green-600 mb-2">Winner: {{ $battleResults['winner'] }}</p>
            <p class="text-gray-700 mb-2">Loser: {{ $battleResults['loser'] }}</p>
</body>

</html>