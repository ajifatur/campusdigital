

	<!-- Footer Section -->
	<footer class="footer-section">
		<div class="container">
			<div class="row mb-3">
				<div class="col-xl-8 col-lg-12">
					<div class="footer-widget text-white">
						<h2>Hubungi Kami</h2>
						<ul>
							<li><i class="fa fa-map-marker position-absolute" style="font-size: 22px;"></i><span style="margin-left: 2rem!important;">{{ get_alamat() }}</span></li>
							<li><i class="fa fa-envelope position-absolute" style="font-size: 22px;"></i><span style="margin-left: 2rem!important;">{{ get_email() }}</span></li>
							<li><i class="fa fa-whatsapp position-absolute" style="font-size: 22px;"></i><span style="margin-left: 2rem!important;">{{ get_nomor_whatsapp() }}</span></li>
							<li><i class="fa fa-instagram position-absolute" style="font-size: 22px;"></i><span style="margin-left: 2rem!important;">@campusdigital.id</span></li>
						</ul>
					</div>
				</div>
				<div class="col-xl-4 col-lg-12">
					<iframe class="rounded shadow" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.1687475729645!2d110.44389857932322!3d-6.989395327077172!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708cb92dcc2b93%3A0x9f3aecfc8c049f9a!2sJl.%20Medoho%20Permai%20I%2C%20Pandean%20Lamper%2C%20Kec.%20Gayamsari%2C%20Kota%20Semarang%2C%20Jawa%20Tengah%2050166!5e0!3m2!1sen!2sid!4v1614825248634!5m2!1sen!2sid" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
				</div>
			</div>
			<div class="copyright text-center"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
			Copyright &copy;2019 - <script>document.write(new Date().getFullYear());</script> <a class="text-warning" href="https://campusdigital.id" target="_blank">Campus Digital</a>. All rights reserved | This template is made with <i class="fa fa-heart-o text-warning" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
			<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></div>
			</div>
	</footer>
	<!-- Footer Section end -->

	<!-- WhatsApp Button -->
    <div style="bottom:25px; position:fixed; right:10px; z-index:999; border:#000000 0px solid;">
          <a href="#" onClick="window.open('https://api.whatsapp.com/send?phone={{ get_nomor_whatsapp() }}&text=Halo Campus Digital, saya butuh informasi tentang layanan Campus Digital...', '_blank')">
				<img src=" {{ asset('assets/images/others/chat-wa.png') }}" class="img-responsive" style="max-width: 200px;">
          </a>
    </div>
	<!-- WhatsApp Button End -->