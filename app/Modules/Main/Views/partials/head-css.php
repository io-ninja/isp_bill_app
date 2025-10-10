<link rel="preload" href="<?= base_url() ?>/assets/css/preloader.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="<?= base_url() ?>/assets/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="<?= base_url() ?>/assets/css/app.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="stylesheet" href="<?= base_url() ?>/assets/css/icons.min.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url() ?>/assets/libs/sweetalert2/sweetalert2.min.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url() ?>/assets/libs/jquery-ui/jquery-ui.min.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url() ?>/assets/libs/flatpickr/flatpickr.min.css" type="text/css" />
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css"> -->
<link rel="stylesheet" href="<?= base_url() ?>/assets/libs/select2/select2-min.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url() ?>/assets/js/DataTables/datatables.min.css" type="text/css" />
<link rel="stylesheet" href="<?= base_url() ?>/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/css/leaflet.css" type="text/css" /> -->
<!-- <link rel="stylesheet" href='<?= base_url() ?>/assets/css/leaflet.fullscreen.css' type="text/css" /> -->
<!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/css/leaflet.draw-src.css" type="text/css" /> -->
<!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/js/context/dist/leaflet.contextmenu.min.css" type="text/css" /> -->
<!-- <link rel="stylesheet" href="<?= base_url() ?>/assets/css/easy-button.css" type="text/css" /> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" type="text/css" />

<link rel="stylesheet" href="<?= base_url() ?>/assets/css/custom.css" type="text/css" />
<?php
if (isset($css_file)) {
    echo '<link rel="stylesheet" href="' . $css_file . '" type="text/css">';
}
?>

<style>
    
</style>
<script type="text/javascript" src="<?= base_url() ?>/assets/libs/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/libs/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/libs/select2/select2-min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/libs/flatpickr/flatpickr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/js/html2canvas.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/js/DataTables/datatables.min.js"></script>

<!-- <script type="text/javascript" src="<?= base_url() ?>/assets/js/leaflet.js"></script>
<script type="text/javascript" src='<?= base_url() ?>/assets/js/Leaflet.fullscreen.min.js'></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/js/leaflet.draw.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/js/context/dist/leaflet.contextmenu.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/js/easy-button.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/js/editable/src/Leaflet.Editable.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/js/L.Icon.Pulse.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/js/Polyline.encoded.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/js/Control.Geocoder.js"></script> -->

<!-- <script type="text/javascript" src="<?= base_url() ?>/node_modules/blueimp-file-upload/js/jquery.fileupload.js"></script> -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/id.min.js"></script>  
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable-footer/dist/handsontable-footer.js"></script> -->
<script type="text/javascript" src="https://mitradarat-fms.dephub.go.id/assets/js/handsontable/editors/select2Editor.js"></script>
<script>
    moment.locale('id');
</script>