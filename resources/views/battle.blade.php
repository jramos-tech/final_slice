<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPG Battle Arena</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@include('sections.header')
<body class="container mx-auto mt-10 bg-gray-100 p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Battle Arena</h1>
    <div class="flex justify-end mb-6">
        <a href="{{ route('characters.index') }}" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 shadow-md">
            Back to Characters
        </a>
    </div>

    <form action="{{ route('characters.battle.fight') }}" method="POST" class="mb-6 bg-white p-6 rounded-lg shadow-md">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="character1_id" class="block text-gray-700 font-semibold mb-2">Select Character 1:</label>
                <select name="character1_id" id="character1_id" class="w-full border-gray-300 rounded p-2">
                    @foreach ($characters as $character)
                        <option value="{{ $character->id }}">{{ $character->class_name }} (Power: {{ $character->power_level }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="character2_id" class="block text-gray-700 font-semibold mb-2">Select Character 2:</label>
                <select name="character2_id" id="character2_id" class="w-full border-gray-300 rounded p-2">
                    @foreach ($characters as $character)
                        <option value="{{ $character->id }}">{{ $character->class_name }} (Power: {{ $character->power_level }})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="mt-4 bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 shadow-md font-bold">
            Start Battle
        </button>
    </form>

    @if (session('battleResults'))
        <div class="mt-6 bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Battle Results</h2>
            
            @php
                $battleResults = session('battleResults');
                $isTie = isset($battleResults['is_tie']) && $battleResults['is_tie'] === true;
            @endphp
            
            @if($isTie)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 mb-4">
                    <p class="text-xl font-bold text-yellow-700">{{ $battleResults['winner'] }}</p>
                    <p class="text-gray-600">Both characters had equal power levels of {{ $battleResults['character1_power'] }}!</p>
                </div>
                
                <div class="flex justify-between mt-4">
                    <div class="bg-gray-100 p-4 rounded-lg flex-1 mr-2">
                        <h3 class="font-bold text-lg">{{ $battleResults['character1_name'] }}</h3>
                        <p>Power: {{ $battleResults['character1_power'] }}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg flex-1 ml-2">
                        <h3 class="font-bold text-lg">{{ $battleResults['character2_name'] }}</h3>
                        <p>Power: {{ $battleResults['character2_power'] }}</p>
                    </div>
                </div>
            @else
                <div class="bg-green-100 border-l-4 border-green-500 p-4 mb-4">
                    <p class="text-xl font-bold text-green-700">Winner: {{ $battleResults['winner'] }}</p>
                </div>
                
                <div class="bg-red-100 border-l-4 border-red-500 p-4 mb-4">
                    <p class="text-xl font-bold text-red-700">Defeated: {{ $battleResults['loser'] }}</p>
                </div>
                
                <div class="flex justify-between mt-4">
                    <div class="bg-gray-100 p-4 rounded-lg flex-1 mr-2">
                        <h3 class="font-bold text-lg">{{ $battleResults['character1_name'] }}</h3>
                        <p>Power: {{ $battleResults['character1_power'] }}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg flex-1 ml-2">
                        <h3 class="font-bold text-lg">{{ $battleResults['character2_name'] }}</h3>
                        <p>Power: {{ $battleResults['character2_power'] }}</p>
                    </div>
                </div>
            @endif
        </div>
    @endif
</body>
@include('sections.footer')

</html>