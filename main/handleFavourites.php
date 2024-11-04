<?php
session_start();
include '../includes/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $user_id = $_SESSION['user_id'];
    $favourite_user_id = $data['favourite_user_id'] ?? 0;

    $favourite_check_query = "SELECT * FROM favourites WHERE user_id = ? AND favourite_user_id = ?";
    $stmt = $conn->prepare($favourite_check_query);
    $stmt->bind_param("ii", $user_id, $favourite_user_id);
    $stmt->execute();
    $favourite_result = $stmt->get_result();

    if ($favourite_result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Already added to favourites']);
    } else {
        $insert_fav_query = "INSERT INTO favourites (user_id, favourite_user_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insert_fav_query);
        $stmt->bind_param("ii", $user_id, $favourite_user_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add to favourites']);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
