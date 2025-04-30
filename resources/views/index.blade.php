<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Character List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@include('sections.header')
<body class="container mx-auto mt-10 bg-gray-100 p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Character List</h1>
    <div class="flex justify-end mb-6">
        <a href="{{ route('characters.create') }}" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 shadow-md">
            Create New Character
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
</body>
@include('sections.footer')
</html>