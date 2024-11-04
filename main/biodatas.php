<?php
session_start();
include '../includes/header.php';
include '../includes/db.php';

$filter_query = "SELECT * FROM biodatas WHERE 1=1";

$types = '';
$params = [];

// Filter by age range
if (!empty($_GET['age_min']) && !empty($_GET['age_max'])) {
    $age_min = $_GET['age_min'];
    $age_max = $_GET['age_max'];
    $filter_query .= " AND age BETWEEN ? AND ?";
    $types .= 'ii'; // Two integers
    $params[] = $age_min;
    $params[] = $age_max;
}

// Filter by biodata type
if (!empty($_GET['biodata_type'])) {
    $biodata_type = $_GET['biodata_type'];
    $filter_query .= " AND biodata_type = ?";
    $types .= 's'; // String type
    $params[] = $biodata_type;
}

// Filter by division
if (!empty($_GET['division'])) {
    $division = $_GET['division'];
    $filter_query .= " AND permanent_division = ?";
    $types .= 's';
    $params[] = $division;
}

$stmt = $conn->prepare($filter_query);

if ($types) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mx-auto mt-10 max-w-7xl">
    <h1 class="text-4xl font-bold text-center mb-8">Explore <span class="text-purple-500">Biodatas</span></h1>

    <!-- Filter Form -->
    <form class="mb-10 p-6 bg-white rounded-lg shadow-lg border" method="GET" action="biodatas.php">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <label for="age_min" class="block text-sm font-bold text-gray-700">Min Age</label>
                <input type="number" name="age_min" id="age_min" value="<?= htmlspecialchars($_GET['age_min'] ?? '') ?>" class="mt-2 w-full border-2 border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label for="age_max" class="block text-sm font-bold text-gray-700">Max Age</label>
                <input type="number" name="age_max" id="age_max" value="<?= htmlspecialchars($_GET['age_max'] ?? '') ?>" class="mt-2 w-full border-2 border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="biodata_type" class="block text-sm font-bold text-gray-700">Biodata Type</label>
                <select name="biodata_type" id="biodata_type" class="mt-2 w-full border-2 border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Select</option>
                    <option value="Male" <?= isset($_GET['biodata_type']) && $_GET['biodata_type'] == 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= isset($_GET['biodata_type']) && $_GET['biodata_type'] == 'Female' ? 'selected' : '' ?>>Female</option>
                </select>
            </div>

            <div>
                <label for="division" class="block text-sm font-bold text-gray-700">Division</label>
                <select name="division" id="division" class="mt-2 w-full border-2 border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">Select</option>
                    <option value="Dhaka" <?= isset($_GET['division']) && $_GET['division'] == 'Dhaka' ? 'selected' : '' ?>>Dhaka</option>
                    <option value="Chattogram" <?= isset($_GET['division']) && $_GET['division'] == 'Chattogram' ? 'selected' : '' ?>>Chattogram</option>
                    <option value="Rangpur" <?= isset($_GET['division']) && $_GET['division'] == 'Rangpur' ? 'selected' : '' ?>>Rangpur</option>
                </select>
            </div>
        </div>
        <button type="submit" class="mt-6 w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow-lg transition duration-300 ease-in-out">
            Apply Filters
        </button>
    </form>

    <!-- Biodata Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-16 gap-12">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="px-10 py-6 bg-white border rounded-lg shadow-2xl transform hover:scale-105 transition duration-300 ease-in-out">
                <img src="<?= $row['profile_image'] ?>" alt="Profile Image" class="w-full h-[200px] object-contain-1 rounded-md mb-4">
                <h2 class="text-xl font-bold text-gray-800 mb-2"><?= htmlspecialchars($row['name']) ?></h2>
                <p class="text-gray-600">Age: <?= htmlspecialchars($row['age']) ?></p>
                <p class="text-gray-600">Occupation: <?= htmlspecialchars($row['occupation']) ?></p>
                <p class="text-gray-600">Division: <?= htmlspecialchars($row['permanent_division']) ?></p>
                <a href="viewProfile.php?id=<?= htmlspecialchars($row['biodata_id']) ?>" class="mt-4 inline-block bg-purple-500 hover:bg-purple-700 text-white py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">View Profile</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>