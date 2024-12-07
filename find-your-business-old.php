<?php require('includes/header.php'); ?>
<div class="home_hero gym_lock" style="background-image: url(images/single-header.png);">
  <div class="container">
      <p>Find The Winners of The <span>2024 Quality Business Awards</span></p>
      <h2>QUALITY BUSINESS AWARDS</h2>
      <a href="search" class="btn">SEARCH WINNERS</a>
  </div><!--END OF CONTAINER-->
</div><!--END OF HOME HERO-->
<?php 
$type = isset($_GET['type']) ? trim($_GET['type']) : ''; 
?>
<section class="business_finder" id="form">
  <div class="container col-md-9">
    <div class="row justify-content-center">
      <div class="col-md-9">
        <div class="businessQuality_finder mt-0">
         <div class="common_title">
          <h2><span>Let's Find</span> Your Business</h2>
         </div><!--end of common title-->
      
          <ul class="list-unstyled steps_count">
              <li class="active"><span>1</span> <small>Step1</small></li>
              <li><span>2</span> <small>Step2</small></li>
              <li><span>3</span> <small>Step3</small></li>
          </ul>

          <form action="find-your-business-result" class="searh_form flex-column" method="GET">
            <input type="text" class="form-control" name="business_name" id="business_name" placeholder="Business name">
            <input type="hidden" name="type" value="<?php echo htmlspecialchars($type); ?>" >
            <input type="submit" class="btn" value="Find Business">
          </form> 
      </div>
      </div><!--end of col md 9-->
    </div><!--end of row-->
  </div><!--end of container-->
</section>
<?php require('includes/footer.php'); ?>