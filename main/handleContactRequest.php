<?php
session_start();
include '../includes/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $biodata_id = $data['biodata_id'] ?? 0;
    $user_id = $_SESSION['user_id'];


    $query = "SELECT user_id FROM biodatas WHERE biodata_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $biodata_id);
    $stmt->execute();
    $stmt->bind_result($receiver_id);
    $stmt->fetch();
    $stmt->close();

    $insert_query = "INSERT INTO contact_requests (biodata_id, requester_id, receiver_id, status) VALUES (?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("iii", $biodata_id, $user_id, $receiver_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Contact request sent successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to send contact request']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
