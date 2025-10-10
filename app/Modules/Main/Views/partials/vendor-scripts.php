<script rel="preload" type="text/javascript" src="<?= base_url() ?>/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script rel="preload" type="text/javascript" src="<?= base_url() ?>/assets/libs/metismenu/metisMenu.min.js"></script>
<script rel="preload" type="text/javascript" src="<?= base_url() ?>/assets/libs/simplebar/simplebar.min.js"></script>
<script rel="preload" type="text/javascript" src="<?= base_url() ?>/assets/libs/node-waves/waves.min.js"></script>
<!-- <script rel="preload" type="text/javascript" src="<?= base_url() ?>/assets/libs/feather-icons/feather.min.js"></script> -->
<script rel="preload" type="text/javascript" src="https://object-storage.nginovasi.id/cdns/libs/feather-icons/feather.min.js"></script>
<script rel="preload" type="text/javascript" src="<?= base_url() ?>/assets/libs/pace-js/pace.min.js"></script>
<script rel="preload" type="text/javascript" src="<?= base_url() ?>/assets/libs/sweetalert2/sweetalert2.min.js" defer></script>
<script rel="preload" type="text/javascript" src="<?= base_url() ?>/assets/js/coreevents.js?ts=<?= date('YmdHis') ?>"></script>
<script rel="preload" type="text/javascript" src="<?= base_url() ?>/assets/js/lazyload.config.js"></script>
<script rel="preload" type="text/javascript" src="<?= base_url() ?>/assets/libs/imask/imask.min.js"></script>
<script rel="preload" type="text/javascript" src="<?= base_url() ?>/assets/libs/scrollreveal/dist/scrollreveal.min.js"></script>
<script rel="preload" type="text/javascript" src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@19.1.3/dist/lazyload.min.js"></script>
<?php if (!isset($customjs)) { ?>
    <script rel="preload" type="text/javascript" src="<?= base_url() ?>/assets/js/dashboard.js?ts=<?= date('YmdHis') ?>"></script>
<?php } else { ?>
    <script rel="preload" type="text/javascript" src="<?= base_url() ?>/assets/js/<?= $customjs ?>.js?ts=<?= date('YmdHis') ?>"></script>
<?php } ?>

<script type="text/javascript">
    const sr = ScrollReveal();
    const lazyLoadInstance = new LazyLoad(lazyLoadOptions);

    $(document).ready(function() {
        // console.log = function() {};
        setInterval(updateFlipClock, 1000);
        updateFlipClock();
        $('#search').focus();

        $(document).on('click', '#back-to-old-session', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: 'Otorisasi Login',
                text: "Anda yakin ingin kembali ke user sebelumnya?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Login!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('main/action/main_backLogin') ?>',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            bptd_id: id,
                            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                        },
                        success: function(rs) {
                            if (rs.success) {
                                window.location.href = rs.redirect;
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: rs.message,
                                });
                            }
                        }
                    });
                }
            });
        }).on('input', '#search', function() {
            var searchQuery = $(this).val().toLowerCase();
            $('#side-menu li').each(function() {
                var itemText = $(this).attr('data-search');
                if ($(this).hasClass('menu-title')) {
                    return;
                }
                if (searchQuery == '') {
                    $(this).removeAttr('style');
                    $(this).parents('ul').removeAttr('style');
                    $(this).parents('li').removeAttr('style');
                } else {
                    if (itemText && itemText.toLowerCase().includes(searchQuery)) {
                        $(this).show();
                        $(this).parents('ul').show();
                        $(this).parents('li').show();
                    } else {
                        $(this).hide();
                    }
                }
            });
        }).on('mouseenter', '#page-header-user-dropdown', function() {
            $(this).dropdown('show');
        }).on('mouseenter', '.main-content, .vertical-menu', function() {
            $('#page-header-user-dropdown').dropdown('hide');
        });

        lazyLoadInstance.update();
    });

    function updateFlipClock() {
        const now = new Date();
        const day = now.getDate().toString().padStart(2, '0');
        const month = now.toLocaleString('default', {month: 'long'});
        const year = now.getFullYear().toString();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        const updates = {
            'day-container': day,
            'month-container': month,
            'year-container': year,
            'hours-container': hours,
            'minutes-container': minutes,
            'seconds-container': seconds
        };
        for (const [containerId, newValue] of Object.entries(updates)) {
            updateFlipDigit(containerId, newValue);
        }
    }

    function updateFlipDigit(containerId, newValue) {
        const container = document.getElementById(containerId);
        const currentValue = container.getAttribute('data-value');
        if (currentValue !== newValue) {
            container.setAttribute('data-value', newValue);

            const flipElement = document.createElement('div');
            flipElement.className = 'flip';
            flipElement.textContent = newValue;
            container.innerHTML = '';
            container.appendChild(flipElement);
            setTimeout(() => {flipElement.classList.add('animate');}, 50);
        }
    }

    function updateButtonClasses() {
        $('.buttons-html5, .buttons-print').removeClass('btn-secondary').addClass('btn-link');
    }

    function searchbtn() {
        var searchQuery = $('#search').val().toLowerCase();
        $('#side-menu li').each(function() {
            var itemText = $(this).attr('data-search');
            if (itemText && itemText.toLowerCase().includes(searchQuery)) {
                $(this).show();
                $(this).parents('ul').show();
                $(this).parents('li').show();
            } else {
                $(this).hide();
            }
        });
    }

    function copyToClipboard(title, text) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(() => {
                Swal.fire({
                    position: "center",
                    icon: "info",
                    title: `${title} berhasil disalin`,
                    showConfirmButton: false,
                    timer: 800
                });
            }).catch(err => {
                console.error('Could not copy text: ', err);
            });
        } else {
            const input = document.body.appendChild(document.createElement("input"));
            input.value = text ?? null;
            input.focus();
            input.select();
            document.execCommand('copy');
            input.parentNode.removeChild(input);
            Swal.fire({
                position: "center",
                icon: "info",
                title: `${title} berhasil disalin`,
                showConfirmButton: false,
                timer: 800
            });
        }
    }
</script>