<?php
session_start();
include 'config.php'; // DB connection file

// Assuming user login session is stored as $_SESSION['user_id']
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['book_id'])) {
    $user_id = intval($_SESSION['user_id']);
    $book_id = intval($_POST['book_id']);

    // Check if book already exists in cart
    $check_sql = "SELECT * FROM cart WHERE user_id = ? AND book_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $user_id, $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If exists, increase quantity
        $update_sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND book_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $user_id, $book_id);
        $update_stmt->execute();
    } else {
        // If not exists, insert new row
        $insert_sql = "INSERT INTO cart (user_id, book_id, quantity) VALUES (?, ?, 1)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ii", $user_id, $book_id);
        $insert_stmt->execute();
    }

    header("Location: cart.php"); // Redirect to cart page
} else {
    echo "Invalid Request";
}
?>
