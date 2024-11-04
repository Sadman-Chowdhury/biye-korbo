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

//deletion
if (isset($_POST['delete_biodata'])) {
    $delete_query = "DELETE FROM biodatas WHERE user_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $user_id);
    $delete_stmt->execute();

    header('Location: dashboard.php');
    exit();
}

if (isset($_POST['accept_contact'])) {
    if (!empty($_POST['requester_id'])) {
        $requester_id = $_POST['requester_id'];

        $update_query = "UPDATE contact_requests SET status = 'accepted' WHERE requester_id = ? AND receiver_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ii", $requester_id, $user_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                header('Location: dashboard.php?status=accepted');
                exit();
            } else {
                echo "<p class='text-red-500'>No rows were updated. The request might already be accepted.</p>";
            }
        } else {
            echo "<p class='text-red-500'>Failed to accept the contact request: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p class='text-red-500'>Invalid contact request. Please try again.</p>";
    }
}

//contact decliine
if (isset($_POST['decline_contact'])) {
    if (!empty($_POST['requester_id'])) {
        $requester_id = $_POST['requester_id'];

        $delete_query = "DELETE FROM contact_requests WHERE requester_id = ? AND receiver_id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("ii", $requester_id, $user_id);

        if ($stmt->execute()) {
            header('Location: dashboard.php?status=declined');
            exit();
        } else {
            echo "<p class='text-red-500'>Failed to decline the contact request. Please try again later.</p>";
        }
    } else {
        echo "<p class='text-red-500'>Invalid contact request. Please try again.</p>";
    }
}

//deleting contacts
if (isset($_POST['delete_contact'])) {
    if (!empty($_POST['contact_id'])) {
        $contact_id = $_POST['contact_id'];

        $delete_contact_query = "DELETE FROM contact_requests WHERE requester_id = ? AND receiver_id = ?";
        $stmt = $conn->prepare($delete_contact_query);
        $stmt->bind_param("ii", $contact_id, $user_id);

        if ($stmt->execute()) {
            header('Location: dashboard.php?status=contact_deleted');
            exit();
        } else {
            echo "<p class='text-red-500'>Failed to delete the contact. Please try again later.</p>";
        }
    }
}

//deleting favorites
if (isset($_POST['delete_favorite'])) {
    if (!empty($_POST['favorite_user_id'])) {
        $favorite_user_id = $_POST['favorite_user_id'];

        $delete_favorite_query = "DELETE FROM favourites WHERE user_id = ? AND favourite_user_id = ?";
        $stmt = $conn->prepare($delete_favorite_query);
        $stmt->bind_param("ii", $user_id, $favorite_user_id);

        if ($stmt->execute()) {
            header('Location: dashboard.php?status=favorite_deleted');
            exit();
        } else {
            echo "<p class='text-red-500'>Failed to delete the favorite. Please try again later.</p>";
        }
    }
}

//contact requests
$contact_requests_query = "
    SELECT biodatas.name, biodatas.profile_image, contact_requests.requester_id, contact_requests.status 
    FROM contact_requests 
    JOIN biodatas ON contact_requests.requester_id = biodatas.user_id 
    WHERE contact_requests.receiver_id = ? AND contact_requests.status = 'pending'";

$contact_stmt = $conn->prepare($contact_requests_query);
$contact_stmt->bind_param("i", $user_id);
$contact_stmt->execute();
$contact_requests_result = $contact_stmt->get_result();

//accepted contacts
$contacts_query = "
    SELECT biodatas.name, biodatas.profile_image, contact_requests.requester_id 
    FROM contact_requests 
    JOIN biodatas ON contact_requests.requester_id = biodatas.user_id 
    WHERE contact_requests.receiver_id = ? AND contact_requests.status = 'accepted'";
$contacts_stmt = $conn->prepare($contacts_query);
$contacts_stmt->bind_param("i", $user_id);
$contacts_stmt->execute();
$contacts_result = $contacts_stmt->get_result();

//favorites
$favorites_query = "
    SELECT biodatas.name, biodatas.profile_image, favourites.favourite_user_id 
    FROM favourites 
    JOIN biodatas ON favourites.favourite_user_id = biodatas.user_id 
    WHERE favourites.user_id = ?";
$favorites_stmt = $conn->prepare($favorites_query);
$favorites_stmt->bind_param("i", $user_id);
$favorites_stmt->execute();
$favorites_result = $favorites_stmt->get_result();
?>

<div class="container mx-auto mt-10 max-w-7xl">
    <h1 class="text-4xl font-extrabold text-center mb-10">Dash<span class="text-purple-500">board</span></h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <div class="p-8 bg-white rounded-lg shadow-lg border border-gray-200">
            <h2 class="text-3xl font-semibold text-gray-700 mb-6 text-center">Biodata Information</h2>
            <?php if ($biodata): ?>
                <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                    <div class="flex-shrink-0">
                        <img src="<?= htmlspecialchars($biodata['profile_image']) ?>" alt="Profile Image" class="rounded-lg h-48 w-48 object-contain-1 shadow-lg border-4 border-blue-100 hover:border-blue-400 transition duration-300">
                    </div>

                    <div class="w-full">
                        <p class="text-lg text-gray-700"><span class="font-bold">Name:</span> <?= htmlspecialchars($biodata['name']) ?></p>
                        <p class="text-lg text-gray-700"><span class="font-bold">Age:</span> <?= htmlspecialchars($biodata['age']) ?></p>
                        <p class="text-lg text-gray-700"><span class="font-bold">Occupation:</span> <?= htmlspecialchars($biodata['occupation']) ?></p>
                        <p class="text-lg text-gray-700"><span class="font-bold">Division:</span> <?= htmlspecialchars($biodata['division']) ?></p>
                    </div>
                </div>

                <div class="mt-6 flex justify-center gap-4">
                    <a href="editBiodata.php" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg transition">Edit Biodata</a>

                    <form action="dashboard.php" method="post">
                        <button type="submit" name="delete_biodata" class="bg-red-500 hover:bg-red-600 text-white py-2 px-6 rounded-lg transition">Delete Biodata</button>
                    </form>
                </div>
            <?php else: ?>
                <p class="text-gray-600 text-center">No biodata found.</p>
                <div class="mt-4 flex justify-center">
                    <a href="createBiodata.php" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg transition">Create New Biodata</a>
                </div>
            <?php endif; ?>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-lg border border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">My Contact Requests</h2>
            <?php if ($contact_requests_result->num_rows > 0): ?>
                <ul class="space-y-4">
                    <?php while ($request = $contact_requests_result->fetch_assoc()): ?>
                        <li class="flex items-center gap-4">
                            <img src="<?= htmlspecialchars($request['profile_image']) ?>" alt="Profile Image" class="w-12 h-12 rounded-lg object-cover shadow-md">
                            <p class="flex-grow"><?= htmlspecialchars($request['name']) ?></p>
                            <form method="post">
                                <input type="hidden" name="requester_id" value="<?= htmlspecialchars($request['requester_id']) ?>">
                                <button type="submit" name="accept_contact" class="bg-green-500 hover:bg-green-600 text-white py-1 px-4 rounded-lg">Accept</button>
                                <button type="submit" name="decline_contact" class="bg-red-500 hover:bg-red-600 text-white py-1 px-4 rounded-lg">Decline</button>
                            </form>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-600">No contact requests found.</p>
            <?php endif; ?>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-lg border border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Contacts</h2>
            <?php if ($contacts_result->num_rows > 0): ?>
                <ul class="space-y-4">
                    <?php while ($contact = $contacts_result->fetch_assoc()): ?>
                        <?php
                        // Fetch the corresponding biodata_id for this requester_id (user_id)
                        $user_id = $contact['requester_id'];
                        $biodata_query = "SELECT biodata_id FROM biodatas WHERE user_id = ?";
                        $stmt = $conn->prepare($biodata_query);
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $stmt->bind_result($biodata_id);
                        $stmt->fetch();
                        $stmt->close();
                        ?>

                        <li class="flex items-center gap-4">
                            <img src="<?= htmlspecialchars($contact['profile_image']) ?>" alt="Profile Image" class="w-12 h-12 rounded-lg object-cover shadow-md">
                            <p class="flex-grow"><?= htmlspecialchars($contact['name']) ?></p>

                            <!-- Profile Button using the fetched biodata_id -->
                            <a href="viewProfile.php?id=<?= htmlspecialchars($biodata_id) ?>" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-4 rounded-lg">Profile</a>

                            <!-- Delete Button -->
                            <form method="post" class="inline-block">
                                <input type="hidden" name="contact_id" value="<?= htmlspecialchars($contact['requester_id']) ?>">
                                <button type="submit" name="delete_contact" class="bg-red-500 hover:bg-red-600 text-white py-1 px-4 rounded-lg">Delete</button>
                            </form>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-600">No contacts found.</p>
            <?php endif; ?>
        </div>



        <div class="p-6 bg-white rounded-lg shadow-lg border border-gray-200">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Favorites</h2>
            <?php if ($favorites_result->num_rows > 0): ?>
                <ul class="space-y-4">
                    <?php while ($favorite = $favorites_result->fetch_assoc()): ?>
                        <li class="flex items-center gap-4">
                            <img src="<?= htmlspecialchars($favorite['profile_image']) ?>" alt="Profile Image" class="w-12 h-12 rounded-lg object-cover shadow-md">
                            <p class="flex-grow"><?= htmlspecialchars($favorite['name']) ?></p>
                            <form method="post">
                                <input type="hidden" name="favorite_user_id" value="<?= htmlspecialchars($favorite['favourite_user_id']) ?>">
                                <button type="submit" name="delete_favorite" class="bg-red-500 hover:bg-red-600 text-white py-1 px-4 rounded-lg">Delete</button>
                            </form>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-600">No favorites found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>