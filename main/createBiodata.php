<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $profile_image = $_POST['profile_image'];
    $age = $_POST['age'];
    $occupation = $_POST['occupation'];
    $division = $_POST['division'];
    $father_name = $_POST['father_name'];
    $mother_name = $_POST['mother_name'];
    $present_division = $_POST['present_division'];
    $expected_partner_age = $_POST['expected_partner_age'];
    $expected_partner_height = $_POST['expected_partner_height'];
    $expected_partner_weight = $_POST['expected_partner_weight'];
    $contact_email = $_POST['contact_email'];
    $mobile_number = $_POST['mobile_number'];
    $religion = $_POST['religion'];
    $caste = $_POST['caste'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $education = $_POST['education'];
    $income = $_POST['income'];
    $marital_status = $_POST['marital_status'];
    $hobbies = $_POST['hobbies'];
    $family_type = $_POST['family_type'];
    $family_values = $_POST['family_values'];
    $expected_partner_religion = $_POST['expected_partner_religion'];
    $expected_partner_education = $_POST['expected_partner_education'];
    $expected_partner_income = $_POST['expected_partner_income'];
    $expected_partner_marital_status = $_POST['expected_partner_marital_status'];
    $lifestyle = $_POST['lifestyle'];

    $query = "INSERT INTO biodatas (user_id, name, profile_image, age, occupation, division, father_name, mother_name, present_division, expected_partner_age, expected_partner_height, expected_partner_weight, contact_email, mobile_number, religion, caste, height, weight, education, income, marital_status, hobbies, family_type, family_values, expected_partner_religion, expected_partner_education, expected_partner_income, expected_partner_marital_status, lifestyle) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo "Query preparation failed: " . $conn->error;
        exit();
    }

    $stmt->bind_param(
        "ississssssssssssdssssssssssss",
        $user_id,
        $name,
        $profile_image,
        $age,
        $occupation,
        $division,
        $father_name,
        $mother_name,
        $present_division,
        $expected_partner_age,
        $expected_partner_height,
        $expected_partner_weight,
        $contact_email,
        $mobile_number,
        $religion,
        $caste,
        $height,
        $weight,
        $education,
        $income,
        $marital_status,
        $hobbies,
        $family_type,
        $family_values,
        $expected_partner_religion,
        $expected_partner_education,
        $expected_partner_income,
        $expected_partner_marital_status,
        $lifestyle
    );

    $stmt->execute();

    if ($stmt->error) {
        echo "SQL Error: " . $stmt->error;
        exit();
    }

    header('Location: dashboard.php');
    exit();
}
?>

<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Create Biodata</h1>
    <form action="createBiodata.php" method="post" class="space-y-4">
        <!-- Existing fields -->
        <div><label for="name" class="block">Name</label><input type="text" id="name" name="name" class="border p-2 w-full" required></div>
        <div><label for="profile_image" class="block">Profile Image URL</label><input type="text" id="profile_image" name="profile_image" class="border p-2 w-full" required></div>
        <div><label for="age" class="block">Age</label><input type="number" id="age" name="age" class="border p-2 w-full" required></div>
        <div><label for="occupation" class="block">Occupation</label><input type="text" id="occupation" name="occupation" class="border p-2 w-full" required></div>
        <div><label for="division" class="block">Division</label><input type="text" id="division" name="division" class="border p-2 w-full"></div>
        <div><label for="father_name" class="block">Father's Name</label><input type="text" id="father_name" name="father_name" class="border p-2 w-full"></div>
        <div><label for="mother_name" class="block">Mother's Name</label><input type="text" id="mother_name" name="mother_name" class="border p-2 w-full"></div>
        <div><label for="present_division" class="block">Present Division</label><input type="text" id="present_division" name="present_division" class="border p-2 w-full"></div>
        <div><label for="expected_partner_age" class="block">Expected Partner Age</label><input type="number" id="expected_partner_age" name="expected_partner_age" class="border p-2 w-full"></div>
        <div><label for="expected_partner_height" class="block">Expected Partner Height</label><input type="text" id="expected_partner_height" name="expected_partner_height" class="border p-2 w-full"></div>
        <div><label for="expected_partner_weight" class="block">Expected Partner Weight</label><input type="text" id="expected_partner_weight" name="expected_partner_weight" class="border p-2 w-full"></div>
        <div><label for="contact_email" class="block">Contact Email</label><input type="email" id="contact_email" name="contact_email" class="border p-2 w-full" required></div>
        <div><label for="mobile_number" class="block">Mobile Number</label><input type="text" id="mobile_number" name="mobile_number" class="border p-2 w-full"></div>
        <div><label for="religion" class="block">Religion</label><input type="text" id="religion" name="religion" class="border p-2 w-full"></div>
        <div><label for="caste" class="block">Caste</label><input type="text" id="caste" name="caste" class="border p-2 w-full"></div>
        <div><label for="height" class="block">Height (e.g., 5.5)</label><input type="text" id="height" name="height" class="border p-2 w-full"></div>
        <div><label for="weight" class="block">Weight (e.g., 60.5)</label><input type="number" step="0.1" id="weight" name="weight" class="border p-2 w-full"></div>
        <div><label for="education" class="block">Education</label><input type="text" id="education" name="education" class="border p-2 w-full"></div>
        <div><label for="income" class="block">Annual Income</label><input type="number" step="0.01" id="income" name="income" class="border p-2 w-full"></div>
        <div><label for="marital_status" class="block">Marital Status</label><input type="text" id="marital_status" name="marital_status" class="border p-2 w-full"></div>
        <div><label for="hobbies" class="block">Hobbies</label><textarea id="hobbies" name="hobbies" class="border p-2 w-full"></textarea></div>
        <div><label for="family_type" class="block">Family Type</label><input type="text" id="family_type" name="family_type" class="border p-2 w-full"></div>
        <div><label for="family_values" class="block">Family Values</label><input type="text" id="family_values" name="family_values" class="border p-2 w-full"></div>
        <div><label for="expected_partner_religion" class="block">Expected Partner Religion</label><input type="text" id="expected_partner_religion" name="expected_partner_religion" class="border p-2 w-full"></div>
        <div><label for="expected_partner_education" class="block">Expected Partner Education</label><input type="text" id="expected_partner_education" name="expected_partner_education" class="border p-2 w-full"></div>
        <div><label for="expected_partner_income" class="block">Expected Partner Income</label><input type="number" step="0.01" id="expected_partner_income" name="expected_partner_income" class="border p-2 w-full"></div>
        <div><label for="expected_partner_marital_status" class="block">Expected Partner Marital Status</label><input type="text" id="expected_partner_marital_status" name="expected_partner_marital_status" class="border p-2 w-full"></div>
        <div><label for="lifestyle" class="block">Lifestyle</label><textarea id="lifestyle" name="lifestyle" class="border p-2 w-full"></textarea></div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
    </form>
</div>