<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookNext – Your Online Bookstore</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg,
                    #1a1a1a 0%,
                    /* very dark gray */
                    rgb(12, 14, 24) 50%,
                    #0f1013 100%
                    /* pure black */
                );
            color: white;

        }


        .book-card img {
            height: 250px;
            object-fit: cover;
        }




        .navbar-nav .nav-link {
            color: white;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #ffc107;
            text-decoration: underline;
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
        }

        .book-card {
            width: 100%;
            max-width: 300px;
            transition: transform 0.3s ease;
        }

        .book-card:hover {
            transform: scale(1.03);
        }

        .about-section {

            color: #f0f0f0;
            /* light text for contrast */
            padding: 60px 20px;
            border-radius: 15px;
            width: 100%;
        }

        .arrow-animation i {
            display: inline-block;
            animation: slideArrow 1s infinite alternate;
        }

        @keyframes slideArrow {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(5px);
            }
        }

        .sidebar {
            background: linear-gradient(135deg,
                    #1a1a1a 0%,
                    /* very dark gray */
                    rgb(12, 14, 24) 50%,
                    #0f1013 100%
                    /* pure black */
                );
            border-right: 2px solid #ccc;
        }

        /* Nav Link Styles */
        .sidebar .nav-link {
            font-weight: 500;
            color: #f9faf7;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s ease-in-out;
            backdrop-filter: blur(5px);
            /* Optional: slight glass effect */
        }

        /* Hover Effect */
        .sidebar .nav-link:hover {
            background-color: #FFD700;
            /* Yellow */
            color: #fff;
            box-shadow: 0 0 10px #FFD700;
            transform: translateX(5px);
        }

        /* Active Link */
        .sidebar .nav-link.active {
            background-color: #FFC107;
            color: #e5e7e1;
            font-weight: 600;
            box-shadow: 0 0 10px #FFC107;
        }

        /* Smooth transition */
        .sidebar .nav-link,
        .sidebar .nav-link.active {
            transition: background-color 0.3s, color 0.3s, box-shadow 0.3s, transform 0.3s;
        }

        .card_books {
            background-color: #FFC107;

        }

        .learn-more-btn {
            transition: all 0.3s ease;
        }

        .learn-more-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .blurred-footer {
            position: relative;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        /* Background Image Layer */
        .blurred-footer::before {
            content: "";
            position: absolute;
            inset: 0;
            background: url('assets/books.jpg') center/cover no-repeat;
            filter: blur(10px);
            transform: scale(1.1);
            z-index: 0;
        }

        /* Ensure Footer Content is above Blur */
        .blurred-footer .container {
            position: relative;
            z-index: 1;
        }

        /* Footer Links Hover Effect */
        .footer-link {
            color: #fff;
            text-decoration: none;
            position: relative;
        }

        .footer-link::after {
            content: "";
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #FFD700;
            transition: width 0.3s;
        }

        .footer-link:hover::after {
            width: 100%;
        }

        /* Social Icons Glow */
        .social-icon {
            color: #ffffff;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            color: #FFD700;
            text-shadow: 0 0 10px #FFD700;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


    <nav class="navbar navbar-expand-lg navbar-primary sticky-top shadow-sm px-4 rounded-1 ">
        <a class="navbar-brand fw-semibold d-flex align-items-center text-light fs-2" href="#">
            <i class="bi bi-book-half text-light me-3 fs-1 "></i> BookNext
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-3 fs-5 text-light">
                <li class="nav-item">
                    <a class="nav-link " href="#home">
                        <i class="bi bi-house-door me-2 fs-3"></i>Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">
                        <i class="bi bi-box-arrow-in-right me-2 fs-3"></i>Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="catalogue.php">
                        <i class="bi bi-book me-2 fs-3"></i>Catalogue
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="#cart">
                        <i class="bi bi-cart me-2 fs-3 text-warning"></i>Cart
                    </a>
                </li>

            </ul>

        </div>
    </nav>

    <!-- Hero Section -->

    <div class=" container-fluid position-relative z-1">
        <div class="row align-items-center h-100">

            <!-- Left Column (Video) -->
            <div class="col-md-8  p-3 h-100 ">
                <video autoplay muted loop playsinline class="w-100 h-100 object-fit-cover rounded">
                    <source src="assets/bg_v.mp4" type="video/mp4" />
                    Your browser does not support the video tag.
                </video>
            </div>

            <!-- Right Column (Content) -->
            <div class="col-md-4 d-flex flex-column justify-content-center align-items-center text-center px-5">
                <div class="d-flex justify-content-center">
                    <h1 class="display-4 fw-bold text-center">
                        <span class="text-warning">Welcome</span>
                        <span class="ms-2">to BookNext</span>
                    </h1>
                </div>
                <p class="lead">Your one-stop destination for every kind of book</p>

                <!-- Button Centered Horizontally -->
                <div class="d-flex w-100 justify-content-center">
                    <a href="login.php" class="btn btn-warning btn-lg mt-4 d-inline-flex align-items-center">
                        Browse Books
                        <span class="ms-2 d-inline-flex arrow-animation">
                            <i class="fas fa-angle-double-right"></i>
                            <i class="fas fa-angle-double-right ms-1"></i>
                        </span>
                    </a>
                </div>
            </div>

        </div>
    </div>
    <div class="container-fluid mt-5">
        <div class="row">
            <!-- Left Sidebar (Departments List) -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar vh-100 p-3">
                <h5 class="text-center fw-bold mt-5">Departments</h5>
                <ul class="nav flex-column mt-4">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Computer Science</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Electronics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Mechanical</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Civil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Physics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Chemistry</a>
                    </li>
                    <!-- Add more departments as needed -->
                </ul>
            </nav>

            <!-- Main Content Area -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5">
                <!-- Hero Banner -->
                <div class="pt-5 text-center  rounded shadow-sm">
                    <h1 class="display-5 fw-bold">BookNext A Endless Next</h1>

                    <p class=" fs-3 lead text-light">Explore a world of knowledge and stories. Find your next read
                        today!</p>
                </div>


                <!-- Featured Categories -->
                <section class="mt-0">
                    <section
                        style="background-image: url('assets/darkbg.jpg'); background-size: cover; background-position:center; height: 300px;">
                        <!-- Your content here -->
                    </section>
                    <div class="row g-4 mt-2">
                        <div class="col-md-4">
                            <div class="card card_books text-center h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title text-decoration-underline fw-bold">Fiction</h5>
                                    <p class="card-text text-dark">Dive into imaginative worlds and thrilling stories.
                                    </p>
                                    <a href="#" class="btn btn-outline-primary btn-sm">Explore</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center h-100 shadow-sm ">
                                <div class="card-body">
                                    <h5 class="card-title text-decoration-underline fw-bold">Academics</h5>
                                    <p class="card-text text-dark">Resources for students and professionals alike.</p>
                                    <a href="#" class="btn btn-outline-primary btn-sm">Explore</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center h-100 shadow-sm card_books">
                                <div class="card-body">
                                    <h5 class="card-title text-decoration-underline fw-bold">Self-Help</h5>
                                    <p class="card-text text-dark ">Inspiration and guides for personal growth.</p>
                                    <a href="#" class="btn btn-outline-primary btn-sm">Explore</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


            </main>

        </div>
    </div>
    <!--  -->
    <section class="container my-5">
        <div class="row align-items-center">
            <!-- Left Side Image -->
            <div class="col-md-6 mb-4 mb-md-0 text-center">
                <img src="assets/bg.jpg" alt="Reading Books" class="img-fluid rounded-4 shadow"
                    style="max-width: 100%; height: auto;">
            </div>

            <!-- Right Side Content -->
            <div class="col-md-6">
                <h2 class="fw-bold mb-4">About <span class="text-warning">BookNext</span></h2>
                <p class="lead text-light mb-3">
                    At BookNext, we believe every book tells a story beyond its pages, opening doors to imagination,
                    knowledge, and adventure.
                </p>
                <p class=" lead text-light">
                    With thousands of titles, curated collections, and personalized recommendations, we ensure that
                    readers of all ages find their perfect read.
                    Experience a seamless journey from browsing to delivery.
                </p>
                <a href="about.php" class="btn btn-warning btn-lg mt-3 px-4 py-2 shadow-sm learn-more-btn">Learn
                    More</a>
            </div>
        </div>
    </section>




    <footer class="blurred-footer text-light pt-5 pb-3">
        <div class="container position-relative z-1">
            <div class="row gy-4">

                <!-- Company Info -->
                <div class="col-md-4">
                    <h4 class="fw-bold">📚 Book Haven</h4>
                    <p class="small text-light">
                        Discover stories, knowledge, and experiences with our vast collection of books.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="col-md-2">
                    <h5 class="fw-semibold mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Home</a></li>
                        <li><a href="#" class="footer-link">Catalogue</a></li>
                        <li><a href="#" class="footer-link">Offers</a></li>
                        <li><a href="#" class="footer-link">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-md-3">
                    <h5 class="fw-semibold mb-3">Contact</h5>
                    <p class="small mb-1">📞 +91-98765-43210</p>
                    <p class="small mb-1">📧 support@bookhaven.com</p>
                    <p class="small">🕒 9 AM - 8 PM (Mon-Sat)</p>
                </div>

                <!-- Social Icons -->
                <div class="col-md-3">
                    <h5 class="fw-semibold mb-3">Follow Us</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

            </div>

            <hr class="my-4 border-light">

            <div class="text-center small text-muted">
                © 2025 Book Haven. All Rights Reserved.
            </div>
        </div>
    </footer>


    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    const swiper = new Swiper('.mySwiper', {
        loop: true,
        grabCursor: true,
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        slidesPerView: 1,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            992: {
                slidesPerView: 3,
            }
        }
    });
</script>


</html>