<?php

session_start();
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$user_id = $_SESSION['user_id'];

// Fetch current user's biodata
$query = "SELECT * FROM biodatas WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$current_user_biodata = $result->fetch_assoc();

if (!$current_user_biodata) {
    echo "<div class='alert alert-error'>Please complete your biodata first.</div>";
    exit();
}

// Define the matchmaking criteria based on the current user's preferences
$match_query = "
    SELECT * FROM biodatas 
    WHERE user_id != ? 
    AND (division = ? OR present_division = ?)
    AND occupation LIKE CONCAT('%', ?, '%')
    AND age BETWEEN ? AND ?
    AND height BETWEEN ? AND ?
    AND weight BETWEEN ? AND ?
    AND education LIKE CONCAT('%', ?, '%')
    AND marital_status = ?
    AND religion = ?
";

$stmt = $conn->prepare($match_query);
$stmt->bind_param(
    "issiiiiiiiiss",
    $user_id,
    $current_user_biodata['division'],
    $current_user_biodata['present_division'],
    $current_user_biodata['expected_partner_occupation'],
    $current_user_biodata['expected_partner_min_age'],
    $current_user_biodata['expected_partner_max_age'],
    $current_user_biodata['expected_partner_min_height'],
    $current_user_biodata['expected_partner_max_height'],
    $current_user_biodata['expected_partner_min_weight'],
    $current_user_biodata['expected_partner_max_weight'],
    $current_user_biodata['expected_partner_education'],
    $current_user_biodata['expected_partner_marital_status'],
    $current_user_biodata['expected_partner_religion'],
);
$stmt->execute();
$matches = $stmt->get_result();
?>

<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Your Matches</h1>

    <?php if ($matches->num_rows > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php while ($match = $matches->fetch_assoc()): ?>
                <div class="p-6 border rounded-md shadow-lg bg-white">
                    <img src="<?= htmlspecialchars($match['profile_image']) ?>" alt="Profile Image" class="w-32 h-32 object-cover rounded-lg mb-4">
                    <h2 class="text-xl font-semibold"><?= htmlspecialchars($match['name']) ?></h2>
                    <p><strong>Age:</strong> <?= htmlspecialchars($match['age']) ?> years</p>
                    <p><strong>Occupation:</strong> <?= htmlspecialchars($match['occupation']) ?></p>
                    <p><strong>Division:</strong> <?= htmlspecialchars($match['division']) ?></p>
                    <a href="viewProfile.php?id=<?= $match['biodata_id'] ?>" class="text-blue-500">View Profile</a>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-center">No matches found based on your preferences.</p>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>