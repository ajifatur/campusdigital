
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('templates/matrix-admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('templates/matrix-admin/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('templates/matrix-admin/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('templates/matrix-admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('templates/matrix-admin/assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('templates/matrix-admin/dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('templates/matrix-admin/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('templates/matrix-admin/dist/js/custom.min.js') }}"></script>
    <!-- Sidebar Scroll -->
	<script>
		sidebarScroll();
		
		function sidebarScroll(){
            var windowHeight = $(window).height();
            var sidebarHeight = $(".sidebar-nav").height();

            $(window).on("load", function(){
                sidebarHeight >= windowHeight ? $(".left-sidebar").css("overflow-y","hidden") : $(".left-sidebar").css("overflow-y","auto");
            });

			$(document).on("mouseover", ".left-sidebar", function(){
				sidebarHeight >= windowHeight ? $(this).css("overflow-y","scroll") : $(this).css("overflow-y","auto");
			});

			$(document).on("mouseleave", ".left-sidebar", function(){
				$(this).css("overflow-y","hidden");
			});
		}
	</script>