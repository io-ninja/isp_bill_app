<div class="row">
    <div class="card shadow-sm" style="border-radius: 12px;">

        <div class="card-body">
            
            <ul id="tab" class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-data" role="tab" aria-selected="false">
                        <span class="d-block d-sm-none"><i class="fas fa-table"></i></span>
                        <span class="d-none d-sm-block">Data</span>
                    </a>
                </li>
                <?php if ($rules->i == "1") { ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-form" role="tab" aria-selected="true">
                            <span class="d-block d-sm-none"><i class="fab fa-wpforms"></i></span>
                            <span class="d-none d-sm-block">Form</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content p-3 text-muted">
                <div class="tab-pane active" id="tab-data" role="tabpanel">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-theme table-row v-middle">
                            <thead>
                                <tr>
                                    <th><span>#</span></th>
                                    <th><span>Nama Modul</span></th>
                                    <th><span>Nama Menu</span></th>
                                    <th><span>Url Menu</span></th>
                                    <th><span>Parent Menu</span></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if ($rules->i == "1") { ?>
                    <div class="tab-pane" id="tab-form" role="tabpanel">
                        <div class="card-body">
                            <form data-plugin="parsley" data-option="{}" id="form" validate>
                                <input type="hidden" class="form-control" id="id" name="id" value="" required>
                                <?= csrf_field(); ?>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <div class="mb-3">
                                            <label>Modul</label>
                                            <select class="form-control" id="module_id" name="module_id" required>
                                                <option></option>
                                                <?php
                                                foreach ($modules as $module) {
                                                    echo '<option value="' . $module->id . '">' . $module->module_name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="mb-3">
                                            <label>Parent Menu</label>
                                            <select class="form-control" id="menu_id" name="menu_id"></select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="mb-3">
                                            <label>Nama Menu</label>
                                            <input type="text" class="form-control" id="menu_name" name="menu_name" required autocomplete="off" placeholder="Tentukan nama menu">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="mb-3">
                                            <label>Url Menu</label>
                                            <input type="text" class="form-control" id="menu_url" name="menu_url" required autocomplete="off" placeholder="Tentukan URL menu">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button class="btn btn-dark" type="reset">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    const auth_insert = '<?= $rules->i ?>';
    const auth_edit = '<?= $rules->e ?>';
    const auth_delete = '<?= $rules->d ?>';
    const auth_otorisasi = '<?= $rules->o ?>';

    const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
    const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';

    var dataStart = 0;
    var coreEvents;

    const select2Array = [];

    $(document).ready(function() {
        coreEvents = new CoreEvents();
        coreEvents.url = url;
        coreEvents.ajax = url_ajax;
        coreEvents.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };
        coreEvents.tableColumn = datatableColumn();

        coreEvents.insertHandler = {
            placeholder: 'Berhasil menyimpan menu',
            afterAction: function(result) {

            }
        }

        coreEvents.editHandler = {
            placeholder: '',
            afterAction: function(result) {
                setTimeout(function() {
                    $('#module_id').val(result.data.module_id).trigger('change');

                    getListMenu(result.data.module_id, function() {
                        $('#menu_id').val(result.data.menu_id).trigger('change');
                    });
                }, 500);
            }
        }

        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus menu',
            afterAction: function() {

            }
        }

        coreEvents.resetHandler = {
            action: function() {
                $('#menu_id').data('select2').destroy();
                $('#menu_id').html('');
                $('#menu_id').select2({
                    placeholder: "Pilih modul terlebih dahulu"
                });
                $('#module_id').val(null).trigger('change');
            }
        }

        $('#module_id').select2({
            placeholder: "Pilih modul",
            width: '100%'
        }).on('select2:select', function(e) {
            getListMenu(e.params.data.id, function() {});
        });

        $('#menu_id').select2({
            placeholder: "Pilih modul terlebih dahulu",
            width: '100%'
        });

        coreEvents.buttons = [{}];
        coreEvents.dom = "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
        coreEvents.placeholder = 'Cari menu...';
        coreEvents.columnDefs = [{
            "className": "text-center",
            "targets": [0, 5]
        }];

        coreEvents.load(null, coreEvents.placeholder, coreEvents.dom, coreEvents.buttons, coreEvents.columnDefs);
    });

    function getListMenu(id, completion) {
        $('#menu_id').data('select2').destroy();

        $.get({
            url: url_ajax + "/menu_select_get/" + id,
            dataType: 'html',
            success: function(result) {
                $('#menu_id').html(result);
                $('#menu_id').select2();
                completion();
            }
        })
    }

    function datatableColumn() {
        let columns = [{
                data: "id",
                title: "#",
                orderable: false,
                width: 5,
                className: 'text-center align-middle fw-bold',
                render: function(a, type, data, index) {
                    return `<span>${dataStart + index.row + 1}.</span>`;
                }
            },
            {
                data: "module_name",
                title: "Nama Modul",
                orderable: false,
                width: 100,
                className: 'text-start align-middle'
            },
            {
                data: "menu_name",
                title: "Nama Menu",
                orderable: false,
                width: 100,
                className: 'text-start align-middle'
            },
            {
                data: "menu_url",
                title: "Url Menu",
                orderable: false,
                width: 100,
                className: 'text-start align-middle',
                render: function(a, type, data, index) {
                    return `<a href="javascript:void(0)" class="text-primary tooltipp" id="alert-message" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to copy" onclick="copyToClipboard('${a}')">${a}</a>`;
                }
            },
            {
                data: "menu_parent",
                title: "Parent Menu",
                orderable: false,
                width: 100,
                className: 'text-start align-middle',
                render: function(a, type, data, index) {
                    return data.menu_parent || '';
                }
            },
            {
                data: "id",
                title: null,
                orderable: false,
                width: 5,
                className: 'text-center align-middle',
                render: function(a, type, data, index) {
                    let button = ''
                    if (auth_edit == "1") {
                        button += `<button class="btn btn-sm btn-outline-primary edit" data-id="${data.id}" title="Edit"><i class="fa fa-edit"></i></button>`;
                    }
                    if (auth_delete == "1") {
                        button += `<button class="btn btn-sm btn-outline-danger delete" data-id="${data.id}" title="Delete"><i class="bx bx-trash-alt"></i></button>`;
                    }
                    button += (button == '') ? "<i class='fa fa-ban'></i>" : "";
                    return `<div class='btn-group'>${button}</div>`;
                }
            }
        ];

        return columns;
    }
</script>