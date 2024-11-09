<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <title>Biye Korbo</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="bg-gray-900 shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="text-white font-bold text-2xl">
                    <a href="index.php" class="hover:text-gray-300 transition">Biye <span class="text-purple-500">Korbo</span></a>
                </div>

                <!-- Menu Links -->
                <div class="hidden md:flex space-x-8 text-white">
                    <a href="index.php" class="hover:text-purple-400 transition">Home</a>
                    <a href="biodatas.php" class="hover:text-purple-400 transition">Biodatas</a>
                    <a href="matchMaking.php" class="hover:text-purple-400 transition">Match Making</a>
                    <a href="about.php" class="hover:text-purple-400 transition">About Us</a>
                    <!-- <a href="contact.php" class="hover:text-purple-400 transition">Contact Us</a> -->
                </div>

                <!--Login/Logout-->
                <div class="space-x-4">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="dashboard.php" class="btn btn-outline btn-info">Dashboard</a>
                        <a href="logout.php" class="btn btn-outline btn-error">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="md:hidden flex justify-between items-center bg-gray-800 p-4">
            <div class="text-white font-bold text-lg">
                <a href="index.php" class="hover:text-gray-300 transition">Biye Korbo</a>
            </div>
            <div>
                <label for="menu-toggle" class="cursor-pointer">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </label>
                <input type="checkbox" id="menu-toggle" class="hidden">
                <div id="menu" class="hidden">
                    <ul class="space-y-2 mt-4">
                        <li><a href="index.php" class="block text-white hover:text-gray-300">Home</a></li>
                        <li><a href="biodatas.php" class="block text-white hover:text-gray-300">Biodatas</a></li>
                        <li><a href="about.php" class="block text-white hover:text-gray-300">About Us</a></li>
                        <!-- <li><a href="contact.php" class="block text-white hover:text-gray-300">Contact Us</a></li> -->
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li><a href="dashboard.php" class="block text-white hover:text-gray-300">Dashboard</a></li>
                            <li><a href="logout.php" class="block text-white hover:text-gray-300">Logout</a></li>
                        <?php else: ?>
                            <li><a href="login.php" class="block text-white hover:text-gray-300">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>