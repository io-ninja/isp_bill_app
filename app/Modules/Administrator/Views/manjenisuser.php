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
                                    <th><span>Jenis User</span></th>
                                    <th><span>Kode Role</span></th>
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
                                <div class="row mb-3">
                                    <div class="col-md-10 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="user_web_role_name">Jenis User</label>
                                            <input type="text" class="form-control" id="user_web_role_name" name="user_web_role_name" required autocomplete="off" placeholder="Tentukan nama jenis user">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="user_web_role_code">Role Code</label>
                                            <input type="text" class="form-control" id="user_web_role_code" name="user_web_role_code" required autocomplete="off" placeholder="Tentukan kode role" minlength="3"
                                                maxlength="5" style="text-transform:lowercase">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Simpan</button>
                                <button class="btn btn-dark" type="reset">Reset</button>
                            </form>
                        </div>
                        <div class="card-footer">
                            <span> Catatan : </span>
                            <ul>
                                <li>Role Code :
                                    <ul>
                                        <li>Role Code bersifat unik, tidak bisa diubah, dan tidak boleh sama dengan kode role yang sudah ada</li>
                                        <li>Role Code digunakan untuk menentukan hak akses</li>
                                        <li>Role Code terdiri dari 3-5 karakter huruf kecil</li>
                                    </ul>
                                </li>
                            </ul>
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
            placeholder: 'Berhasil menyimpan jenis user',
            afterAction: function(result) {}
        }

        coreEvents.editHandler = {
            placeholder: 'Berhasil mengubah jenis user',
            afterAction: function(result) {}
        }

        coreEvents.deleteHandler = {
            placeholder: 'Berhasil menghapus jenis user',
            afterAction: function() {}
        }

        coreEvents.resetHandler = {
            action: function() {}
        }

        coreEvents.buttons = [{}];
        coreEvents.dom = "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
        coreEvents.placeholder = 'Cari jenis user';
        coreEvents.columnDefs = [{
            "className": "text-center",
            "targets": [0, 2]
        }];

        coreEvents.load(null, coreEvents.placeholder, coreEvents.dom, coreEvents.buttons, coreEvents.columnDefs);
    });

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
                data: "user_web_role_name",
                orderable: true,
                width: 100,
                className: 'align-middle'
            },
            {
                data: "user_web_role_code",
                orderable: true,
                width: 100,
                className: 'text-center align-middle'
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