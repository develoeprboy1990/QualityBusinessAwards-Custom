<?php require('includes/header.php'); ?>
<div class="home_hero" style="background-image: url(images/header-bg.png);">
  <div class="container">
      <p>Find The Winners of The <span>2025 Quality Business Awards</span></p>
      <h2>QUALITY BUSINESS AWARDS</h2>
      <a href="search" class="btn">SEARCH WINNERS</a>
  </div><!--END OF CONTAINER-->
</div><!--END OF HOME HERO-->

<section class="request_consi">
  <div class="container col-md-9">
  <div class="title">
    <h2><span>SUGGEST </span>EDIT</h2>
    <p>Please allow 5 business days for us to review this edit suggestion.</p>
  </div><!--end of title-->

  <div class="request_form">
    <div class="inner_form">
        <h4>Suggest Edit</h4>
        <p>Canada</p>
        <div class="row mt-5">
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Owner First Name*">
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Owner Last Name*">
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <label>Business*</label>
            <input type="text" class="form-control" placeholder="Business Name*">
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <label>Email*</label>
            <input type="email" class="form-control" placeholder="Email">
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <label>Category</label>
            <select class="form-control select2">
              <option selected>Choose Category</option>
              <option value="Accountants">Accountants</option>
              <option value="Acupuncture">Acupuncture</option>
              <option value="Air Duct Cleaning">Air Duct Cleaning</option>
              <option value="Airport Shuttle Service">Airport Shuttle Service</option>
              <option value="Alternative Medicine">Alternative Medicine</option>
            </select>
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <label>Choose Location</label>
            <select class="form-control select2">
              <option selected>Choose Location</option>
              <option value="Abbotsford, British Columbia">Abbotsford, British Columbia</option>
              <option value="Airdrie, Alberta">Airdrie, Alberta</option>
              <option value="Ajax, Ontario">Ajax, Ontario</option>
              <option value="Aurora, Ontario">Aurora, Ontario</option>
              <option value="Barrie, Ontario">Barrie, Ontario</option>
            </select>
          </div><!--end of col md 6-->

          <div class="col-md-12">
            <label>Business Address*</label>
            <textarea class="form-control" placeholder="Business Address"></textarea>
          </div><!--end of col md 12-->

          <div class="col-md-12">
            <label>URL*</label>
            <input type="text" class="form-control" placeholder="URL">
          </div><!--end of col md 12-->

          <div class="col-md-12">
            <label>info</label>
            <textarea class="form-control" placeholder="Any additional info"></textarea>
          </div><!--end of col md 12-->

          <div class="col-md-12">
            <label>Which award are you applying for?*</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
              <label class="form-check-label" for="flexCheckDefault">
                2024 - Current
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
              <label class="form-check-label" for="flexCheckChecked">
               2025
              </label>
            </div>
          </div><!--end of col md 12-->
          <div class="col-md-12">
            <p>I Understand there is a one time $35 admin fee if my application is accepted. Payable later, if accepted.</p>
            <a href="#" class="btn">Request Consideration <i class="fa fa-angle-right"></i></a>
          </div><!--end of col md 12-->

        </div><!--end of row-->
      </div><!--end of inner form-->
  </div><!--end of request form-->
 
  </div><!--END OF CONTAINER-->
</section>
<?php require('includes/footer.php'); ?>
<script>
 $('.select2').select2();
</script>