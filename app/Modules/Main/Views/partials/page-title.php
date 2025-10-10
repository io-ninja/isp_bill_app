<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <!-- <h4 class="page-title mb-0 font-size-18"><?= isset($title) ? $title : '' ?></h4> -->
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <?php if (isset($li_1) && !empty($li_1)):  ?>
                        <li class="breadcrumb-item">
                            <a href="<?= isset($href_1) && !empty($href_1) ? $href_1 : '#' ?>"><?= $li_1 ?></a>
                        </li>
                    <?php endif ?>
                    <?php if (isset($li_2) && !empty($li_2)):  ?>
                        <li class="breadcrumb-item active"><?= $li_2 ?></li>
                    <?php endif ?>
                </ol>
            </div>
        </div>
    </div>
</div>