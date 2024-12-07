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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="/js/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
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
</body>
</html>