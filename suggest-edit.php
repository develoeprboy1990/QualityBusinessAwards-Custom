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
            <label>First Name*</label>
            <input type="text" class="form-control" placeholder="First Name">
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <label>Last Name*</label>
            <input type="text" class="form-control" placeholder="Last Name">
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <label>Email*</label>
            <input type="email" class="form-control" placeholder="Email">
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <label>Company Name*</label>
            <input type="text" class="form-control" placeholder="Company Name">
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <label>URL*</label>
            <input type="text" class="form-control" placeholder="URL">
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <label>Your relation to this company</label>
            <select class="form-control select2">
              <option selected></option>
              <option value="Owner">Owner</option>
              <option value="Employee">Employee</option>
              <option value="No Affiliation">No Affiliation</option>
            </select>
          </div><!--end of col md 6-->

          <div class="col-md-12">
            <label>Please let us know what edit you would recommend.*</label>
            <textarea class="form-control"></textarea>
          </div><!--end of col md 12-->

          <div class="col-md-12">
            <a href="#" class="btn">Suggest Edit <i class="fa fa-angle-right"></i></a>
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