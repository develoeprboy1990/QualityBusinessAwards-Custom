<?php
// Database connection
$db_config = [
    'host' => '35.209.175.114',
    'port' => '5432',
    'dbname' => 'dbrsb9vqhcdnqn',
    'user' => 'uq5sl17zwkz9u',
    'password' => '&&m13fi$~%4,'
];

try {
    $dsn = "pgsql:host={$db_config['host']};port={$db_config['port']};dbname={$db_config['dbname']}";
    $pdo = new PDO($dsn, $db_config['user'], $db_config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    die("Database connection failed");
}

// Get URL parameters
$year = $_GET['year'] ?? '';
$slug = $_GET['slug'] ?? '';

// Build the original URL format to match database
$original_url = "https://qualitybusinessawards.ca/{$year}/{$slug}";

// Query the database for this URL
try {
    $stmt = $pdo->prepare("SELECT * FROM awards WHERE innerpage = ?");
    $stmt->execute([$original_url]);
    $award = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$award) {
        header("HTTP/1.0 404 Not Found");
        die("Award not found");
    }
} catch (PDOException $e) {
    error_log("Query failed: " . $e->getMessage());
    die("Error retrieving award information");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quality Business Award</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Oswald:wght@200..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://adriand138.sg-host.com/css/style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container col-md-9">
            <a class="navbar-brand" href="https://adriand138.sg-host.com/"><img src="https://adriand138.sg-host.com/images/logo-tran.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="https://adriand138.sg-host.com/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="https://adriand138.sg-host.com/about.html">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://adriand138.sg-host.com/request-consideration.html">Request Consideration</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://adriand138.sg-host.com/contact_us.html">Contact Us</a>
                    </li>
                </ul>
                <a href="https://adriand138.sg-host.com/search"><button class="btn" type="button">Search winner</button></a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="home_hero gym_lock" style="background-image: url(https://adriand138.sg-host.com/images/single-header.png);">
        <div class="container">
            <p>Find The Winners of The <span>2024 Quality Business Awards</span></p>
            <h2>QUALITY BUSINESS AWARDS</h2>
            <a href="https://adriand138.sg-host.com/search" class="btn">SEARCH WINNERS</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container col-md-9">
        <div class="press_release gym">
            <div class="row">
                <div class="col-md-6">
                    <div class="pressImg">
                        <img src="https://adriand138.sg-host.com/images/Design-1.jpg" alt="" class="img-fluid">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="press_desc">
                        <div class="common_title">
                            <p>Winner For The Best</p>
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li><svg class="detail-icon" viewBox="0 0 24 24">
                                            <path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2zM7 10.82C5.84 10.4 5 9.3 5 8V7h2v3.82zM19 8c0 1.3-.84 2.4-2 2.82V7h2v1z"></path>
                                        </svg> <?php echo htmlspecialchars($award['category']); ?></li>
                                        <li><svg class="detail-icon" viewBox="0 0 24 24">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"></path>
                                        </svg> <?php echo htmlspecialchars($award['city']); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <p>The Quality Business Awards recognizes businesses that achieve an average quality score of 95% or greater over the previous 12 months. To learn more about our selection criteria, please <a href="#">click here.</a></p>
                        <div class="highlighter">
                            <p>Our winner has been selected as the top performer in their category and location. From the whole team, we would like to congratulate them on their outstanding results.</p>
                        </div>
                        <div class="bottom_btn">
                            <a href="#" class="btn btn_fill">Feedback</a>
                            <a href="#" class="btn btn_outline">Scroll to see winner <svg class="arrow-icon" viewBox="0 0 24 24">
                                <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"></path>
                            </svg></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Award Display Section -->
        <div class="rated">
            <div class="card">
                <div class="card-body">
                    <div class="legend">#1 BEST RATED <?php echo htmlspecialchars($award['year']); ?></div>
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <div class="ward_logo">
                                <img src="https://adriand138.sg-host.com/images/2022-1.png" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h3><?php echo htmlspecialchars($award['business_name']); ?></h3>
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        <li><svg class="detail-icon" viewBox="0 0 24 24">
                                            <path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2zM7 10.82C5.84 10.4 5 9.3 5 8V7h2v3.82zM19 8c0 1.3-.84 2.4-2 2.82V7h2v1z"></path>
                                        </svg> <?php echo htmlspecialchars($award['category']); ?></li>
                                        <li><svg class="detail-icon" viewBox="0 0 24 24">
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"></path>
                                        </svg> <?php echo htmlspecialchars($award['city']); ?></li>
                                    </ul>
                                </div>
                            </div>
                            <p>We have awarded <?php echo htmlspecialchars($award['business_name']); ?> as The Best <?php echo htmlspecialchars($award['category']); ?> in <?php echo htmlspecialchars($award['city']); ?> for <?php echo htmlspecialchars($award['year']); ?>. An overall quality score exceeding 95% was achieved, making them the top ranked in <?php echo htmlspecialchars($award['city']); ?></p>
                        </div>
                        <div class="col-md-4">
                            <ul class="list-unstyled rating">
                                <li><img src="https://adriand138.sg-host.com/images/stars.png" alt=""> <span>Satisfaction</span></li>
                                <li><img src="https://adriand138.sg-host.com/images/stars.png" alt=""> <span>Service</span></li>
                                <li><img src="https://adriand138.sg-host.com/images/stars.png" alt=""> <span>Reputation</span></li>
                                <li><img src="https://adriand138.sg-host.com/images/stars.png" alt=""> <span>Quality</span></li>
                            </ul>
                        </div>
                        <div class="col-md-2">
                            <div class="bottom_btn">
                                <?php if (!empty($award['website']) && $award['website'] !== 'NULL'): ?>
                                    <a href="<?php echo htmlspecialchars($award['website']); ?>" class="btn btn_fill" target="_blank">Visit Website</a>
                                <?php endif; ?>
                                <a href="#" class="btn btn_outline">Click to verify</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="container col-md-9">
            <div class="top_area">
                <div class="row align-items-center">
                    <div class="col-md-2"><img src="https://adriand138.sg-host.com/images/qba-award-1024x938.png" alt="" class="img-fluid"></div>
                    <div class="col-md-5">
                        <div class="email">
                            <span><img src="https://adriand138.sg-host.com/images/email-icon.png" alt=""></span>
                            <h3>Email : <small>support@qualitybusinessawards.ca</small></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy_right">
            <div class="container col-md-9">
                <p>© Copyright 2025 by Quality Business Awards – All Rights Reserved</p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
</body>
</html>

