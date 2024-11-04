<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$biodata_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT * FROM biodatas WHERE biodata_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $biodata_id);
$stmt->execute();
$result = $stmt->get_result();
$biodata = $result->fetch_assoc();

if (!$biodata) {
    echo "<div class='alert alert-error'>Profile not found.</div>";
    exit();
}

$request_check_query = "SELECT * FROM contact_requests WHERE biodata_id = ? AND requester_id = ? AND receiver_id = ?";
$stmt = $conn->prepare($request_check_query);
$stmt->bind_param("iii", $biodata_id, $user_id, $biodata['user_id']);
$stmt->execute();
$request_result = $stmt->get_result();
$contact_request = $request_result->fetch_assoc();

$favourite_check_query = "SELECT * FROM favourites WHERE user_id = ? AND favourite_user_id = ?";
$stmt = $conn->prepare($favourite_check_query);
$stmt->bind_param("ii", $user_id, $biodata['user_id']);
$stmt->execute();
$favourite_result = $stmt->get_result();
$is_favourite = $favourite_result->num_rows > 0;

?>

<div class="container mx-auto mt-10 max-w-4xl">
    <h1 class="text-3xl font-bold text-center mb-6">Profile of <?= htmlspecialchars($biodata['name']) ?></h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="p-6 border-2 border-purple-300 rounded-md shadow-lg bg-white">
            <img src="<?= htmlspecialchars($biodata['profile_image']) ?>" alt="Profile Image" class="w-64 h-64 object-cover rounded-lg border shadow-md mx-auto">
        </div>

        <div class="p-6 border-2 border-purple-300 rounded-md shadow-lg bg-white">
            <h2 class="text-2xl font-semibold mb-4">Personal Information</h2>
            <ul class="space-y-2">
                <li><strong>Name:</strong> <?= htmlspecialchars($biodata['name']) ?></li>
                <li><strong>Age:</strong> <?= htmlspecialchars($biodata['age']) ?> years</li>
                <li><strong>Height:</strong> <?= htmlspecialchars($biodata['height']) ?></li>
                <li><strong>Weight:</strong> <?= htmlspecialchars($biodata['weight']) ?></li>
                <li><strong>Religion:</strong> <?= htmlspecialchars($biodata['religion']) ?></li>
                <li><strong>Caste:</strong> <?= htmlspecialchars($biodata['caste']) ?></li>
                <li><strong>Occupation:</strong> <?= htmlspecialchars($biodata['occupation']) ?></li>
                <li><strong>Division:</strong> <?= htmlspecialchars($biodata['division']) ?></li>
                <li><strong>Education:</strong> <?= htmlspecialchars($biodata['education']) ?></li>
                <li><strong>Income:</strong> <?= htmlspecialchars($biodata['income']) ?></li>
                <li><strong>Marital Status:</strong> <?= htmlspecialchars($biodata['marital_status']) ?></li>
                <li><strong>Hobbies:</strong> <?= htmlspecialchars($biodata['hobbies']) ?></li>
                <li><strong>Lifestyle:</strong> <?= htmlspecialchars($biodata['lifestyle']) ?></li>
            </ul>
        </div>

        <div class="p-6 border-2 border-purple-300 rounded-md shadow-lg bg-white">
            <h2 class="text-2xl font-semibold mb-4">Family Information</h2>
            <ul class="space-y-2">
                <li><strong>Father's Name:</strong> <?= htmlspecialchars($biodata['father_name']) ?></li>
                <li><strong>Mother's Name:</strong> <?= htmlspecialchars($biodata['mother_name']) ?></li>
                <li><strong>Family Type:</strong> <?= htmlspecialchars($biodata['family_type']) ?></li>
                <li><strong>Family Values:</strong> <?= htmlspecialchars($biodata['family_values']) ?></li>
            </ul>
        </div>

        <div class="p-6 border-2 border-purple-300 rounded-md shadow-lg bg-white">
            <h2 class="text-2xl font-semibold mb-4">Partner Preferences</h2>
            <ul class="space-y-2">
                <li><strong>Expected Partner Age:</strong> <?= htmlspecialchars($biodata['expected_partner_age']) ?> years</li>
                <li><strong>Expected Partner Height:</strong> <?= htmlspecialchars($biodata['expected_partner_height']) ?></li>
                <li><strong>Expected Partner Weight:</strong> <?= htmlspecialchars($biodata['expected_partner_weight']) ?></li>
                <li><strong>Expected Partner Religion:</strong> <?= htmlspecialchars($biodata['expected_partner_religion']) ?></li>
                <li><strong>Expected Partner Education:</strong> <?= htmlspecialchars($biodata['expected_partner_education']) ?></li>
                <li><strong>Expected Partner Income:</strong> <?= htmlspecialchars($biodata['expected_partner_income']) ?></li>
                <li><strong>Expected Partner Marital Status:</strong> <?= htmlspecialchars($biodata['expected_partner_marital_status']) ?></li>
            </ul>
        </div>

        <div class="p-6 border-2 border-purple-300 rounded-md shadow-lg bg-white">
            <h2 class="text-2xl font-semibold mb-4">Contact Information</h2>
            <ul class="space-y-2">
                <li><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars($biodata['contact_email']) ?>" class="text-blue-500"><?= htmlspecialchars($biodata['contact_email']) ?></a></li>
                <li><strong>Mobile Number:</strong> <?= htmlspecialchars($biodata['mobile_number']) ?></li>
            </ul>
        </div>
    </div>

    <div class="mt-8 flex justify-center space-x-4">
        <form method="POST" id="contactRequestForm">
            <input type="hidden" name="biodata_id" value="<?= $biodata_id ?>">
            <button type="submit" id="sendRequestButton" class="btn btn-outline btn-info btn-lg" <?= $contact_request ? 'disabled' : '' ?>>
                <?= $contact_request ? 'Contact Request Sent' : 'Request Contact' ?>
            </button>
        </form>

        <form method="POST" id="addFavouriteForm">
            <input type="hidden" name="favourite_user_id" value="<?= $biodata['user_id'] ?>">
            <button type="submit" id="addFavouriteButton" class="btn btn-outline btn-secondary btn-lg" <?= $is_favourite ? 'disabled' : '' ?>>
                <?= $is_favourite ? 'Added to Favourites' : 'Add to Favourites' ?>
            </button>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
    document.getElementById('contactRequestForm').addEventListener('submit', function(event) {
        event.preventDefault();
        fetch('handleContactRequest.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    biodata_id: <?= $biodata_id ?>
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('sendRequestButton').disabled = true;
                    document.getElementById('sendRequestButton').innerText = 'Contact Request Sent';
                    showToast('Contact request sent successfully!', 'success');
                } else {
                    showToast(data.message || 'Failed to send contact request', 'error');
                }
            });
    });

    document.getElementById('addFavouriteForm').addEventListener('submit', function(event) {
        event.preventDefault();
        fetch('handleFavourites.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    favourite_user_id: <?= $biodata['user_id'] ?>
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('addFavouriteButton').disabled = true;
                    document.getElementById('addFavouriteButton').innerText = 'Added to Favourites';
                    showToast('Added to favourites successfully!', 'success');
                } else {
                    showToast(data.message || 'Failed to add to favourites', 'error');
                }
            });
    });

    function showToast(message, type) {
        Toastify({
            text: message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: type === 'success' ? 'green' : 'red',
            stopOnFocus: true,
        }).showToast();
    }
</script>

<?php include '../includes/footer.php'; ?>