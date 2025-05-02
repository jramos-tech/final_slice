<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Character</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function previewImage() {
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('image-preview');

            imageInput.addEventListener('input', () => {
                const imageUrl = imageInput.value;
                if (imageUrl) {
                    imagePreview.src = imageUrl;
                    imagePreview.style.display = 'block';
                } else {
                    imagePreview.style.display = 'none';
                }
            });

            // Set initial preview image if it exists
            const initialImageUrl = imageInput.value;
            if (initialImageUrl) {
                imagePreview.src = initialImageUrl;
                imagePreview.style.display = 'block';
            }
        }

        document.addEventListener('DOMContentLoaded', previewImage);
    </script>
</head>
@include('sections.header')
<body class="container mx-auto mt-10 bg-gray-100 p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Edit {{ $character->class_name }}</h1>
    <form method="POST" action="{{ route('characters.update', $character->id) }}" class="bg-white p-6 rounded shadow-md max-w-lg mx-auto">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="class_name" class="block text-gray-700 font-bold mb-2">Class Name</label>
            <input type="text" name="class_name" id="class_name" value="{{ $character->class_name }}" class="w-full border border-gray-300 rounded px-3 py-2" />
            @error('class_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
            <textarea name="description" id="description" rows="5" class="w-full border border-gray-300 rounded px-3 py-2">{{ $character->description }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="abilities" class="block text-gray-700 font-bold mb-2">Abilities</label>
            <textarea name="abilities" id="abilities" rows="5" class="w-full border border-gray-300 rounded px-3 py-2">{{ $character->abilities }}</textarea>
            @error('abilities')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="rarity" class="block text-gray-700 font-bold mb-2">Rarity</label>
            <select name="rarity" id="rarity" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="Common" {{ $character->rarity == 'Common' ? 'selected' : '' }}>Common</option>
                <option value="Uncommon" {{ $character->rarity == 'Uncommon' ? 'selected' : '' }}>Uncommon</option>
                <option value="Rare" {{ $character->rarity == 'Rare' ? 'selected' : '' }}>Rare</option>
                <option value="Epic" {{ $character->rarity == 'Epic' ? 'selected' : '' }}>Epic</option>
                <option value="Legendary" {{ $character->rarity == 'Legendary' ? 'selected' : '' }}>Legendary</option>
            </select>
            @error('rarity')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4 flex items-start">
            <div class="w-2/3">
                <label for="image" class="block text-gray-700 font-bold mb-2">Image Link</label>
                <input type="url" name="image" id="image" value="{{ $character->image }}" class="w-full border border-gray-300 rounded px-3 py-2" placeholder="https://example.com/image.jpg" />
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="w-1/3 ml-4">
                <img id="image-preview" src="{{ $character->image }}" alt="Image Preview" class="w-full h-auto rounded shadow-md" style="display: none;" />
            </div>
        </div>

        <div class="mb-4">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Edit Skills</h2>
            @foreach ($character->skills as $index => $skill)
                <div class="mb-4">
                    <label for="skills[{{ $index }}][name]" class="block text-gray-700 font-bold mb-2">Skill Name</label>
                    <input type="text" name="skills[{{ $index }}][name]" id="skills[{{ $index }}][name]" value="{{ $skill->name }}" class="w-full border border-gray-300 rounded px-3 py-2" />
                    <label for="skills[{{ $index }}][description]" class="block text-gray-700 font-bold mb-2 mt-4">Description</label>
                    <textarea name="skills[{{ $index }}][description]" id="skills[{{ $index }}][description]" class="w-full border border-gray-300 rounded px-3 py-2">{{ $skill->description }}</textarea>
                    <label for="skills[{{ $index }}][power_level]" class="block text-gray-700 font-bold mb-2 mt-4">Power Level</label>
                    <input type="number" name="skills[{{ $index }}][power_level]" id="skills[{{ $index }}][power_level]" value="{{ $skill->power_level }}" class="w-full border border-gray-300 rounded px-3 py-2" />
                </div>
            @endforeach
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Complete Edit</button>
    </form>
</body>
@include('sections.footer')

</html>