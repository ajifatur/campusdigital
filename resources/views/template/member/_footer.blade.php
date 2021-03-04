
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                All Rights Reserved by <a href="{{ URL::to('/') }}" target="_blank">{{ get_website_name() }}</a>. Template by <a href="https://wrappixel.com" target="_blank">WrapPixel</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->

			<!-- WhatsApp Button -->
			<div style="bottom:25px; position:fixed; right:10px; z-index:999; border:#000000 0px solid;">
        		<a href="#" onClick="window.open('https://api.whatsapp.com/send?phone={{ get_nomor_whatsapp() }}', '_blank')">
					<img src=" {{ asset('assets/images/others/chat-wa.png') }}" class="img-responsive" style="max-width: 200px;">
				  </a>
			</div>
			<!-- WhatsApp Button End -->