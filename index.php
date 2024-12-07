<?php 
require('includes/db-config.php'); 
// Fetch unique categories
$category_sql = "SELECT DISTINCT category FROM awards WHERE category IS NOT NULL ORDER BY category ASC";
$category_stmt = $pdo->query($category_sql);
$categories = $category_stmt->fetchAll(PDO::FETCH_COLUMN);

// Fetch unique years
$year_sql = "SELECT DISTINCT year FROM awards WHERE year IS NOT NULL ORDER BY year DESC";
$year_stmt = $pdo->query($year_sql);
$years = $year_stmt->fetchAll(PDO::FETCH_COLUMN);

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
<?php require('includes/header.php'); ?>
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
<div class="home_hero" style="background-image: url(images/header-bg.png);">
    <div class="container">
        <p>Find The Winners of The <span>2024 Quality Business Awards</span></p>
        <h2>QUALITY BUSINESS AWARDS</h2>
        <a href="/search" class="btn">SEARCH WINNERS</a>
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
      <a href="/search?city=&category=Accountants&year=2024">
        <img src="images/accountant.png" alt="">
        <p>Accountant</p>
      </a>
    </li>
    <li>
      <a href="/search?city=&category=Car+Dealer&year=2024">
        <img src="images/car.png" alt="">
        <p>Car Dealerships</p>
      </a>
    </li>
    <li>
      <a href="/search?city=&category=Business+Law&year=2024">
        <img src="images/business.png" alt="">
        <p>Business Law</p>
      </a>
    </li>
    <li>
      <a href="/search?city=&category=Insurance+Broker&year=2024">
        <img src="images/insurance.png" alt="">
        <p>Insurance</p>
      </a>
    </li>
    <li>
      <a href="/search?city=&category=Home+Cleaning&year=2024">
        <img src="images/home-clean.png" alt="">
        <p>Home Cleaning</p>
      </a>
    </li>
  </ul>
  <div class="request_btn">
    <a href="/search" class="btn">View All</a>
  </div>
</div>
</div>

<div class="about_business">
<div class="container col-md-9">
  <div class="col-md-8">
  <h2> <small>About</small>QUALITY BUSINESS AWARDS</h2>
  <p>Businesses that have won a quality business award represent less than 1% of registered businesses in Canada. This is the seal of quality that a business has achieved an overall quality score of 95% or greater.

    If you have won a quality business award, we congratulate you. your dedication to providing a quality product and maintaining an overall fantastic customer experience is recognized.</p>
    <a href="/about-us" class="btn">LEARN MORE</a>
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
      <div class="location_block">
        <div class="heading">
          <h2>Alberta</h2>
        </div><!--end of heading-->
        <div class="inner_cities_area">
        <ul class="list-unstyled">
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
          </svg> Airdrie</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
          </svg> Calgary</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg>Edmonton</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Grand Prairie</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Grande Prairie</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Lethbridge</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Medicine Hat</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Red Deer</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Sherwood Park</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> St. Albert</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Strathcona County</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Wood Buffalo</a></li>
        </ul>
        <div class="more_cities">
          <a href="#" class="btn">+77 more cities. SEE ALL <i class="fa  fa-long-arrow-right"></i></a>
        </div><!--end of more cities-->
      </div><!--END OF INNER CITIES AREA-->
      </div><!--end of location block-->

      <div class="location_block">
        <div class="heading">
          <h2>British Columbia</h2>
        </div><!--end of heading-->
        <div class="inner_cities_area">
        <ul class="list-unstyled">
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
          </svg> Abbotsford</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
          </svg> Burnaby</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg>Coquitlam</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Delta</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Kamloops</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Kelowna</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Langley</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Maple Ridge</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Nanaimo</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg>New Westminster</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg>North Vancouver</a></li>

          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Port Coquitlam</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Prince George</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Richmond</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Saanich</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Surrey</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Vancouver</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Victoria</a></li>

        </ul>
        <div class="more_cities">
          <a href="#" class="btn">+77 more cities. SEE ALL <i class="fa  fa-long-arrow-right"></i></a>
        </div><!--end of more cities-->
      </div><!--END OF INNER CITIES AREA-->
      </div><!--end of location block-->

      <div class="location_block">
        <div class="heading">
          <h2>Manitoba</h2>
        </div><!--end of heading-->
        <div class="inner_cities_area">
        <ul class="list-unstyled">
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
          </svg> Winnipeg</a></li>
    
        </ul>
        <div class="more_cities">
          <a href="#" class="btn">+77 more cities. SEE ALL <i class="fa  fa-long-arrow-right"></i></a>
        </div><!--end of more cities-->
      </div><!--END OF INNER CITIES AREA-->
      </div><!--end of location block-->

      <div class="location_block">
        <div class="heading">
          <h2>New Brunswick</h2>
        </div><!--end of heading-->
        <div class="inner_cities_area">
        <ul class="list-unstyled">
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
          </svg> Fredericton</a></li>

          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
          </svg> Moncton</a></li>

          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
          </svg> Saint John</a></li>
    
        </ul>
        <div class="more_cities">
          <a href="#" class="btn">+77 more cities. SEE ALL <i class="fa  fa-long-arrow-right"></i></a>
        </div><!--end of more cities-->
      </div><!--END OF INNER CITIES AREA-->
      </div><!--end of location block-->

      <div class="location_block">
        <div class="heading">
          <h2>Newfoundland and Labrador</h2>
        </div><!--end of heading-->
        <div class="inner_cities_area">
        <ul class="list-unstyled">
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
          </svg> St. John's</a></li>
    
        </ul>
        <div class="more_cities">
          <a href="#" class="btn">+77 more cities. SEE ALL <i class="fa  fa-long-arrow-right"></i></a>
        </div><!--end of more cities-->
      </div><!--END OF INNER CITIES AREA-->
      </div><!--end of location block-->

      
      <div class="location_block">
        <div class="heading">
          <h2>Nova Scotia</h2>
        </div><!--end of heading-->
        <div class="inner_cities_area">
        <ul class="list-unstyled">
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
          </svg> Cape Breton</a></li>

          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
          </svg> Halifax</a></li>
    
        </ul>
        <div class="more_cities">
          <a href="#" class="btn">+77 more cities. SEE ALL <i class="fa  fa-long-arrow-right"></i></a>
        </div><!--end of more cities-->
      </div><!--END OF INNER CITIES AREA-->
      </div><!--end of location block-->

      <div class="location_block">
        <div class="heading">
          <h2>Ontario</h2>
        </div><!--end of heading-->
        <div class="inner_cities_area">
        <ul class="list-unstyled">
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
          </svg> Ajax</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
          </svg> Aurora</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg>Barrie</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Belleville</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Bowmanville</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Brampton</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Brantford</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Burlington</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Caledon</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg>Cambridge</a></li>
          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg>Chatham-Kent</a></li>

          <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Clarington</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Greater Sudbury</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Guelph</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Halton Hills</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Hamilton</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Huntsville</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Kawartha Lakes</a></li>



      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Kingston</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Kitchener</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> London</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Markham</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Milton</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Mississauga</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Newmarket</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Niagara Falls</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Norfolk County</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> North Bay</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Oakville</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Orangeville</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Oshawa</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Ottawa</a></li>


      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Peterborough</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Pickering</a></li>
      
      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Richmond Hill</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Sarnia</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Sault Ste. Marie</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> St. Catharines</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Thunder Bay</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Toronto</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Vaughan</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Waterloo</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Welland</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Whitby</a></li>

      <li><a href="#"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 0C7.58 0 4 3.58 4 8c0 5.25 8 13 8 13s8-7.75 8-13c0-4.42-3.58-8-8-8zm0 11c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"></path>
      </svg> Windsor</a></li>

        </ul>
        <div class="more_cities">
          <a href="#" class="btn">+77 more cities. SEE ALL <i class="fa  fa-long-arrow-right"></i></a>
        </div><!--end of more cities-->
      </div><!--END OF INNER CITIES AREA-->
      </div><!--end of location block-->

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
      </div><!--end of location block-->
    </div><!--END OF CONTAINER-->
</div><!--END OF BG-->
<?php require('includes/footer.php'); ?>
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