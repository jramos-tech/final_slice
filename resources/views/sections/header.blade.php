<?php
$websiteName = "RPG Website";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $websiteName; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="flex justify-between items-center mb-6 p-4 bg-gray-300 shadow-md">
        <a href="{{ route('characters.index') }}" class="text-gray-700 hover:text-gray-900">Home</a>

        <h1 class="text-xl font-bold text-gray-800">{{ $websiteName }}</h1>

        @if (session('user_id'))
            <a href="{{ route('account') }}"
                class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600 shadow-md">
                Account ({{ session('user_name') }})
            </a>
        @else
            <a href="{{ route('login') }}"
                class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 shadow-md">
                Login/Register
            </a>
        @endif
    </div>
</body>