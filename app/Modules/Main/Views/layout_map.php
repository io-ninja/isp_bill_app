<?= view('App\Modules\Main\Views\partials\head-main') ?>
<head>
    <?= $title_meta ?>
    <link href="<?= base_url() ?>/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <?= view('App\Modules\Main\Views\partials\head-css') ?>
</head>
<?= view('App\Modules\Main\Views\partials\body') ?>
<?php
if (isset($load_view)) {
    echo $page_titles;
    echo view($load_view);
} else {
    // echo view('App\Modules\Main\Views\dashboard');
}
?>
<?= view('App\Modules\Main\Views\partials\footer') ?>
<?= view('App\Modules\Main\Views\partials\right-sidebar') ?>
<?= view('App\Modules\Main\Views\partials\vendor-scripts') ?>
<script src="<?= base_url() ?>/assets/libs/apexcharts/apexcharts.min.js" defer="defer"></script>
<script src="<?= base_url() ?>/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js" defer="defer"></script>
<script src="<?= base_url() ?>/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js" defer="defer"></script>
<script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js" defer="defer"></script>
<script>
    <?= $js_file ?? '' ?>
</script>
<script src="<?= base_url() ?>/assets/js/app.js" defer="defer"></script>
</body>

</html>