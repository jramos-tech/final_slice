<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Character List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        async function fetchSortedCharacters(sortField, sortOrder) {
            try {
                const apiUrl = `{{ route('api.characters') }}?sort=${sortField}&order=${sortOrder}`;
                const response = await fetch(apiUrl);
                if (!response.ok) {
                    throw new Error('Failed to fetch characters');
                }
                const characters = await response.json();
                updateCharacterList(characters);
            } catch (error) {
                console.error(error);
                alert('An error occurred while fetching characters.');
            }
        }

        function updateCharacterList(characters) {
            const characterGrid = document.getElementById('character-grid');
            characterGrid.innerHTML = '';

            characters.forEach(character => {
                const characterCard = `
                    <div class="bg-white p-4 rounded shadow-md hover:shadow-lg flex flex-col md:flex-row">
                        <!-- Image Section -->
                        <div class="md:w-1/3 flex justify-center items-center mb-4 md:mb-0 md:mr-4">
                            ${
                                character.image
                                    ? `<img src="${character.image}" alt="${character.class_name}" class="rounded shadow-md w-full h-auto">`
                                    : `<p class="text-gray-500 italic">No image available</p>`
                            }
                        </div>
                        <!-- Text Section -->
                        <div class="md:w-2/3">
                            <h2 class="text-xl font-semibold text-gray-700">${character.class_name} 
                                <span class="text-sm text-gray-500">(${character.rarity})</span>
                            </h2>
                            <p class="text-gray-600 mt-2">${character.description}</p>
                            <p class="text-gray-500 text-sm mt-2">
                                Created by: <strong>${character.user?.username || 'Unknown'}</strong>
                            </p>
                            <a href="{{ route('characters.show', '') }}/${character.id}" class="text-blue-500 hover:underline mt-4 block">
                                View Details
                            </a>
                        </div>
                    </div>
                `;
                characterGrid.innerHTML += characterCard;
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchSortedCharacters('class_name', 'asc');
        });
    </script>
</head>
@include('sections.header')

<body class="container mx-auto mt-10 bg-gray-100 p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Character List</h1>
    <div class="flex justify-end mb-6">
        @if (session('user_id'))
            <a href="{{ route('characters.create') }}"
                class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 shadow-md">
                Create New Character
            </a>
            <a href="{{ route('characters.battle') }}"
                class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 shadow-md">
                Start a battle
            </a>
        @endif
    </div>
    <!-- Sorting Controls -->
    <div class="flex justify-center mb-6">
        <label for="sortField" class="mr-2 text-gray-700 font-medium">Sort by:</label>
        <select id="sortField" class="border rounded px-4 py-2 mr-4">
            <option value="class_name">Name</option>
            <option value="power_level">Power Level</option>
            <option value="battles_won">Wins</option>
            <option value="rarity">Rarity</option>
        </select>
        <label for="sortOrder" class="mr-2 text-gray-700 font-medium">Order:</label>
        <select id="sortOrder" class="border rounded px-4 py-2">
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select>
        <button
            onclick="fetchSortedCharacters(document.getElementById('sortField').value, document.getElementById('sortOrder').value)"
            class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 shadow-md ml-4">
            Sort
        </button>
    </div>

    <!-- Character Grid -->
    <div id="character-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    </div>
</body>
@include('sections.footer')

</html>