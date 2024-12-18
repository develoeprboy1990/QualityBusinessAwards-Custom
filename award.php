<?php
// Database connection
require('includes/db-config.php'); 

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
<?php require('includes/header.php'); ?>
<!-- Hero Section -->
<div class="home_hero gym_lock" style="background-image: url(/images/single-header.png);">
    <div class="container">
        <p>Find The Winners of The <span>2024 Quality Business Awards</span></p>
        <h2>QUALITY BUSINESS AWARDS</h2>
        <a href="/search" class="btn">SEARCH WINNERS</a>
    </div>
</div>

<!-- Main Content -->
<div class="container col-md-9">
    <div class="press_release gym award_winner">
        <div class="row">
            
            <div class="col-md-7">
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
                    <p>The Quality Business Awards recognizes businesses that achieve an average quality score of 95% or greater over the previous 12 months. To learn more about our selection criteria, please <a href="/about-us">click here.</a></p>
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
            <div class="col-md-5">
                <div class="pressImg">
                    <img src="/images/Design-<?php echo htmlspecialchars($award['year']); ?>.jpg" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Award Display Section -->
    <div class="rated">
          <div class="card">
            <div class="card-body">
              <div class="legend">#1 BEST RATED <?php echo htmlspecialchars($award['year']); ?></div><!--end of legend-->
              <div class="row align-items-center">
                <div class="col-md-3">
                  <div class="ward_logo">
                    <img src="/images/winner_award.svg" alt="" class="img-fluid">
                  </div><!--end of award logo-->
                </div><!--end col md 3-->
                <div class="col-md-9">
                 
                  <div class="card">
                    <h3><?php echo htmlspecialchars($award['business_name']); ?></h3>
                    <div class="card-body">
                      <ul class="list-unstyled">
                        <li> <img src="/images/cup.svg" alt=""><?php echo htmlspecialchars($award['category']); ?></li>
                        <li> <img src="/images/address.svg" alt=""><?php echo htmlspecialchars($award['city']); ?></li>
                        <li> <img src="/images/address.svg" alt=""><?php echo htmlspecialchars($award['address']); ?></li>
                      </ul>
                    </div><!--end of card body-->
                  </div><!--end of card-->
                  <p>We have awarded <?php echo htmlspecialchars($award['business_name']); ?> as The Best <?php echo htmlspecialchars($award['category']); ?> in <?php echo htmlspecialchars($award['city']); ?> for <?php echo htmlspecialchars($award['year']); ?>. An overall quality score exceeding 95% was achieved, making them the top ranked in <?php echo htmlspecialchars($award['city']); ?></p>
                
                  <div class="row">
                    <div class="col-md-8">
                      <ul class="list-unstyled rating">
                        <li><img src="/images/stars.svg" alt=""> <span>Satisfaction</span></li>
                        <li><img src="/images/stars.svg" alt=""> <span>Service</span></li>
                        <li><img src="/images/stars.svg" alt=""> <span>Reputation</span></li>
                        <li><img src="/images/stars.svg" alt=""> <span>Quality</span></li>
                      </ul>
                    </div><!--end of col md 8-->
                    <div class="col-md-4">
                      <div class="bottom_btn">
                        <?php if (!empty($award['website']) && $award['website'] !== 'NULL'): ?>
                                <a href="<?php echo htmlspecialchars($award['website']); ?>" class="btn btn_fill" target="_blank">Visit Website</a>
                            <?php endif; ?>
                        <a href="#" class="btn btn_outline">Click to verify</a>
                      </div>
                    </div><!--end of col md 4-->
                  </div><!--end of row-->

                 
                
                </div><!--end of col md 9-->

              </div><!--end of row-->
            </div><!--end of card body-->
          </div><!--end of card-->
        </div><!--end of rated-->
</div>

<section class="judging_pannel">
        <div class="container">
          <div class="title"><h2><span>QUALITY</span> RECOGNITION</h2> <p>Representing less than 1% of registered businesses in the USA</p></div><!--end of title-->
          <div class="row">
            <div class="col-md-3">
              <div class="inner_jugdes">
                <div class="stat-icon">
                  <svg viewBox="0 0 24 24">
                      <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"></path>
                  </svg>
              </div>
                    <h4>10,000+</h4>
                    <p>Trusted Authority <small>Businesses evaluated nationwide</small></p>
              </div><!--end of inner judging-->
            </div><!--end of col md 3-->

            <div class="col-md-3">
              <div class="inner_jugdes">
                <div class="stat-icon">
                  <svg viewBox="0 0 24 24">
                      <path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"></path>
                  </svg>
              </div>
                    <h4>50+ States</h4>
                    <p>Panel Member <small>Representing excellence across America</small></p>
              </div><!--end of inner judging-->
            </div><!--end of col md 3-->

            <div class="col-md-3">
              <div class="inner_jugdes">
                <div class="stat-icon">
                  <svg viewBox="0 0 24 24">
                      <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                  </svg>
              </div>
                    <h4>95%+</h4>
                    <p>Quality Score <small>Required for consideration</small></p>
              </div><!--end of inner judging-->
            </div><!--end of col md 3-->

            <div class="col-md-3">
              <div class="inner_jugdes">
                <div class="stat-icon">
                  <svg viewBox="0 0 24 24">
                      <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14h-2v-2h2v2zm0-4h-2V7h2v6z"></path>
                  </svg>
              </div>
                    <h4>3+</h4>
                    <p>Review Sources <small>Multiple platform verification</small></p>
              </div><!--end of inner judging-->
            </div><!--end of col md 3-->

          </div><!--end of row-->
        </div><!--end of continer-->
      </section>


<?php require('includes/footer.php'); ?>