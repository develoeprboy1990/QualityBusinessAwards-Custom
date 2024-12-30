<?php require('includes/header.php'); ?>
<div class="decal_wrraper">
  <div class="container">

  <div class="decal_desc glass_trophy">
    <div class="row">
      <div class="col-md-6">
        <div class="glass_tropy_desc">
        <h2>Gloss Trophy</h2>
       <p>Congratulations on winning a business award! Our glass trophies are a beautiful way to commemorate this special achievement. Made of high-quality materials and featuring a modern design, these trophies make a unique and memorable display of your success.</p>
       <p>Custom engraved with your business name and the category you won for, these personalized trophies not only symbolize your hard-earned achievement, but also serve as a lasting reminder of this momentous occasion.</p>
  

        <div class="bottom_btn">
          <a href="/commemorate" class="btn btn_fill">Order Now</a>
        </div><!--end of bottom btn-->
      </div><!--end of glass trophy desc-->
      </div><!--end of col md 6-->

      <div class="col-md-6">
        <div class="row popup-gallery">
          <div class="col-md-6">
            <div class="decal_img">
              <a href="images/The-Best-01.jpg"><img src="images/The-Best-01.jpg" alt="" class="img-fluid"></a>
              
            </div><!--end of decal img-->
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <div class="decal_img">
              <a href="images/ngp_03-compressed.jpg"><img src="images/ngp_03-compressed.jpg" alt="" class="img-fluid"></a>
              
            </div><!--end of decal img-->
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <div class="decal_img">
             <a href="images/ngp_02-compressed.jpg"><img src="images/ngp_02-compressed.jpg" alt="" class="img-fluid"></a> 
              
            </div><!--end of decal img-->
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <div class="decal_img">
              <a href="images/ngp_01-compressed.jpg"><img src="images/ngp_01-compressed.jpg" alt="" class="img-fluid"></a>
              
            </div><!--end of decal img-->
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <div class="decal_img">
              <a href="images/award-03.jpg"><img src="images/award-03.jpg" alt="" class="img-fluid"></a>
              
            </div><!--end of decal img-->
          </div><!--end of col md 6-->

        </div><!--end of row-->
      </div><!--end of col md 6-->

    </div><!--end of row-->
  </div><!--end of decal desc-->
</div><!--end of container-->
</div><!--end of decal wrraper-->
<?php require('includes/footer.php'); ?>
<script>
$(document).ready(function() {
	$('.popup-gallery').magnificPopup({
		delegate: 'a',
		type: 'image',
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
			tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
			titleSrc: function(item) {
				return item.el.attr('title') + '<small>by Marsel Van Oosten</small>';
			}
		}
	});
});
</script> 