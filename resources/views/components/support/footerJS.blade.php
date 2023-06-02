<!-- jQuery -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plus-admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('plus-admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plus-admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plus-admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plus-admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plus-admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plus-admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plus-admin/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plus-admin/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plus-admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plus-admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plus-admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plus-admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('plus-admin/dist/js/adminlte.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('plus-admin/dist/js/demo.js') }}"></script>
<script src="{{ asset('js/function.js') }}"></script>
@yield('script')

<script>
    // <-- Route Link -->
    // Dashboard
    function support_dashboard(url) {
        window.location = url;
    }
    // Kategori Produk
    function support_verifikasi_gapoktan(url) {
        window.location = url;
    }
    // Kategori Produk
    function support_pengaturan(url) {
        window.location = url;
    }
</script>
