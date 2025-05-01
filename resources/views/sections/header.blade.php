<?php
$websiteName = "RPG Website";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $websiteName; ?></title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="flex justify-end mb-6">
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