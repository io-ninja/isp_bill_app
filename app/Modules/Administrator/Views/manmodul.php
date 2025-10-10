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
                        <table id="datatable" class="table table-theme table-sm table-row v-middle table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Modul</th>
                                    <th>Url Modul</th>
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
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="module_name">Nama Modul</label>
                                            <input type="text" class="form-control" id="module_name" name="module_name" placeholder="Tentukan nama modul" value="" required="">
                                            <div class="invalid-feedback">
                                                Tentukan nama modul
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label" for="validationCustom02">URL Modul</label>
                                            <input type="text" class="form-control" id="module_url" name="module_url" placeholder="Tentukan URL Modul" value="" required="">
                                            <div class="invalid-feedback">
                                                Tentukan URL Modul
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">Simpan</button>
                                <button class="btn btn-dark" type="reset">Reset</button>
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
    var coreEventsPage;

    const select2Array = [];

    $(document).ready(function() {
        coreEventsPage = new CoreEvents();
        coreEventsPage.url = url;
        coreEventsPage.ajax = url_ajax;
        coreEventsPage.csrf = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
        };
        coreEventsPage.tableColumn = datatableColumn();

        coreEventsPage.insertHandler = {
            placeholder: 'Berhasil menyimpan modul',
            afterAction: function(result) {

            }
        }

        coreEventsPage.editHandler = {
            placeholder: '',
            afterAction: function(result) {

            }
        }

        coreEventsPage.deleteHandler = {
            placeholder: 'Berhasil menghapus modul',
            afterAction: function() {

            }
        }

        coreEventsPage.resetHandler = {
            action: function() {

            }
        }

        coreEventsPage.buttons = [{}];
        coreEventsPage.dom = "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
        coreEventsPage.placeholder = 'Cari modul...';
        coreEventsPage.columnDefs = [{
            "className": "text-center",
            "targets": [0, 3]
        }];

        coreEventsPage.load(null, coreEventsPage.placeholder, coreEventsPage.dom, coreEventsPage.buttons, coreEventsPage.columnDefs);
    });

    function copyToClipboard(text) {
		var input = document.body.appendChild(document.createElement("input"));
		input.value = text;
		input.focus();
		input.select();
		document.execCommand('copy');
		input.parentNode.removeChild(input);
		Swal.fire({
			position: "center",
			icon: "info",
			title: "URL Modul berhasil disalin!",
			showConfirmButton: false,
			timer: 800
		});
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
                orderable: true,
                width: 100,
                className: 'text-start align-middle'
            },
            {
                data: "module_url",
                title: "URL Modul",
                orderable: true,
                width: 100,
                className: 'text-start align-middle',
                render: function(a, type, data, index) {
                    return `<a href="javascript:void(0)" class="text-primary tooltipp" id="alert-message" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to copy" onclick="copyToClipboard('${a}')">${a}</a>`;
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