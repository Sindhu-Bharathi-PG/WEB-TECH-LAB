<?php
session_start();
include 'config.php'; // DB Connection file

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch cart items from database
$sql = "SELECT cart.cart_id, cart.book_id, cart.quantity, books.title, books.price 
        FROM cart 
        JOIN books ON cart.book_id = books.book_id 
        WHERE cart.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
          body {
            overflow-x: hidden;
            background: #0d0d0d;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 20px;
            color: rgb(245, 242, 242);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .sidebar::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('assets/side1.jpg') no-repeat center center/cover;
            z-index: 1;
        }

        .sidebar::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(52, 58, 64, 0.6);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
            z-index: 2;
        }

        .sidebar>div {
            position: relative;
            z-index: 3;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            margin: 10px 0;
            display: block;
        }

        .sidebar a:hover {
            color: #ffc107;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .glass-navbar {
            background-color: #ffc107;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 10px 20px;
        }

        .search-form input {
            background: rgba(255, 255, 255, 0.5);
            border: none;
            transition: all 0.3s ease;
        }

        .search-form input:focus {
            box-shadow: 0 0 10px rgba(255, 193, 7, 0.5);
            background: rgba(255, 255, 255, 0.8);
            outline: none;
        }

        .search-form button:hover {
            background-color: #e0a800;
        }

        .nav-link {
            position: relative;
            display: inline-block;
            padding-bottom: 4px;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 2px;
            width: 0;
            background-color: #000;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .side {
            font-size: 18px;
        }

        .side a {
            display: block;
            margin-bottom: 20px;
            text-decoration: none;
        }

        .side a:active {
            text-decoration: underline;
        }
        .cart-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease, opacity 0.5s ease;
            opacity: 0;
            transform: translateY(20px);
        }
        .cart-card.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .quantity-control button {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }
        .quantity-control button:hover {
            background-color: #e2e6ea;
        }
        .quantity-control button:active {
            transform: scale(0.9);
        }
        .remove-btn:hover {
            transform: scale(1.05);
            background-color: #dc3545 !important;
            color: #fff;
        }
        .checkout-btn {
            transition: box-shadow 0.3s ease, transform 0.2s ease;
        }
        .checkout-btn:hover {
            box-shadow: 0 0 20px rgba(25, 135, 84, 0.5);
            transform: translateY(-2px);
        }
        .fade-in {
            animation: fadeIn 0.7s ease-in-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<!-- Sidebar -->
    <div class="sidebar d-flex flex-column justify-content-between">
        <div>
            <h2 class="text-center mb-3 mt-4">
                <i class="bi bi-book-half text-light me-2"></i> BookNext
                <hr>
            </h2>

            <h5 class="text-warning my-4 text-center">
                <i class="bi bi-journal-bookmark me-2 text-warning"></i>Departments
            </h5>
            <div class="side">
                <a href="category.php?category_id=1"><i class="bi bi-laptop me-2"></i>Computer Science</a>
                <a href="category.php?category_id=2"><i class="bi bi-cpu me-2"></i>Electronics</a>
                <a href="category.php?category_id=3"><i class="bi bi-gear-wide-connected me-2"></i>Mechanical</a>
                <a href="category.php?category_id=4"><i class="bi bi-building me-2"></i>Civil</a>
                <a href="category.php?category_id=6"><i class="bi bi-lightning me-2"></i>Physics</a>
                <a href="category.php?category_id=7"><i class="bi bi-beaker me-2"></i>Chemistry</a>
            </div>

        </div>
        <div>
            <a href="#" class="btn btn-warning text-dark fw-bold w-100">Signout</a>
        </div>
    </div>


    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light shadow-sm mb-4 glass-navbar">
            <div class="container-fluid">
                <!-- Brand -->
                <a class="navbar-brand fw-bold text-dark fs-3" href="#">
                    <i class="bi bi-book-half text-dark me-2"></i>Catalogue
                </a>

                <!-- Nav Items (Icons) -->
                <ul class="navbar-nav d-flex align-items-center ms-auto gap-3 fs-5">
                    <li class="nav-item">
                        <a class="nav-link" href="catalogue.php">
                            <i class="bi bi-house-door fs-3 text-dark"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            <i class="bi bi-box-arrow-in-right fs-3 text-dark"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#catalogue">
                            <i class="bi bi-book fs-3 text-dark"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                            <i class="bi bi-cart fs-3 text-dark"></i>
                        </a>
                    </li>
                </ul>

                <!-- Search Form -->
                <form class="d-flex align-items-center ms-3">
                    <input class="form-control rounded-pill shadow-sm me-2 px-4" type="search"
                        placeholder="Search Books..." aria-label="Search">
                    <button class="btn btn-secondary rounded-pill px-4" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </nav>
<div class="container my-5">
    <h2 class="mb-4 fw-bold fade-in text-light">Your Cart</h2>

    <?php if ($result->num_rows > 0): ?>
        <div class="card p-4 shadow-sm fade-in">
            <table class="table align-middle mb-0 text-dark">
                <thead class="text-light">
                    <tr>
                        <th>Book</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $grand_total = 0; $index = 0; while ($row = $result->fetch_assoc()): ?>
                    <?php $item_total = $row['price'] * $row['quantity']; $grand_total += $item_total; ?>
                    <tr class="cart-card" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                        <td class="fw-semibold"><?php echo $row['title']; ?></td>
                        <td>
                            <form method="POST" action="cart_action.php" class="d-flex align-items-center quantity-control">
                                <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                                <button type="submit" name="action" value="decrease" class="btn btn-outline-secondary btn-sm me-2"><i class="bi bi-dash"></i></button>
                                <span class="fw-bold mx-2"><?php echo $row['quantity']; ?></span>
                                <button type="submit" name="action" value="increase" class="btn btn-outline-secondary btn-sm ms-2"><i class="bi bi-plus"></i></button>
                            </form>
                        </td>
                        <td>₹<?php echo $row['price']; ?></td>
                        <td class="fw-bold">₹<?php echo $item_total; ?></td>
                        <td>
                            <form method="POST" action="cart_action.php">
                                <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                                <button type="submit" name="action" value="remove" class="btn btn-danger btn-sm remove-btn"><i class="bi bi-trash"></i> Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php $index++; endwhile; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Grand Total:</th>
                        <th colspan="2" class="fs-5" id="grand-total">₹0</th>
                    </tr>
                </tfoot>
            </table>
            <div class="text-end mt-3">
                <button class="btn btn-success btn-lg checkout-btn">Buy Now</button>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info fade-in">Your cart is empty.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Animate Cart Rows on Load
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.cart-card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('visible');
        }, index * 100); // 100ms delay between each
    });

    // Animate Grand Total Counting
    let grandTotal = <?php echo $grand_total; ?>;
    let displayedTotal = 0;
    const totalElement = document.getElementById('grand-total');
    const increment = Math.ceil(grandTotal / 50);

    const counter = setInterval(() => {
        displayedTotal += increment;
        if (displayedTotal >= grandTotal) {
            displayedTotal = grandTotal;
            clearInterval(counter);
        }
        totalElement.textContent = '₹' + displayedTotal;
    }, 20);
});
</script>
</body>
</html>
