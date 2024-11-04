<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM biodatas WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$biodata = $result->fetch_assoc();

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

    $update_query = "UPDATE biodatas 
                     SET name = ?, profile_image = ?, age = ?, occupation = ?, division = ?, father_name = ?, mother_name = ?, present_division = ?, expected_partner_age = ?, expected_partner_height = ?, expected_partner_weight = ?, contact_email = ?, mobile_number = ? 
                     WHERE user_id = ?";

    $update_stmt = $conn->prepare($update_query);

    $update_stmt->bind_param(
        "ssissssssssssi",
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
        $user_id
    );

    if ($update_stmt->execute()) {
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Error updating biodata: " . $conn->error;
    }
}
?>

<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit Biodata</h1>

    <form action="editBiodata.php" method="post" class="space-y-4">
        <div><label for="name" class="block">Name</label><input type="text" id="name" name="name" value="<?= htmlspecialchars($biodata['name']) ?>" class="border p-2 w-full" required></div>
        <div><label for="profile_image" class="block">Profile Image URL</label><input type="text" id="profile_image" name="profile_image" value="<?= htmlspecialchars($biodata['profile_image']) ?>" class="border p-2 w-full" required></div>
        <div><label for="age" class="block">Age</label><input type="number" id="age" name="age" value="<?= htmlspecialchars($biodata['age']) ?>" class="border p-2 w-full" required></div>
        <div><label for="occupation" class="block">Occupation</label><input type="text" id="occupation" name="occupation" value="<?= htmlspecialchars($biodata['occupation']) ?>" class="border p-2 w-full" required></div>
        <div><label for="division" class="block">Division</label><input type="text" id="division" name="division" value="<?= htmlspecialchars($biodata['division']) ?>" class="border p-2 w-full"></div>
        <div><label for="father_name" class="block">Father's Name</label><input type="text" id="father_name" name="father_name" value="<?= htmlspecialchars($biodata['father_name']) ?>" class="border p-2 w-full"></div>
        <div><label for="mother_name" class="block">Mother's Name</label><input type="text" id="mother_name" name="mother_name" value="<?= htmlspecialchars($biodata['mother_name']) ?>" class="border p-2 w-full"></div>
        <div><label for="present_division" class="block">Present Division</label><input type="text" id="present_division" name="present_division" value="<?= htmlspecialchars($biodata['present_division']) ?>" class="border p-2 w-full"></div>
        <div><label for="expected_partner_age" class="block">Expected Partner Age</label><input type="number" id="expected_partner_age" name="expected_partner_age" value="<?= htmlspecialchars($biodata['expected_partner_age']) ?>" class="border p-2 w-full"></div>
        <div><label for="expected_partner_height" class="block">Expected Partner Height</label><input type="text" id="expected_partner_height" name="expected_partner_height" value="<?= htmlspecialchars($biodata['expected_partner_height']) ?>" class="border p-2 w-full"></div>
        <div><label for="expected_partner_weight" class="block">Expected Partner Weight</label><input type="text" id="expected_partner_weight" name="expected_partner_weight" value="<?= htmlspecialchars($biodata['expected_partner_weight']) ?>" class="border p-2 w-full"></div>
        <div><label for="contact_email" class="block">Contact Email</label><input type="email" id="contact_email" name="contact_email" value="<?= htmlspecialchars($biodata['contact_email']) ?>" class="border p-2 w-full" required></div>
        <div><label for="mobile_number" class="block">Mobile Number</label><input type="text" id="mobile_number" name="mobile_number" value="<?= htmlspecialchars($biodata['mobile_number']) ?>" class="border p-2 w-full"></div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
    </form>
</div>