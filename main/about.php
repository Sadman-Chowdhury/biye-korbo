<?php
include '../includes/header.php';
?>

<div class="container mx-auto mt-10 max-w-6xl px-6">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-5xl font-bold text-center text-purple-600 mb-6">About Us</h1>
        <p class="text-lg text-gray-700 leading-relaxed mb-6">
            Welcome to <span class="text-purple-500 font-semibold">Biye Korbo</span>, where we believe that finding your perfect life partner is a journey worth cherishing. Our mission is to provide a secure, reliable, and seamless platform to connect individuals seeking meaningful relationships and lifelong companionship. With a user-friendly interface and advanced matchmaking algorithms, we strive to bring people closer and turn dreams of a happy union into reality.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Vision Section -->
            <div class="flex flex-col items-center text-center">
                <img src="../assets/images/vision.svg" alt="Vision" class="w-24 mb-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Our Vision</h2>
                <p class="text-gray-600">
                    To be the most trusted and respected matrimony platform, bringing together people with shared values, cultures, and aspirations.
                </p>
            </div>

            <!-- Mission Section -->
            <div class="flex flex-col items-center text-center">
                <img src="../assets/images/mission.svg" alt="Mission" class="w-24 mb-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Our Mission</h2>
                <p class="text-gray-600">
                    To provide a platform that connects hearts and fosters meaningful relationships, creating lasting bonds and happy families.
                </p>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-gray-50 mt-10 p-8 rounded-lg shadow-lg">
        <h2 class="text-4xl font-bold text-center text-purple-600 mb-6">Why Choose Us?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="text-center">
                <img src="../assets/images/safe.svg" alt="Safety" class="w-16 mx-auto mb-4">
                <h3 class="text-xl font-bold text-gray-800">Safe & Secure</h3>
                <p class="text-gray-600">
                    Your privacy is our priority. We ensure your data is protected and interactions are secure.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="text-center">
                <img src="../assets/images/matchmaking.svg" alt="Matchmaking" class="w-16 mx-auto mb-4">
                <h3 class="text-xl font-bold text-gray-800">Advanced Matchmaking</h3>
                <p class="text-gray-600">
                    Using intelligent algorithms, we help you find partners that align with your preferences and values.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="text-center">
                <img src="../assets/images/support.svg" alt="Support" class="w-16 mx-auto mb-4">
                <h3 class="text-xl font-bold text-gray-800">Dedicated Support</h3>
                <p class="text-gray-600">
                    Our friendly support team is always here to assist you on your journey to find true love.
                </p>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="bg-white mt-10 p-8 rounded-lg shadow-lg">
        <h2 class="text-4xl font-bold text-center text-purple-600 mb-6">Meet Our Team</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Team Member 1 -->
            <div class="text-center">
                <img src="../assets/images/team1.jpg" alt="Team Member" class="w-32 h-32 object-cover rounded-full mx-auto mb-4">
                <h3 class="text-xl font-bold text-gray-800">John Doe</h3>
                <p class="text-gray-600">Founder & CEO</p>
            </div>

            <!-- Team Member 2 -->
            <div class="text-center">
                <img src="../assets/images/team2.jpg" alt="Team Member" class="w-32 h-32 object-cover rounded-full mx-auto mb-4">
                <h3 class="text-xl font-bold text-gray-800">Jane Smith</h3>
                <p class="text-gray-600">Lead Developer</p>
            </div>

            <!-- Team Member 3 -->
            <div class="text-center">
                <img src="../assets/images/team3.jpg" alt="Team Member" class="w-32 h-32 object-cover rounded-full mx-auto mb-4">
                <h3 class="text-xl font-bold text-gray-800">Ahmed Khan</h3>
                <p class="text-gray-600">Customer Success Manager</p>
            </div>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>