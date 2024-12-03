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

// Handle search form submission
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    // Perform database query based on $searchTerm
    // Example query:
    $stmt = $pdo->prepare("SELECT * FROM awards WHERE business_name ILIKE :term LIMIT 10");
    $stmt->execute([':term' => "%$searchTerm%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            max-height: 200px;
            overflow-y: auto;
            background-color: white;
            position: absolute;
            z-index: 1000;
            width: 100%;
            border-radius: 0.5rem;
        }
        .autocomplete-suggestion {
            padding: 0.5rem;
            cursor: pointer;
        }
        .autocomplete-suggestion:hover {
            background-color: #f0f0f0;
        }
        .search-container {
            position: relative;
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
            <ul class="navbar-nav ms-auto  mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="https://adriand138.sg-host.com">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.html">About us</a>
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

    <div class="home_hero" style="background-image: url(images/header-bg.png);">
        <div class="container">
            <p>Find The Winners of The <span>2024 Quality Business Awards</span></p>
            <h2>QUALITY BUSINESS AWARDS</h2>
            <a href="search" class="btn">SEARCH WINNERS</a>
        </div>
    </div>
      <div class="welcome">
        <div class="container col-md-9">
          <div class="title">
            <h2><span>Highest Quality</span> Canadian Businesses</h2>
            <p>Recognizing the Top companies in Canada that had an overall Quality score of <strong>95% or Greater</strong></p>
          </div>
          <ul class="list-unstyled">
            <li>
              <a href="#">
                <img src="images/accountant.png" alt="">
                <p>Accountant</p>
              </a>
            </li>
            <li>
              <a href="#">
                <img src="images/car.png" alt="">
                <p>Car Dealerships</p>
              </a>
            </li>
            <li>
              <a href="#">
                <img src="images/business.png" alt="">
                <p>Business Law</p>
              </a>
            </li>
            <li>
              <a href="#">
                <img src="images/insurance.png" alt="">
                <p>Insurance</p>
              </a>
            </li>
            <li>
              <a href="#">
                <img src="images/home-clean.png" alt="">
                <p>Home Cleaning</p>
              </a>
            </li>
          </ul>
          <div class="request_btn">
            <a href="#" class="btn">REQUEST CONSIDERATION</a>
          </div>
        </div>
      </div>

      <div class="about_business">
        <div class="container col-md-9">
          <div class="col-md-8">
          <h2> <small>About</small>QUALITY BUSINESS AWARDS</h2>
          <p>Businesses that have won a quality business award represent less than 1% of registered businesses in Canada. This is the seal of quality that a business has achieved an overall quality score of 95% or greater.

            If you have won a quality business award, we congratulate you. your dedication to providing a quality product and maintaining an overall fantastic customer experience is recognized.</p>
            <a href="#" class="btn">GET STARTED NOW</a>
          </div>
        </div>
      </div>

      <div class="container col-md-9">
        <div class="business_quality">
            <div class="row justify-content-center">
              <div class="col-md-9">
                <div class="title">
                  <h2><small>TOP OF CLASS</small>HIGHEST QUALITY BUSINESSES</h2>
                </div>

                <div class="businessQuality_finder">
                    <h3>Find The Winners of <span>Quality Business Awards</span> By City ?</h3>
                    <form class="searh_form" action="search" method="GET">
                       
                        <div class="search-container">
                            <input type="text" class="form-control" name="city" id="city" placeholder="Search City" value="<?php echo htmlspecialchars($city); ?>">
                            <div id="city_suggestions" class="autocomplete-suggestions"></div>
                        </div>

                        <select class="form-select"  name="category">
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
                    <div class="or"><span>OR</span></div>

                    <form class="searh_form" action="search" method="GET">
                        <div class="search-container">
                            <input type="text" class="form-control" name="business_name" id="business_name" placeholder="Search by business name"  value="<?php echo htmlspecialchars($business_name); ?>">
                            <div id="business_suggestions" class="autocomplete-suggestions"></div>
                        </div>
                        <input type="submit" class="btn" value="SEARCH NOW">
                    </form> 
                </div>
              </div>
            </div>
        </div>
      </div>

    <div class="bg">
        <div class="container">
          <!-- Location blocks -->
          <div class="location_block">
            <div class="heading">
              <h2>Alberta</h2>
            </div>
            <div class="inner_cities_area">
            <ul class="list-unstyled">
              <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
              </svg> Calgary</a></li>
            </ul>
            </div>
          </div>

          <div class="location_block">
            <div class="heading">
              <h2>Saskatchewan</h2>
            </div><!--end of heading-->
            <div class="inner_cities_area">
            <ul class="list-unstyled">
              <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
              </svg> Regina</a></li>

              <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
              </svg> Saskatoon</a></li>
        
            </ul>
            <div class="more_cities">
              <a href="#" class="btn">+77 more cities. SEE ALL <i class="fa  fa-long-arrow-right"></i></a>
            </div><!--end of more cities-->
          </div><!--END OF INNER CITIES AREA-->
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
