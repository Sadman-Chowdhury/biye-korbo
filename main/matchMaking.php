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

// Fallbacks for NULL or missing fields
$expected_min_age = $current_user_biodata['expected_partner_age'] ?? 18;
$expected_max_age = $expected_min_age + 10; // Default range of 10 years if no max age is provided
$expected_height = $current_user_biodata['expected_partner_height'] ?? 0;
$expected_weight = $current_user_biodata['expected_partner_weight'] ?? 0;
$expected_religion = $current_user_biodata['expected_partner_religion'] ?? '';
$expected_education = $current_user_biodata['expected_partner_education'] ?? '';
$expected_income = $current_user_biodata['expected_partner_income'] ?? '';
$expected_marital_status = $current_user_biodata['expected_partner_marital_status'] ?? '';

// Define the matchmaking query
$match_query = "
    SELECT * FROM biodatas 
    WHERE user_id != ? 
    AND (division = ? OR present_division = ?)
    AND (age BETWEEN ? AND ?)
    AND (height >= ? OR ? = 0)
    AND (weight >= ? OR ? = 0)
    AND (religion = ? OR ? = '')
    AND (education LIKE CONCAT('%', ?, '%') OR ? = '')
    AND (income >= ? OR ? = '')
    AND (marital_status = ? OR ? = '')
";

$stmt = $conn->prepare($match_query);
$stmt->bind_param(
    "issiiiiiissssssss",
    $user_id,
    $current_user_biodata['division'],
    $current_user_biodata['present_division'],
    $expected_min_age,
    $expected_max_age,
    $expected_height,
    $expected_height,
    $expected_weight,
    $expected_weight,
    $expected_religion,
    $expected_religion,
    $expected_education,
    $expected_education,
    $expected_income,
    $expected_income,
    $expected_marital_status,
    $expected_marital_status
);
$stmt->execute();
$matches = $stmt->get_result();
?>

<div class="container mx-auto mt-10">
    <h1 class="text-3xl font-bold text-center mb-8">Your Matches</h1>

    <?php if ($matches->num_rows > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while ($match = $matches->fetch_assoc()): ?>
                <div class="card shadow-xl border border-gray-200 p-6 bg-gradient-to-r from-white via-gray-100 to-white rounded-lg">
                    <div class="flex flex-col items-center">
                        <img src="<?= htmlspecialchars($match['profile_image']) ?>" alt="Profile Image" class="w-32 h-32 object-cover rounded-full shadow-md mb-4">
                        <h2 class="text-xl font-semibold text-gray-800"><?= htmlspecialchars($match['name']) ?></h2>
                        <p class="text-sm text-gray-600"><?= htmlspecialchars($match['age']) ?> years old</p>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="text-gray-700"><strong>Occupation:</strong> <?= htmlspecialchars($match['occupation']) ?></p>
                        <p class="text-gray-700"><strong>Division:</strong> <?= htmlspecialchars($match['division']) ?></p>
                        <p class="text-gray-700"><strong>Education:</strong> <?= htmlspecialchars($match['education']) ?></p>
                        <p class="text-gray-700"><strong>Income:</strong> <?= htmlspecialchars($match['income']) ?> BDT</p>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="viewProfile.php?id=<?= $match['biodata_id'] ?>" class="btn btn-primary btn-sm rounded-full shadow-lg">
                            View Profile
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-gray-600">No matches found based on your preferences.</p>
    <?php endif; ?>
</div>


<?php include '../includes/footer.php'; ?>