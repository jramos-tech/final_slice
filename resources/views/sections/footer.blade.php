<footer class="bg-gray-800 text-white py-4 mt-6">
    <div class="container mx-auto text-center">
        <p class="text-sm">&copy; <?php echo date("Y"); ?> RPG Website. All rights reserved.</p>
        <p class="text-sm mt-2">
            <a href="{{ route('characters.index') }}" class="text-blue-400 hover:text-blue-300">Home</a> |
            <a href="{{ route('account') }}" class="text-blue-400 hover:text-blue-300">Account</a> |
            <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300">Login/Register</a>
        </p>
    </div>
</footer>
</body>
</html>