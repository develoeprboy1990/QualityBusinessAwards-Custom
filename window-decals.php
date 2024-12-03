<?php require('includes/header.php'); ?>
<div class="decal_wrraper">
  <!-- <div class="decal_title">
    <div class="container">
    <h2>Excellence on Display</h2>
    <p>Official Quality Business Awards Window Decals</p>
  </div>
  </div> -->

  <div class="container">
  <div class="decal_desc">
    <div class="row">
      <div class="col-md-6">
        <h2>Windows Decal</h2>
        <p>Stand tall and stand out with the Quality Business Awards’ official Window Decals, a symbol of local excellence and sector leadership. These decals are designed to universally fit any storefront or office window, offering a clear and visible marker of your prestigious recognition as a standout business within your community and industry.</p>
        <p>Our decals boast a straightforward yet impactful design that clearly states your achievement: “2024 WINNER, QUALITY RATING OVER 95%”. This message isn’t just a claim; it’s a verified testament to your status as a top-tier service provider</p>
        
        <div class="card">
          <div class="card-body">
            <h4>Premium Specifications</h4>
            <ul class="list-unstyled">
              <li><svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg> <span>Durable, High-Quality Material for Inside Glass Application</span></li>

            <li><svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg> <span>Perfectly Sized at 10 x 10 cm for Optimal Visibility</span></li>

          <li><svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg> <span>Universal Fit for Any Window</span></li>

        <li><svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
      </svg> <span>Effortless Self-Application for a Professional Look</span></li>

      <li><svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg> <span>Resistant to Fading, Ensuring Long-Lasting Vibrancy</span></li>

    <li><svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
  </svg> <span>Adhesive Designed to Leave No Residue Upon Removal</span></li>

  <li><svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
</svg> <span>Bold, Legible Text that Celebrates Your Winning Status</span></li>

<li><svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
</svg> <span>Perfect for Shop Windows, Office Doors, and Vehicle Displays</span></li>

            </ul>
          </div><!--end of card body-->
        </div><!--end of card-->

        <div class="bottom_btn">
          <a href="#" class="btn btn_fill">Order Now</a>
        </div><!--end of bottom btn-->

      </div><!--end of col md 6-->

      <div class="col-md-6">
        <div class="row popup-gallery">
          <div class="col-md-12">
            <div class="decal_img large">
              <a href="images/1-R1-scaled-1.jpg" title="Premium storefront display"><img src="images/1-R1-scaled-1.jpg" alt="" class="img-fluid"></a>
              <div class="mask">
                <p>Premium storefront display</p>
              </div><!--end of mask-->
            </div><!--end of decal img-->
          </div><!--end of col md 12-->

          <div class="col-md-6">
            <div class="decal_img">
              <a href="images/2-R1-2-scaled-1.jpg"><img src="images/2-R1-2-scaled-1.jpg" alt="" class="img-fluid"></a>
              
            </div><!--end of decal img-->
          </div><!--end of col md 6-->

          <div class="col-md-6">
            <div class="decal_img">
              <a href="images/3-R1-scaled-1.jpg"><img src="images/3-R1-scaled-1.jpg" alt="" class="img-fluid"></a>
              
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