<?php
include('../includes/header.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../includes/db.php');

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $photo_url = $_POST['photo_url'];

    $query = "INSERT INTO users (name, email, password, photo_url) VALUES ('$name', '$email', '$password', '$photo_url')";
    if (mysqli_query($conn, $query)) {
        echo "<script>window.location = 'login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<form method="POST" class="max-w-md mx-auto bg-white p-8 shadow-lg rounded-md mt-20">
    <h2 class="text-2xl font-bold mb-4">Register</h2>
    <input type="text" name="name" placeholder="Name" class="block w-full mb-4 p-2 border rounded-md">
    <input type="email" name="email" placeholder="Email" class="block w-full mb-4 p-2 border rounded-md">
    <input type="password" name="password" placeholder="Password" class="block w-full mb-4 p-2 border rounded-md">
    <input type="url" name="photo_url" placeholder="Photo URL" class="block w-full mb-4 p-2 border rounded-md">
    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md">Register</button>
</form>