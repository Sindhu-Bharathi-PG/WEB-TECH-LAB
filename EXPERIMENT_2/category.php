<?php
session_start();
include 'config.php';

// Check if category_id is passed in URL
if (isset($_GET['category_id'])) {
    $category_id = intval($_GET['category_id']); // Sanitize input
} else {
    // Default to category_id = 1 (Computer Science)
    $category_id = 1;
}

// Fetch Books based on category_id
$sql = "SELECT * FROM books WHERE category_id = $category_id";
$result = $conn->query($sql);

// Fetch category name for heading
$categoryName = 'Category';
$categorySql = "SELECT category_name FROM categories WHERE category_id = $category_id";
$categoryResult = $conn->query($categorySql);

if ($categoryResult->num_rows > 0) {
    $row = $categoryResult->fetch_assoc();
    $categoryName = $row['category_name'];
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Computer Science Books</title>
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

        /* Book 3D Effect */
        .book {
            width: 18.5em;
            height: calc(18.5em * 1.2486);
            position: relative;
            transform: perspective(60em) rotateX(58deg) rotateZ(-34deg) skewY(-7deg);
            box-shadow: -1.4em 1.7em 0.3em -0.3em rgba(0, 0, 0, 0.8),
                -1.6em 1.8em 0.9em -0.2em rgba(0, 0, 0, 0.5),
                0.3em 1.9em 1.3em rgba(0, 0, 0, 0.3);
            border-top-right-radius: 0.4em;
            margin-top: 0;
        }

        .book img {
            border-top-right-radius: 0.4em;
            box-sizing: border-box;
            width: 100%;
            clip: rect(0em, 18.5em, 23.1em, 0em);
            display: block;
            position: absolute;
            filter: saturate(90%);
        }

        .book::before,
        .book::after {
            content: '';
            position: absolute;
            top: 0;
        }

        .book::before {
            width: 105%;
            height: 105%;
            left: -5%;
            z-index: -1;
            background-repeat: no-repeat;
            background-image:
                linear-gradient(115deg, transparent 2.8%, #3f3f3f 3%, #3f3f3f 16%, transparent 16%),
                linear-gradient(125deg, transparent 10%, #3f3f3f 10%, #3f3f3f 17%, #222 46.8%, transparent 47%),
                linear-gradient(125deg, transparent 46%, rgba(0, 0, 0, 0.5) 46.5%, rgba(0, 0, 0, 0.25) 49%, transparent 53%),
                linear-gradient(to right, #444, #666),
                linear-gradient(#444, #444),
                linear-gradient(140deg, transparent 45%, #eee 45%, #ccc 96.8%, rgba(170, 170, 170, 0) 97%);
            background-size: 100% 100%, 100% 100%, 100% 100%, 100% 0.4em, 94% 0.2em, 100% 100%;
            background-position: 0 0, 0 0, 0 0, 0 95.8%, 0 100%, 0 0;
        }

        .book::after {
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            background-image:
                linear-gradient(to right, transparent 2%, rgba(0, 0, 0, 0.1) 3%, rgba(0, 0, 0, 0.1) 4%, transparent 5%),
                linear-gradient(-50deg, rgba(0, 0, 0, 0.1) 20%, transparent 100%),
                linear-gradient(-50deg, rgba(0, 0, 0, 0.2) 20%, transparent 100%),
                linear-gradient(to bottom, rgba(0, 0, 0, 0.1) 20%, transparent 100%),
                linear-gradient(to bottom, rgba(0, 0, 0, 0.1) 20%, transparent 100%);
            background-size: 100% 100%, 2% 20%, 1% 20%, 2% 20%, 1% 20%;
            background-position: 0 0, 2.2% 100%, 3% 100%, 2.2% 0, 3% 0;
        }

        /* Book Cards Grid */
        .book-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px 30px;
            justify-items: center;
            margin-bottom: 50px;
        }

        .book-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            color: white;
        }

        .details {
            margin-top: 20px;
        }

        .details h5 {
            margin-bottom: 5px;
        }

        .details .price {
            font-weight: bold;
            margin: 10px 0;
        }

        /* Add to Cart Button */
        .btn-cart {
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            border: none;
            color: white;
            border-radius: 50px;
            padding: 6px 20px;
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                border-right: none;
                padding: 10px;
            }

            .sidebar::before,
            .sidebar::after {
                display: none;
            }

            .sidebar>div {
                z-index: 1;
            }
        }

        .book-card {
            perspective: 1000px;
            margin: 20px;
        }

        .book-container {
            transition: transform 0.6s ease;
            transform-style: preserve-3d;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .book-card:hover .book-container,
        .book-card:active .book-container {
            transform: rotateY(-15deg) rotateX(5deg) scale(1.03);
        }

        .book {
            width: 180px;
            height: 250px;
            position: relative;
            transform-origin: left center;
            transition: transform 0.6s ease;
        }

        .book img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .book-card:hover .book,
        .book-card:active .book {
            transform: rotateY(-10deg);
        }

        .details {
            color: white;
            text-align: center;
            margin-top: 20px;
        }

        .details h5 {
            margin-bottom: 5px;
        }

        .details .price {
            font-weight: bold;
            margin: 10px 0;
        }

        .btn-cart {
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            border: none;
            color: white;
            border-radius: 50px;
            padding: 6px 20px;
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


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
                    <div class="side">
                        <a href="category.php?category_id=1"><i class="bi bi-laptop me-2"></i>Computer Science</a>
                        <a href="category.php?category_id=2"><i class="bi bi-cpu me-2"></i>Electronics</a>
                        <a href="category.php?category_id=3"><i class="bi bi-gear-wide-connected me-2"></i>Mechanical</a>
                        <a href="category.php?category_id=4"><i class="bi bi-building me-2"></i>Civil</a>
                        <a href="category.php?category_id=6"><i class="bi bi-lightning me-2"></i>Physics</a>
                        <a href="category.php?category_id=7"><i class="bi bi-beaker me-2"></i>Chemistry</a>
                    </div>
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
                            <a class="nav-link" href="home.php">
                                <i class="bi bi-house-door fs-3 text-dark"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="bi bi-box-arrow-in-right fs-3 text-dark"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="catalogue.php">
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
            <div class="book-cards-grid">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>
            <div class="book-card">
                <div class="book">
                    <img src="<?php echo $row['cover_image']; ?>" alt="<?php echo $row['title']; ?>">
                </div>
                <div class="details">
                    <h5><?php echo $row['author']; ?></h5>
                    <p><?php echo $row['publisher']; ?></p>
                    <p class="price">₹<?php echo $row['price']; ?></p>

                    <!-- Add to Cart Form -->
                    <form method="POST" action="add_to_cart.php">
                        <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                        <button type="submit" class="btn btn-cart">
                            <i class="bi bi-cart-plus me-1"></i> Add to Cart
                        </button>
                    </form>
                </div>
            </div>
                <?php
                    }
                } else {
                    echo "<p>No books found for this category.</p>";
                }
                $conn->close();
                ?>
            </div>
        </div>
        </div>


    </body>

</html>