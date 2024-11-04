<?php
include '../includes/header.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../includes/db.php');

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: dashboard.php');
    } else {
        echo "Invalid credentials!";
    }
}
?>

<form method="POST" class="max-w-md mx-auto bg-white p-8 shadow-lg rounded-md mt-20">
    <h2 class="text-2xl font-bold mb-4">Login</h2>
    <input type="email" name="email" placeholder="Email" class="block w-full mb-4 p-2 border rounded-md">
    <input type="password" name="password" placeholder="Password" class="block w-full mb-4 p-2 border rounded-md">
    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md">Login</button>

    <p class="mt-4 text-center">
        Don't have an account?
        <a href="register.php" class="text-blue-500 underline">Register here</a>
    </p>
</form>