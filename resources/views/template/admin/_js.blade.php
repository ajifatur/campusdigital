
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('templates/matrix-admin/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('templates/matrix-admin/assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('templates/matrix-admin/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('templates/matrix-admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('templates/matrix-admin/assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('templates/matrix-admin/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
    <!-- Magnify Popup -->
    <script src="{{ asset('templates/matrix-admin/assets/libs/magnific-popup/dist/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('templates/matrix-admin/assets/libs/magnific-popup/meg.init.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('templates/matrix-admin/dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('templates/matrix-admin/dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('templates/matrix-admin/dist/js/custom.min.js') }}"></script>
    <script>
        $(function(){
            // Tooltip
            $('[data-toggle="tooltip"]').tooltip();
        });
        
        // Generate dataTable
        function generate_datatable(table){
            var config_lang = {
                "lengthMenu": "Menampilkan _MENU_ data",
                "zeroRecords": "Data tidak tersedia",
                "info": "Menampilkan _START_ sampai _END_ dari total _TOTAL_ data",
                "infoEmpty": "Data tidak ditemukan",
                "infoFiltered": "(Terfilter dari total _MAX_ data)",
                "search": "Cari:",
                "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "previous": "<",
                "next": ">",
                },
                "processing": "Memproses data..."
            };

            var datatable = $(table).DataTable({
                "language": config_lang,
                "fnDrawCallback": function(){
                    $('.btn-magnify-popup').magnificPopup({
                        type: 'image',
                        closeOnContentClick: true,
                        closeBtnInside: false,
                        fixedContentPos: true,
                        image: {
                            verticalFit: true
                        },
                    });
                },
                columnDefs: [
                    {orderable: false, targets: 0},
                    {orderable: false, targets: -1},
                ],
                order: []
            });

            datatable.on('draw.dt', function(){
                $('[data-toggle="tooltip"]').tooltip();
            });

            return datatable;
        }

        // Button Delete
        $(document).on("click", ".btn-delete", function(e){
            e.preventDefault();
            var id = $(this).data("id");
            var ask = confirm("Anda yakin ingin menghapus data ini?");
            if(ask){
                $("#id").val(id);
                $("#form").submit();
            }
        });
    </script>
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