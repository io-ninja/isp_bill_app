<?php $session = \Config\Services::session(); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm" style="border-radius: 12px;">
            <div class="card-body">
                <div class="row justify-content-center mt-3">
                    <div class="col-xl-5 col-lg-8">
                        <div class="text-center">
                            <?php 
                            // print_r('<pre>');
                            // print_r($session->get());
                            // print_r('</pre>');

                                if ($session->get('role_code') == 'bpw') {
                                    $rolecode = ' (BPTD Wilayah)';
                                } else if ($session->get('role_code') == 'sad') {
                                    $rolecode = ' (Admin)';
                                } else if ($session->get('role_code') == 'daj') {
                                    $rolecode = ' (Dirjen Angkutan)';
                                } else if ($session->get('role_code') == 'po') {
                                    $rolecode = ' (PO)';
                                } else if ($session->get('role_code') == 'pop' || $session->get('role') == '6') {
                                    $rolecode = ' (Petugas PO)';
                                } else {
                                    $rolecode = '';
                                }
                            ?>
                            <h5><?php echo lang('Files.Manual_Book');?> <?= $rolecode ?></h5>
                            <p class="text-muted">Buku petunjuk penggunaan pada <?= lang('Files.Fleet_Management_System') ?></p>
                            <!-- <div>
                                <button type="button" class="btn btn-primary mt-2 me-2 waves-effect waves-light">Email Us</button>
                                <button type="button" class="btn btn-success mt-2 waves-effect waves-light">Send us a tweet</button>
                            </div> -->

                            <!-- <div class="row justify-content-center">
                                <div class="col-xl-10">
                                    <form class="app-search d-none d-lg-block mt-4">
                                        <div class="position-relative">
                                            <input type="text" class="form-control" placeholder="Search...">
                                            <button class="btn btn-primary" type="button"><i class="bx bx-search-alt align-middle"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row mt-3">
                    <?php
                    if ($session->get('role_code') == 'bpw') {
                        // $url = base_url() . '/assets/Manual_Book_FMS_(BPTD).pdf';
                        $html = '<div class="col-xl-4 col-sm-6 text-center">
                                    <div class="card shadow-sm" style="border-radius: 12px;">
                                        <div class="card-body overflow-hidden position-relative">
                                            <div>
                                                <i class="bx bx-help-circle widget-box-1-icon text-primary"></i>
                                            </div>
                                            <a href="https://drive.google.com/file/d/1aUi63VbaaBHdz9nxESORUlQVTZl0TEpx/view?usp=sharing" target="_blank">
                                                <h5 class="mt-3">Manual Book FMS (BPTD)</h5>
                                            </a>
                                            <p class="text-muted mt-3 mb-0">Petunjuk Penggunaan User (BPTD) Fleet Management System (FMS) MitraDarat.</p>
                                        </div>
                                    </div>
                                </div>';
                    } else if ($session->get('role_code') == 'sad') {
                        // $url = base_url() . '/assets/Manual_Book_FMS_(Admin).pdf';
                        $html = '<div class="col-xl-4 col-sm-6 text-center">
                                    <div class="card shadow-sm" style="border-radius: 12px;">
                                        <div class="card-body overflow-hidden position-relative">
                                            <div>
                                                <i class="bx bx-help-circle widget-box-1-icon text-primary"></i>
                                            </div>
                                            <a href="https://drive.google.com/file/d/1aSsZBzmzKacsqCDWEnynK4jZuQrt-vrq/view?usp=sharing" target="_blank">
                                                <h5 class="mt-3">Manual Book FMS (Admin)</h5>
                                            </a>
                                            <p class="text-muted mt-3 mb-0">Petunjuk Penggunaan User (Admin) Fleet Management System (FMS) MitraDarat.</p>
                                        </div>
                                    </div>
                                </div>';
                    } else if ($session->get('role_code') == 'daj') {
                        // $url = base_url() . '/assets/Manual_Book_FMS_(Dit_Angkutan_Jalan).pdf';
                        $html = '<div class="col-xl-4 col-sm-6 text-center">
                                <div class="card shadow-sm" style="border-radius: 12px;">
                                    <div class="card-body overflow-hidden position-relative">
                                        <div>
                                            <i class="bx bx-help-circle widget-box-1-icon text-primary"></i>
                                        </div>
                                        <a href="https://drive.google.com/file/d/1aWeqgiRec22-Jfxt_bPvcysVu6RxMm7S/view?usp=sharing" target="_blank">
                                            <h5 class="mt-3">Manual Book FMS (Dirjen Angkutan)</h5>
                                        </a>
                                        <p class="text-muted mt-3 mb-0">Petunjuk Penggunaan User (Dirjen Angkutan) Fleet Management System (FMS) MitraDarat.</p>
                                    </div>
                                </div>
                            </div>';
                    } else if ($session->get('role_code') == 'po') {
                        // $url = base_url() . '/assets/Manual_Book_FMS_(PO).pdf';
                        $html = '<div class="col-xl-4 col-sm-6 text-center">
                                    <div class="card shadow-sm" style="border-radius: 12px;">
                                        <div class="card-body overflow-hidden position-relative">
                                            <div>
                                                <i class="bx bx-help-circle widget-box-1-icon text-primary"></i>
                                            </div>
                                            <a href="https://drive.google.com/file/d/1aVWP3slF8gtDwyqfbFPq8Kpp1jkH_p86/view?usp=sharing" target="_blank">
                                                <h5 class="mt-3">Manual Book FMS (PO)</h5>
                                            </a>
                                            <p class="text-muted mt-3 mb-0">Petunjuk Penggunaan User (PO) Fleet Management System (FMS) MitraDarat.</p>
                                        </div>
                                    </div>
                                </div>';
                    } else if ($session->get('role_code') == 'pop') {
                        // $url = base_url() . '/assets/Manual_Book_FMS_(Petugas_PO).pdf';
                        $html = '<div class="col-xl-4 col-sm-6 text-center">
                                    <div class="card shadow-sm" style="border-radius: 12px;">
                                        <div class="card-body overflow-hidden position-relative">
                                            <div>
                                                <i class="bx bx-help-circle widget-box-1-icon text-primary"></i>
                                            </div>
                                            <a href="https://drive.google.com/file/d/1aWLoDUCqjmkyTG6muuw6VrKHHOtcQV4j/view?usp=sharing" target="_blank">
                                                <h5 class="mt-3">Manual Book FMS (Petugas PO)</h5>
                                            </a>
                                            <p class="text-muted mt-3 mb-0">Petunjuk Penggunaan User (Petugas PO) Fleet Management System (FMS) MitraDarat.</p>
                                        </div>
                                    </div>
                                </div>';
                    } else {
                        $url = '';
                        $html = '<div class="col-xl-4 col-sm-6">
                        <div class="card shadow-sm" style="border-radius: 12px;">
                            <div class="card-body overflow-hidden position-relative">
                                <div>
                                    <i class="bx bx-help-circle widget-box-1-icon text-primary"></i>
                                </div>
                                <div class="faq-count">
                                    <h5 class="text-primary">01.</h5>
                                </div>
                                <a href="https://drive.google.com/file/d/1aSsZBzmzKacsqCDWEnynK4jZuQrt-vrq/view?usp=sharing" target="_blank">
                                    <h5 class="mt-3">Manual Book FMS (Admin)</h5>
                                </a>
                                <p class="text-muted mt-3 mb-0">Petunjuk Penggunaan User (Admin) Fleet Management System (FMS) MitraDarat.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                        <div class="card shadow-sm" style="border-radius: 12px;">
                            <div class="card-body overflow-hidden position-relative">
                                <div>
                                    <i class="bx bx-help-circle widget-box-1-icon text-primary"></i>
                                </div>
                                <div class="faq-count">
                                    <h5 class="text-primary">02.</h5>
                                </div>
                                <a href="https://drive.google.com/file/d/1aUi63VbaaBHdz9nxESORUlQVTZl0TEpx/view?usp=sharing" target="_blank">
                                    <h5 class="mt-3">Manual Book FMS (BPTD)</h5>
                                </a>
                                <p class="text-muted mt-3 mb-0">Petunjuk Penggunaan User (BPTD) Fleet Management System (FMS) MitraDarat.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6">
                                <div class="card shadow-sm" style="border-radius: 12px;">
                                    <div class="card-body overflow-hidden position-relative">
                                        <div>
                                            <i class="bx bx-help-circle widget-box-1-icon text-primary"></i>
                                        </div>
                                        <div class="faq-count">
                                            <h5 class="text-primary">03.</h5>
                                        </div>
                                        <a href="https://drive.google.com/file/d/1aWeqgiRec22-Jfxt_bPvcysVu6RxMm7S/view?usp=sharing" target="_blank">
                                            <h5 class="mt-3">Manual Book FMS (Dirjen Angkutan)</h5>
                                        </a>
                                        <p class="text-muted mt-3 mb-0">Petunjuk Penggunaan User (Dirjen Angkutan) Fleet Management System (FMS) MitraDarat.</p>
                                    </div>
                                </div>
                            </div>

                    <div class="col-xl-4 col-sm-6">
                        <div class="card shadow-sm" style="border-radius: 12px;">
                            <div class="card-body overflow-hidden position-relative">
                                <div>
                                    <i class="bx bx-help-circle widget-box-1-icon text-primary"></i>
                                </div>
                                <div class="faq-count">
                                    <h5 class="text-primary">04.</h5>
                                </div>
                                <a href="https://drive.google.com/file/d/1aVWP3slF8gtDwyqfbFPq8Kpp1jkH_p86/view?usp=sharing" target="_blank">
                                    <h5 class="mt-3">Manual Book FMS (PO)</h5>
                                </a>
                                <p class="text-muted mt-3 mb-0">Petunjuk Penggunaan User (PO) Fleet Management System (FMS) MitraDarat.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-sm-6">
                        <div class="card shadow-sm" style="border-radius: 12px;">
                            <div class="card-body overflow-hidden position-relative">
                                <div>
                                    <i class="bx bx-help-circle widget-box-1-icon text-primary"></i>
                                </div>
                                <div class="faq-count">
                                    <h5 class="text-primary">05.</h5>
                                </div>
                                <a href="https://drive.google.com/file/d/1aWLoDUCqjmkyTG6muuw6VrKHHOtcQV4j/view?usp=sharing" target="_blank">
                                    <h5 class="mt-3">Manual Book FMS (Petugas PO)</h5>
                                </a>
                                <p class="text-muted mt-3 mb-0">Petunjuk Penggunaan User (Petugas PO) Fleet Management System (FMS) MitraDarat.</p>
                            </div>
                        </div>
                    </div>';
                    } ?>

                    <!-- <object class="p-3" data="<?= $url ?>" type="application/pdf" width="100%" height="1000px"></object> -->
                    <hr>
                    <?= $html ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->