<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
@include('sections.header')
<body class="container mx-auto mt-10 bg-gray-100 p-6">
    <div class="flex justify-center items-center h-screen">
        <div class="w-full max-w-md bg-white p-8 rounded shadow-md">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h2>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Login</button>
            </form>
            <p class="text-center text-gray-600 mt-4">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register</a>
            </p>
        </div>
    </div>
</body>
@include('sections.footer')
</html>