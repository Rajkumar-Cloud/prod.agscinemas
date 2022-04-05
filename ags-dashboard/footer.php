    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/ripple.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
    <script src="assets/js/plugins/toaster/jquery.toast.js"></script>  
    <!-- Apex Chart -->
    <?php if($actual_path['filename'] == "index") { ?>
        <script src="assets/js/plugins/apexcharts.min.js"></script>
        <script src="assets/js/plugins/chart.js"></script>
    <?php } ?>
    <!-- custom-chart js -->
    <script src="assets/js/pages/dashboard-main.js"></script>
    <?php
    if($actual_path['filename'] == "ags-users" || $actual_path['filename'] == "cinema-transaction" || $actual_path['filename'] == "cinema-show-transaction" || 
    $actual_path['filename'] == "failure-transaction" || $actual_path['filename'] == "view-food-items" || $actual_path['filename'] == "user-ticket-history"
    || $actual_path['filename'] == "old-customer-mail-trigger" || $actual_path['filename'] == "index" || $actual_path['filename'] == "admin_register" || $actual_path['filename'] == "movie-resources" || $actual_path['filename'] == "summary" || $actual_path['filename'] == "refund" || $actual_path['filename'] == "schedule" || $actual_path['filename'] == "food-transaction" || $actual_path['filename'] == "failure-refund" || $actual_path['filename'] == "show-refund") { ?>
    <script src="assets/js/jquery-ui.js"></script>
    <script src="assets/js/plugins/dataTable/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/plugins/dataTable/js/dataTables.fixedHeader.min.js"></script>
    <script src="assets/js/plugins/dataTable/js/dataTables.rowsGroup.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/plugins/dataTable/js/dataTables.dateTime.min.js"></script>
    <script src="assets/js/plugins/dataTable/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/plugins/dataTable/js/jszip.min.js"></script>
    <script src="assets/js/plugins/dataTable/js/pdfmake.min.js"></script>
    <script src="assets/js/plugins/dataTable/js/vfs_fonts.js"></script>
    <script src="assets/js/plugins/dataTable/js/buttons.html5.min.js"></script>
    <script src="assets/js/plugins/dataTable/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="../assets/js/qrcode.js"></script>
    <script src="../assets/js/html2canvas.js"></script>
    <?php } ?>
  </body>
</html>
