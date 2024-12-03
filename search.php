<?php
// Database connection
$db_config = [
    'host' => '35.209.175.114',
    'port' => '5432',
    'dbname' => 'dbrsb9vqhcdnqn',
    'user' => 'uq5sl17zwkz9u',
    'password' => '&&m13fi$~%4,'
];

// Pagination settings
$results_per_page = 20;
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($current_page - 1) * $results_per_page;

try {
    $dsn = "pgsql:host={$db_config['host']};port={$db_config['port']};dbname={$db_config['dbname']}";
    $pdo = new PDO($dsn, $db_config['user'], $db_config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch unique categories
    $category_sql = "SELECT DISTINCT category FROM awards WHERE category IS NOT NULL ORDER BY category ASC";
    $category_stmt = $pdo->query($category_sql);
    $categories = $category_stmt->fetchAll(PDO::FETCH_COLUMN);

    // Fetch unique years
    $year_sql = "SELECT DISTINCT year FROM awards WHERE year IS NOT NULL ORDER BY year DESC";
    $year_stmt = $pdo->query($year_sql);
    $years = $year_stmt->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Prepare search parameters
$business_name = isset($_GET['business_name']) ? trim($_GET['business_name']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$year = isset($_GET['year']) ? intval($_GET['year']) : '';
$city = isset($_GET['city']) ? trim($_GET['city']) : '';
$state = isset($_GET['state']) ? trim($_GET['state']) : '';

$results = [];
$total_results = 0;
$show_pagination = false;

if (!empty($business_name) || !empty($category) || !empty($year) || !empty($city) || !empty($state)) {
    try {
        // Base query
        $count_sql = "SELECT COUNT(*) FROM awards WHERE 1=1";
        $search_sql = "SELECT * FROM awards WHERE 1=1";
        $params = [];

        // Add filters
        if ($business_name) {
            $count_sql .= " AND business_name ILIKE :business_name";
            $search_sql .= " AND business_name ILIKE :business_name";
            $params[':business_name'] = "%$business_name%";
        }
        if ($category) {
            $count_sql .= " AND category ILIKE :category";
            $search_sql .= " AND category ILIKE :category";
            $params[':category'] = "%$category%";
        }
        if ($year) {
            $count_sql .= " AND year = :year";
            $search_sql .= " AND year = :year";
            $params[':year'] = $year;
        }
        if ($city) {
            $count_sql .= " AND city ILIKE :city";
            $search_sql .= " AND city ILIKE :city";
            $params[':city'] = "%$city%";
        }
        if ($state) {
            $count_sql .= " AND state ILIKE :state";
            $search_sql .= " AND state ILIKE :state";
            $params[':state'] = "%$state%";
        }

        // Execute count query
        $count_stmt = $pdo->prepare($count_sql);
        foreach ($params as $key => $value) {
            $count_stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $count_stmt->execute();
        $total_results = $count_stmt->fetchColumn();

        // Pagination
        $total_pages = ceil($total_results / $results_per_page);
        $show_pagination = $total_pages > 1;

        // Execute search query with pagination
        $search_sql .= " ORDER BY year DESC, business_name LIMIT :limit OFFSET :offset";
        $search_stmt = $pdo->prepare($search_sql);
        foreach ($params as $key => $value) {
            $search_stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $search_stmt->bindValue(':limit', $results_per_page, PDO::PARAM_INT);
        $search_stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $search_stmt->execute();
        $results = $search_stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Search Error: " . $e->getMessage());
        $error = "An error occurred while searching.";
    }
}

// Function to generate pagination URL
function get_pagination_url($page) {
    $params = $_GET;
    $params['page'] = $page;
    return '?' . http_build_query($params);
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
    <link rel="stylesheet" href="css/style.css">
    <style>
        .autocomplete-suggestions {
            border: 1px solid #ddd;
            background: white;
            overflow: auto;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: absolute;
            z-index: 9999;
            max-height: 200px;
            width: 100%;
            border-radius: 0.5rem;
            margin-top: -1px;
        }
        .autocomplete-suggestion {
            padding: 8px 15px;
            cursor: pointer;
        }
        .autocomplete-suggestion:hover {
            background-color: #f0f0f0;
        }
        .search-container {
            position: relative;
        }
        .search_result {
            padding: 20px 0;
        }
        .result-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .award-icon {
            width: 80px;
            height: auto;
            margin-right: 20px;
        }
        .business-info {
            flex-grow: 1;
        }
        .business-name {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .business-meta {
            display: flex;
            gap: 20px;
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .meta-icon {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }
        .view-btn {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .view-btn:hover {
            background-color: #0056b3;
            color: white;
        }
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        .pagination a {
            padding: 8px 12px;
            background: #f8f9fa;
            border-radius: 5px;
            text-decoration: none;
            color: #007bff;
        }
        .pagination a.active {
            background: #007bff;
            color: white;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container col-md-9">
          <a class="navbar-brand" href="https://adriand138.sg-host.com/"><img src="images/logo-tran.png" alt=""></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="https://adriand138.sg-host.com/">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="#">About us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="request-consideration.html">Request Consideration</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact_us.html">Contact Us</a>
              </li>
            </ul>
              <a href="search"><button class="btn" type="button">Search winner</button></a>
          </div><!--END OF COLLAPSE-->
        </div><!--end of container-->
      </nav>

    <div class="home_hero search_banner" style="background-image: url(images/header-bg.png);">
        <div class="container">
            <p>Find The Winners of The <span>2024 Quality Business Awards</span></p>
            <h2>QUALITY BUSINESS AWARDS</h2>
            <a href="search" class="btn">SEARCH WINNERS</a>
        </div><!--END OF CONTAINER-->
    </div><!--END OF HOME HERO-->
    <div class="on_banner_search">
        <div class="container col-md-9">
          <div class="row justify-content-center">
            <div class="col-md-9">
              <div class="businessQuality_finder">
                <h3>Find The Winners of <span>Quality Business Awards</span> By City ?</h3>
                <form class="searh_form" method="GET">
                    <div class="search-container">
                        <input type="text" class="form-control" name="city" id="city" placeholder="Search City" value="<?php echo htmlspecialchars($city); ?>">
                        <div id="city_suggestions" class="autocomplete-suggestions"></div>
                    </div>
                    
                    <select class="form-select" name="category">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>" 
                                    <?php echo ($category === $cat) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <select class="form-select" name="year">
                        <?php foreach ($years as $yr): ?>
                            <option value="<?php echo htmlspecialchars($yr); ?>" 
                                    <?php echo ($year == $yr) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($yr); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" class="btn" value="SEARCH NOW">
                </form> 
                <div class="or"><span>OR</span></div><!--end of or-->

                <form class="searh_form" method="GET">
                    <div class="search-container"> 
                        <input type="text" class="form-control" name="business_name" id="business_name" placeholder="Search by business name" value="<?php echo htmlspecialchars($business_name); ?>">
                        <div id="business_suggestions" class="autocomplete-suggestions"></div>
                    </div>
                    <input type="submit" class="btn" value="SEARCH NOW">
                </form> 
            </div>
            </div><!--end of col md 9-->
          </div><!--end of row-->
        </div><!--end of container-->
    </div><!--end of on banner search-->

    <div class="container col-md-9">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <section class="search_result">
                    <?php if (!empty($results)): ?>
                    <?php foreach ($results as $result): ?>
                    <div class="result-card">
                        <img src="images/2024.png" alt="2024 Winner" class="award-icon">
                        <div class="business-info">
                            <div class="business-name"><?php echo htmlspecialchars($result['business_name']); ?></div>
                            <div class="business-meta">
                                <div class="meta-item">
                                    <svg class="meta-icon" viewBox="0 0 24 24">
                                      <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
                                    </svg>
                                    <?php echo htmlspecialchars($result['category']); ?>
                                </div>
                                <div class="meta-item">
                                    <svg class="meta-icon" viewBox="0 0 24 24">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 010-5 2.5 2.5 0 010 5z"></path>
                                    </svg>
                                    <?php echo htmlspecialchars($result['city'] . ', ' . $result['state']); ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $url = $result['innerpage'];
                        // Remove domain if it exists
                        $url = preg_replace('#^https?://[^/]+#', '', $url);
                        ?>
                        <a href="<?php echo htmlspecialchars($url); ?>" class="view-btn">View Page</a>
                    </div>
                    <?php endforeach; ?>

                    <?php if ($show_pagination): ?>
                    <div class="pagination">
                    <?php if ($current_page > 1): ?>
                    <a href="<?php echo get_pagination_url($current_page - 1); ?>">Previous</a>
                    <?php endif; ?>

                    <?php for ($i = 1; i <= $total_pages; $i++): ?>
                    <a href="<?php echo get_pagination_url($i); ?>" 
                    class="<?php echo ($current_page === $i) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                    </a>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                    <a href="<?php echo get_pagination_url($current_page + 1); ?>">Next</a>
                    <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php elseif (isset($_GET['business_name']) || isset($_GET['city'])): ?>
                    <p class="text-center">No results found. Please try different search criteria.</p>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container col-md-9">
            <div class="top_area">
              <div class="row align-items-center">
                <div class="col-md-2"><img src="images/qba-award-1024x938.png" alt="" class="img-fluid"></div><!--end of col md 2-->
                <div class="col-md-5">
                  <div class="email">
                   <span><img src="images/email-icon.png" alt=""></span>
                   <h3>Email : <small>support@qualitybusinessawards.ca</small></h3>
                  </div><!--end of email-->
                </div><!--end of col md 5-->
              </div><!--end of row-->
            </div><!--end of top area-->
        </div><!--END OF CONTAINER--> 
        <div class="copy_right">
          <div class="container col-md-9">
            <p>© Copyright 2025 by Quality Business Awards – All Rights Reserved</p>
          </div><!--END OF CONTAINER--> 
        </div><!--end of copy right-->
      </div><!--END OF FOOTER-->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>

    <script>
    $(document).ready(function() {
        function setupAutocomplete(inputId, suggestionBoxId, type) {
            $('#' + inputId).on('input', function() {
                let term = $(this).val();
                if (term.length > 1) {
                    $.ajax({
                        url: 'autocomplete.php',
                        method: 'GET',
                        data: { 
                            term: term,
                            type: type
                        },
                        success: function(data) {
                            let suggestions = JSON.parse(data);
                            let suggestionBox = $('#' + suggestionBoxId);
                            suggestionBox.empty();
                            suggestions.forEach(function(item) {
                                suggestionBox.append('<div class="autocomplete-suggestion">' + item + '</div>');
                            });
                        }
                    });
                } else {
                    $('#' + suggestionBoxId).empty();
                }
            });
        }

        setupAutocomplete('business_name', 'business_suggestions', 'business');
        setupAutocomplete('city', 'city_suggestions', 'city');

        $(document).on('click', '.autocomplete-suggestion', function() {
            let input = $(this).closest('.search-container').find('input');
            input.val($(this).text());
            $(this).parent().empty();
        });

        $(document).click(function(event) {
            if (!$(event.target).closest('.search-container').length) {
                $('.autocomplete-suggestions').empty();
            }
        });
    });
    </script>
</body>
</html>
