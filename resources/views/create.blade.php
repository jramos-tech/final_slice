<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Character Class</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="container mx-auto mt-10 bg-gray-100 p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Add Character Class</h1>
    <form method="POST" action="{{ route('characters.store') }}" class="bg-white p-6 rounded shadow-md max-w-lg mx-auto">
        @csrf
        <div class="mb-4">
            <label for="class_name" class="block text-gray-700 font-bold mb-2">Class Name</label>
            <input type="text" name="class_name" id="class_name" class="w-full border border-gray-300 rounded px-3 py-2" />
            @error('class_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
            <textarea name="description" id="description" rows="5" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="abilities" class="block text-gray-700 font-bold mb-2">Abilities</label>
            <textarea name="abilities" id="abilities" rows="5" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
            @error('abilities')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="rarity" class="block text-gray-700 font-bold mb-2">Rarity</label>
            <select name="rarity" id="rarity" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="Common">Common</option>
                <option value="Uncommon">Uncommon</option>
                <option value="Rare">Rare</option>
                <option value="Epic">Epic</option>
                <option value="Legendary">Legendary</option>
            </select>
            @error('rarity')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div id="skills" class="mb-4">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Special Skills</h3>
            <div class="mb-4">
                <label for="skill_name_1" class="block text-gray-700 font-bold mb-2">Skill Name</label>
                <input type="text" name="skills[0][name]" id="skill_name_1" class="w-full border border-gray-300 rounded px-3 py-2" />
                <label for="skill_description_1" class="block text-gray-700 font-bold mb-2 mt-4">Description</label>
                <textarea name="skills[0][description]" id="skill_description_1" class="w-full border border-gray-300 rounded px-3 py-2"></textarea>
                <label for="skill_power_level_1" class="block text-gray-700 font-bold mb-2 mt-4">Power Level</label>
                <input type="number" name="skills[0][power_level]" id="skill_power_level_1" class="w-full border border-gray-300 rounded px-3 py-2" />
            </div>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Character Class</button>
    </form>
</body>

</html>