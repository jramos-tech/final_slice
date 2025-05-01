<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="container mx-auto mt-10 bg-gray-100 p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Account</h1>

    <div class="mb-6">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 shadow-md">
                Logout
            </button>
        </form>
    </div>

    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Your Characters</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($characters as $character)
            <div class="bg-white p-4 rounded shadow-md hover:shadow-lg">
                <h3 class="text-xl font-semibold text-gray-700">{{ $character->class_name }}</h3>
                <p class="text-gray-600 mt-2">{{ $character->description }}</p>
                <form action="{{ route('characters.delete', $character->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 shadow-md">
                        Delete
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</body>
</html>