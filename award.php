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
        <p>Find The Winners of The <span>2025 Quality Business Awards</span></p>
        <h2>QUALITY BUSINESS AWARDS</h2>
        <a href="/search" class="btn">SEARCH WINNERS</a>
    </div>
</div>
<style>
        /* Your existing styles remain exactly the same until the modal styles */
        .award-container {
            max-width: 1200px;
            margin: 20px auto;
            border: 2px solid #FFB800;
            border-radius: 15px;
            padding: 40px;
            position: relative;
            font-family: Arial, sans-serif;
        }

        .top-banner {
            background-color: #1e54a9;
            color: white;
            padding: 10px 40px;
            border-radius: 25px;
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            font-weight: bold;
            font-size: 1.2em;
            white-space: nowrap;
        }

        .content-wrapper {
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 40px;
            align-items: start;
        }

        .award-image {
            width: 180px;
            height: auto;
            padding-top: 35px;
        }

        .business-info {
            padding-top: 0;
        }

        .business-name {
            color: #FFB800;
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .category-section {
            background: #f8f9fa;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .category-details {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .detail-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .detail-icon {
            width: 24px;
            height: 24px;
            fill: #FFB800;
        }

        .category-text, .location-text {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2c3338;
        }

        .description {
            line-height: 1.5;
            max-width: 600px;
            color: #555;
            margin-top: 2rem;
            font-size: 1.1rem;
        }

        .right-section {
            display: flex;
            gap: 30px;
            align-items: start;
        }

        .ratings-section {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 45px;
        }

        .rating-item {
            display: flex;
            align-items: center;
            gap: 10px;
            height: 24px;
        }

        .stars {
            color: #FFB800;
            letter-spacing: 2px;
        }

        .rating-label {
            font-weight: bold;
            font-size: 1.1em;
        }

        .buttons-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 75px;
        }

        .visit-button, .verify-button {
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            white-space: nowrap;
        }

        .visit-button {
            background-color: #FFB800;
            color: white;
        }

        .verify-button {
            background-color: #f0f5ff;
            color: #1e54a9;
            border: 1px solid #1e54a9;
            font-size: 0.9em;
            cursor: pointer;
        }

        .verify-button:hover {
            background-color: #e6eeff;
        }

        @media (max-width: 768px) {
            .award-container {
                padding: 30px 20px;
                margin: 30px 10px;
            }

            .content-wrapper {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .award-image {
                width: 140px;
                padding-top: 20px;
                margin: 0 auto;
            }

            .business-name {
                text-align: center;
            }

            .category-section {
                text-align: center;
            }

            .detail-row {
                justify-content: center;
            }

            .description {
                text-align: center;
                font-size: 0.9em;
            }

            .right-section {
                flex-direction: column;
                align-items: center;
                gap: 20px;
            }

            .ratings-section {
                margin-top: 20px;
                width: 100%;
            }

            .rating-item {
                justify-content: center;
            }

            .buttons-container {
                margin-top: 20px;
                width: 100%;
            }

            .top-banner {
                font-size: 1em;
                padding: 8px 20px;
            }

            .category-text, .location-text {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 480px) {
            .award-container {
                padding: 20px 15px;
            }

            .business-name {
                font-size: 1.3em;
            }

            .category-text, .location-text {
                font-size: 1.2rem;
            }

            .rating-label {
                font-size: 1em;
            }

            .top-banner {
                font-size: 0.9em;
                padding: 6px 15px;
            }
        }

        /* Modal Styles */
        .verification-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .verification-content {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            width: 80%;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .verification-content h3 {
            margin-bottom: 20px;
        }

        .progress-bar {
            width: 100%;
            background-color: #f3f3f3;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .progress-bar-fill {
            height: 20px;
            width: 0;
            background-color: #4CAF50;
            border-radius: 5px;
            transition: width 0.5s ease-in-out;
        }

        .verification-content ul {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }

        .verification-content ul li {
            text-align: left;
            margin-bottom: 10px;
            font-size: 1em;
        }

        .verification-content ul li:before {
            content: '\2714\0020';
            color: #4CAF50;
        }

        .identity-verified {
            font-size: 1.2em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .identity-verified img {
            width: 24px;
            height: 24px;
        }

        .close-modal {
            background-color: #f0a500;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s;
            cursor: pointer;
            margin-top: 20px;
        }

        .close-modal:hover {
            background-color: #d48806;
        }
    </style>
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
                        <a href="/suggest-edit?id=<?php echo htmlspecialchars($award['id']); ?>&business_name=<?php echo htmlspecialchars($award['business_name']); ?>&year=<?php echo htmlspecialchars($award['year']); ?>&address=<?php echo htmlspecialchars($award['address']); ?>" class="btn btn_fill">Feedback</a>
                        <a href="#winner" class="btn btn_outline">Scroll to see winner <svg class="arrow-icon" viewBox="0 0 24 24">
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
    <div class="rated" id="winner">
          <div class="card">
            <div class="card-body">
              <div class="legend">#1 BEST RATED <?php echo htmlspecialchars($award['year']); ?></div><!--end of legend-->
              <div class="row align-items-center">
                <div class="col-md-3">
                  <div class="ward_logo">
                    <img src="/images/winner_award_<?php echo htmlspecialchars($award['year']); ?>.svg" alt="" class="img-fluid">
                  </div><!--end of award logo-->
                </div><!--end col md 3-->
                <div class="col-md-9">
                 
                  <div class="card">
                    <h3><?php echo htmlspecialchars($award['business_name']); ?></h3>
                    <div class="card-body">
                      <ul class="list-unstyled">
                        <li> <img src="/images/cup.svg" alt=""><?php echo htmlspecialchars($award['category']); ?></li>
                        <li> <img src="/images/address.svg" alt=""><?php echo htmlspecialchars($award['city'] . ', ' . $award['state']); ?></li>
                        <li> <img src="/images/address.svg" alt=""><?php echo htmlspecialchars($award['address']); ?></li>
                      </ul>
                    </div><!--end of card body-->
                  </div><!--end of card-->
                  <p>Ranked as the best among <?php echo htmlspecialchars($award['city']); ?> <?php echo htmlspecialchars($award['category']); ?> businesses for <?php echo htmlspecialchars($award['year']); ?>, <?php echo htmlspecialchars($award['business_name']); ?> exceeded a quality score of 95%.</p>
                
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
                        <a href="javascript:void(0)" class="btn btn_outline" onclick="openVerificationModal()">Click to verify</a>
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
          <div class="title"><h2><span>QUALITY</span> RECOGNITION</h2> <p>Representing less than 1% of registered businesses in the Canada</p></div><!--end of title-->
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

<!-- Verification Modal -->
    <div id="verificationModal" class="verification-modal">
        <div class="verification-content">
            <h3>Business Verification</h3>
            <div class="progress-bar">
                <div class="progress-bar-fill"></div>
            </div>
            <ul></ul>
            <div class="identity-verified" style="display: none;">
                <img id="identity-icon" alt="Status icon">
                <strong>Business Verification Status: <span id="identity-status"></span></strong>
            </div>
            <button class="close-modal" onclick="closeVerificationModal()">Close</button>
        </div>
    </div>

    <script>
        function openVerificationModal() {
            const businessName = <?php echo json_encode($award['business_name']); ?>;
            const businessCategory = <?php echo json_encode($award['category']); ?>;
            const businessLocation = <?php echo json_encode($award['city'] . ', ' . $award['state']); ?>;
            const isVerified = <?php echo json_encode((bool)$award['verification_status']); ?>;
            
            document.getElementById('verificationModal').style.display = 'flex';
            let progressBar = document.querySelector('.progress-bar-fill');
            let progress = 0;
            const steps = [
                `Business Name: ${businessName}`,
                `Category: ${businessCategory}`,
                `Location: ${businessLocation}`,
                'Customer Satisfaction: Excellent',
                'Service Quality: Excellent',
                'Reputation: Excellent',
                'Integrity and Trustworthiness: Excellent',
                'Checking Quality Score'
            ];
            let ul = document.querySelector('.verification-content ul');
            ul.innerHTML = '';

            function updateProgress() {
                if (progress < steps.length - 1) {
                    progressBar.style.width = ((progress + 1) / steps.length) * 100 + '%';
                    let li = document.createElement('li');
                    li.textContent = steps[progress];
                    ul.appendChild(li);
                    progress++;
                    setTimeout(updateProgress, 1000);
                } else if (progress === steps.length - 1) {
                    progressBar.style.width = '100%';
                    let li = document.createElement('li');
                    li.textContent = steps[progress];
                    ul.appendChild(li);
                    progress++;
                    let qualityScore = 0;
                    function slideQualityScore() {
                        if (qualityScore < 95) {
                            qualityScore += 5;
                            li.textContent = `Checking Quality Score: ${qualityScore}%`;
                            setTimeout(slideQualityScore, 500);
                        } else {
                            li.textContent = 'Quality Score: 95%+';
                            document.querySelector('.identity-verified').style.display = 'flex';
                            
                            // Set verification status based on database value
                            if (isVerified) {
                                document.getElementById('identity-status').textContent = 'Verified';
                                document.getElementById('identity-icon').src = 'https://img.icons8.com/ios-filled/50/4CAF50/approval.png';
                                document.getElementById('identity-status').style.color = '#4CAF50';
                                document.querySelector('.identity-verified strong').style.color = '#4CAF50';
                            } else {
                                document.getElementById('identity-status').textContent = 'Unverified';
                                document.getElementById('identity-icon').src = 'https://img.icons8.com/ios-filled/50/FF0000/cancel.png';
                                document.getElementById('identity-status').style.color = '#FF0000';
                                document.querySelector('.identity-verified strong').style.color = '#FF0000';
                            }
                        }
                    }
                    slideQualityScore();
                }
            }

            document.querySelector('.identity-verified').style.display = 'none';
            progressBar.style.width = '0';
            setTimeout(updateProgress, 1000);
        }

        function closeVerificationModal() {
            document.getElementById('verificationModal').style.display = 'none';
        }
    </script>
<?php require('includes/footer.php'); ?>