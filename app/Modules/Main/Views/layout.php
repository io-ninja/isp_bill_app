<?php $session = \Config\Services::session() ?>
<?php echo view('App\Modules\Main\Views\partials\head-main') ?>
<head>
    <?= $title_meta ?>
    <?php echo view('App\Modules\Main\Views\partials\head-css') ?>
</head>
<?php echo view('App\Modules\Main\Views\partials\body') ?>
<div id="layout-wrapper">
    <?php echo view('App\Modules\Main\Views\partials\menu'); ?>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid mb-3">
                <?php
                if (isset($load_view)) {
                    echo $page_titles;
                    echo view($load_view);
                } else {
                    echo view('App\Modules\Main\Views\partials\page-title');
                    echo view('App\Modules\Main\Views\dashboard');
                }
                ?>
            </div>
        </div>
        <?php echo view('App\Modules\Main\Views\partials\footer') ?>
    </div>
</div>
<?php echo view('App\Modules\Main\Views\partials\right-sidebar') ?>
<?php echo view('App\Modules\Main\Views\partials\vendor-scripts') ?>
<script src="<?= base_url() ?>/assets/js/pages/dashboard.init.js" defer="defer"></script>
<script>
    <?php
    if (isset($js_file)) {
        echo $js_file;
    }
    ?>
</script>
<script src="<?= base_url() ?>/assets/js/app.js" defer="defer"></script>
</body>
</html>