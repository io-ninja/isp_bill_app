<?php $session = \Config\Services::session(); ?>
<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <div class="d-none d-md-block navbar-brand-box">
                <a href="<?= base_url() ?>" class="logo logo-dark">
                    <span class="logo-sm" style="overflow: hidden;">
                        <img class="lazy" src="<?= base_url(getenv('prop.applogo')) ?>" alt="" height="25">
                    </span>
                    <span class="logo-lg" style="overflow: hidden;">
                        <img class="lazy" src="<?= base_url(getenv('prop.applogofull')) ?>" alt="" height="30">
                        <span class="logo-txt"><?= getenv('prop.appname') ?></span>
                    </span>
                </a>

                <a href="<?= base_url() ?>" class="logo logo-light">
                    <span class="logo-sm" style="overflow: hidden;">
                        <img class="lazy" src="<?= base_url(getenv('prop.applogo')) ?>" alt="" height="25">
                    </span>
                    <span class="logo-lg" style="overflow: hidden;">
                        <img class="lazy" src="<?= base_url(getenv('prop.applogofull')) ?>" alt="" height="30">
                        <span class="logo-txt"><?= getenv('prop.appname') ?></span>
                    </span>
                </a>
            </div>
            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>
            <div class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <h4 class="page-title mb-0 mt-2 font-size-18 lazy">Login <?= APP_NAME ?> as <?= $session->get('role_name') ?></h4>
                </div>
            </div>
        </div>

        <div class="d-flex">
            <?php
            $old_session = isset($_SESSION['old_session']) ? $_SESSION['old_session'] : '';
            $old_role_code = isset($_SESSION['old_session']['role_code']) ? $_SESSION['old_session']['role_code'] : '';

            $lang = $session->get('lang');
            $role_code = $session->get('role_code');
            ?>
            <!-- <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item ">
                    <span class="badge bg-danger rounded-pill font-size-12">
                        <span id="clock"></span>
                    </span><br>
                    <span class="font-size-12">Login as <?= $session->get('role_name') ?></span>
                </button>
            </div> -->

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item">
                    <span class="badge bg-secondary rounded-pill font-size-12">
                        <!-- Flip Clock Section -->
                        <div id="flip-clock">
                            <!-- Date Section -->
                            <div class="" id="day-container"></div>
                            <div class="" id="month-container"></div>
                            <div class="" id="year-container"></div>
                            <div class="flip-container" id="hours-container"></div>
                            <span class="separator">:</span>
                            <div class="flip-container" id="minutes-container"></div>
                            <span class="separator">:</span>
                            <div class="flip-container" id="seconds-container"></div>
                        </div>
                    </span>
                    <br>
                    <!-- <span class="font-size-12">Login as <?= htmlspecialchars($session->get('role_name')) ?></span> -->
                </button>
            </div>

            <div class="dropdown d-inline-block" style="float:right;">
                <button type="button" class="btn header-item" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <!-- <img class="rounded-circle header-profile-user" style="background-color: transparent; height: 40px;" src="" alt="Header Avatar"> -->
                    <i class="rounded-circle header-profile-user fas fa-user-circle" style="background-color: transparent;/* height: 40px; */font-size: 25px;"></i>
                    <span class="d-inline d-xl-inline-block ms-1 fw-medium font-size-15"><?= $session->get('name') ?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end shadow-lg offset-md-2" style="border-radius: 1rem;" aria-labelledby="page-header-user-dropdown">
                    <div class="card shadow-sm" style="border-radius: 1rem;">
                        <div class="card-body text-center">
                            <!-- <img class="rounded-circle header-profile-user" style="background-color: transparent; height: 40px;" src="" alt="Header Avatar"> -->
                            <i class="rounded-circle header-profile-user fas fa-user-circle" style="background-color: transparent;font-size: 30px;"></i>
                            <h5 class="card-title"><?= $session->get('name') ?></h5>
                            <span class="text-muted"><?= $session->get('role_name') ?></span><br>
                            <span class="text-muted">(<?= $session->get('username') ?>)</span>
                        </div>
                    </div>
                    <a class="dropdown-item" href="<?= base_url() ?>/main/changepassword">
                        <i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i>
                        <?= lang('Files.Change_Password') ?>
                    </a>
                    <a class="dropdown-item right-bar-toggle" href="#">
                        <i data-feather="settings" class="icon-md me-1"></i>
                        <?= lang('Files.Settings') ?>
                    </a>
                    <!-- manual book -->
                    <!-- <a class="dropdown-item" href="<?= base_url() ?>/main/manualbook">
                        <i class="mdi mdi-book-open-variant font-size-16 align-middle me-1"></i>
                        <?= lang('Files.Manual_Book') ?>
                    </a> -->
                    <?php if ($old_role_code == 'sad') { ?>
                        <a class="dropdown-item" id="back-to-old-session" href="javascript:void(1)">
                            <i class="mdi mdi-account-switch font-size-16 align-middle me-1"></i>
                            <span style="font-size: 12px;">Back to <?= $old_session['role_name'] ?></span>
                        </a>
                    <?php } ?>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= base_url() ?>/auth/action/logout"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i>
                        <?= lang('Files.Logout') ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>