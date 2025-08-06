<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['cart_id']) && isset($_POST['action'])) {
    $cart_id = intval($_POST['cart_id']);
    $action = $_POST['action'];

    if ($action === 'increase') {
        $sql = "UPDATE cart SET quantity = quantity + 1 WHERE cart_id = ?";
    } elseif ($action === 'decrease') {
        $sql = "UPDATE cart SET quantity = quantity - 1 WHERE cart_id = ? AND quantity > 1";
    } elseif ($action === 'remove') {
        $sql = "DELETE FROM cart WHERE cart_id = ?";
    } else {
        header("Location: cart.php");
        exit;
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
}

header("Location: cart.php");
exit;
?>
