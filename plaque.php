<?php require('includes/header.php'); ?>
<div class="decal_wrraper">
  <div class="container">

  <div class="decal_desc new_plaque">
    <div class="row">
      <div class="col-md-6">
        <h2>Plaque</h2>
       <p>Congratulations on your business award! Our plaques are a timeless way to recognize and celebrate your achievement. Made of high-quality materials and featuring a classic design, these plaques serve as a lasting reminder of this special occasion.             </p>
       <p>Custom engraved with your business name and the category you won for, these personalized plaques not only symbolize your hard-earned success, but also make a unique and memorable display of your achievement.             </p>
  

        <div class="bottom_btn">
          <a href="#" class="btn btn_fill">Order Now</a>
          
        </div><!--end of bottom btn-->

      </div><!--end of col md 6-->

      <div class="col-md-6">
        <div class="row popup-gallery">
          <div class="col-md-6">
            <div class="decal_img">
             <a href="images/images-2-150x150.jpg"> <img src="images/images-2-150x150.jpg" alt="" class="img-fluid"></a>
             <div class="mask">
                <p><small>Click to enlarge</small></p>
              </div>
            </div><!--end of decal img-->
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <div class="decal_img">
              <a href="images/Z06_8907-HDR-scaled-1-1024x679.jpg"><img src="images/Z06_8907-HDR-scaled-1-1024x679.jpg" alt="" class="img-fluid"></a>
              <div class="mask">
                <p><small>Click to enlarge</small></p>
              </div>
            </div><!--end of decal img-->
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <div class="decal_img">
              <a href="images/Z06_8913-HDR-scaled-1-1024x682.jpg"><img src="images/Z06_8913-HDR-scaled-1-1024x682.jpg" alt="" class="img-fluid"></a>
              <div class="mask">
                <p><small>Click to enlarge</small></p>
              </div>
            </div><!--end of decal img-->
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <div class="decal_img">
              <a href="images/Z06_8919-HDR-scaled-1-1024x681.jpg"><img src="images/Z06_8919-HDR-scaled-1-1024x681.jpg" alt="" class="img-fluid"></a>
              <div class="mask">
                <p><small>Click to enlarge</small></p>
              </div>
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