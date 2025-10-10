<style>
    .select2 {
        width: 100% !important;
    }
</style>
<div class="row">
    <div class="card shadow-sm" style="border-radius: 12px;">
        <div class="card-header">
            <h4 class="card-title text-center text-uppercase">Manajemen Hak Akses</h4>
        </div>
        <div class="card-body">
            <div class="padding">
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="tab-form" role="tabpanel" aria-labelledby="tab-form">
                        <form data-plugin="parsley" data-option="{}" id="form" name="form">
                            <input type="hidden" id="delete" name="delete">
                            <?= csrf_field(); ?>
                            <div class="form-group row">
                                <label class="col-2 col-form-label">Jenis User</label>
                                <div class="col-10">
                                    <select class="form-control select2" id="iduser" name="iduser" required>
                                        <option></option>
                                        <?php
                                        foreach ($jenisusers as $jenisuser) {
                                            echo '<option value="' . $jenisuser->id . '">' . $jenisuser->user_web_role_name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <hr class="my-4">
                            <div id="module_table" style="display: none;">
                                <div class="form-group row">
                                    <table class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-start" data-bs-toggle="tooltip" data-bs-placement="top" title="Modul yang tersedia">Modul</th>
                                                <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Memberikan semua hak akses">Semua Akses</th>
                                                <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Memberikan hak akses untuk melihat data">Akses View</th>
                                                <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Memberikan hak akses untuk menambah data">Akses Insert</th>
                                                <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Memberikan hak akses untuk mengubah data">Akses Edit</th>
                                                <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Memberikan hak akses untuk menghapus data">Akses Delete</th>
                                                <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Memberikan hak akses untuk mengotorisasi data">Akses Otorisasi</th>
                                                <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Menghapus modul">Hapus</th>
                                            </tr>
                                        </thead>
                                        <tbody id="module"></tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="9" class="text-center">
                                                    <button type="button" class="btn btn-outline-secondary waves-effect w-100 btn-sm" id="tambahmodul"><i class="fas fa-plus"></i> Tambah Modul</button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-primary" id="save"><i class="fas fa-save"></i> Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <span> Catatan : </span>
            <ul>
                <li>Modul yang tidak dipilih berarti tidak ada akses</li>
                <li>Modul yang dipilih memiliki beberapa menu dan hak akses yang berbeda-beda</li>
                <li>Modul yang dipilih dapat dihapus dengan mengklik icon <i class="fas fa-trash text-danger"></i></li>
                <li>Jenis Akses :
                    <ul>
                        <li><i>View</i> : Hak akses untuk melihat data</li>
                        <li><i>Insert</i> : Hak akses untuk menambah data</li>
                        <li><i>Edit</i> : Hak akses untuk mengubah data</li>
                        <li><i>Delete</i> : Hak akses untuk menghapus data</li>
                        <li><i>Otorisasi</i> : Hak akses untuk mengotorisasi data</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>
    const url_insert = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) . "_save" ?>';
    const url_edit = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) . "_edit" ?>';
    const url_delete = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) . "_delete" ?>';
    const url_load = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) . "_load" ?>';
    const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';

    var dataStart = 0;
    var table;
    let datatable;
    let modulOption;
    let modules = [];
    let deleted = [];

    $(document).ready(function() {
        //Form CRUD
        $(document).on('submit', 'form[name="form"]', function(e) {
            e.preventDefault();

            let form = $(this);
            $('#save').html(`<div class="spinner-border text-primary m-1" role="status"><span class="sr-only">Menyimpan...</span></div>`);
            $('#save').attr("disabled", true);

            Swal.fire({
                title: "",
                icon: "info",
                text: "Proses menyimpan data, mohon ditunggu...",
                didOpen: function() {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url: url_insert,
                method: 'post',
                dataType: 'json',
                data: form.serialize(),
                success: function(rs) {
                    swal.close();
                    $('#save').html("Simpan");
                    $('#save').attr("disabled", false);

                    if (rs.success) {
                        $('#iduser').val($('#iduser').val()).trigger('change');
                        Swal.fire('Sukses', 'Berhasil mengatur hak akses', 'success');
                    } else {
                        Swal.fire('Error', result.message, 'error');
                    }
                },
                error: function(xhr, error, code) {
                    $('#save').html("Simpan");
                    $('#save').attr("disabled", false);
                    Swal.close();
                    Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                }
            })
        }).on("click", "a[title='Delete']", function() {
            let value = $(this).closest("tr").find('select.idmodule').val();

            deleted.push($(this).closest("tr").find('select').val())
            $('#delete').val(deleted.join(','));

            $(this).closest("tr").nextUntil(".module-row").remove();
            $(this).closest("tr").remove();

            $('#module tr.module-row').each(function() {
                let index = $(this).index('tr.module-row');
                $(this).find('.number').html(index + 1);
            });

            $(".idmenu").each(function() {
                let index = $(this).index('.idmenu');

                $(this).attr("name", "idmenu[" + index + "]");
                $(this).closest('tr').find('.id').attr("name", "id[" + index + "]");
                $(this).closest('tr').find('.d').attr("name", "d[" + index + "]");
                $(this).closest('tr').find('.e').attr("name", "e[" + index + "]");
                $(this).closest('tr').find('.v').attr("name", "v[" + index + "]");
                $(this).closest('tr').find('.i').attr("name", "i[" + index + "]");
                $(this).closest('tr').find('.o').attr("name", "o[" + index + "]");
            });

            modules = modules.filter(x => x !== value);

        }).on('click', '#tambahmodul', function() {
            let index = $('#module tr.module-row').length;

            $('#module').append(formModule(index + 1));
            $("tr").last().find(".idmodule").attr("name", "idmodule[" + (index + 1) + "]");
            $("tr").last().find(".idmodule").css("width", "100%");

        }).on('click', '.check_all', function() {
            let val = $(this).prop("checked")

            $(this).closest('tr').find('td').each(function() {
                if ($(this).find('input.checkbox').prop("disabled") === false) {
                    $(this).find('input.checkbox').prop("checked", val)
                }
            });
        }).on('click', '.checkbox', function() {
            let isAll = true;

            $(this).closest('tr').find('td').each(function() {
                if ($(this).find('input.checkbox').prop("checked") === false) {
                    isAll = false
                }
            });

            $(this).closest('tr').find("td input.check_all").prop("checked", isAll)

            if ($(this).hasClass("d") || $(this).hasClass("e") || $(this).hasClass("i") || $(this).hasClass("o")) {
                $(this).closest('tr').find('td input.v').prop('checked', true);
            }

            if ($(this).hasClass("v")) {
                if ($(this).prop('checked') === false) {
                    $(this).closest('tr').find('td input.check_all').prop('checked', false);
                    $(this).closest('tr').find('td input.checkbox').prop('checked', false);
                }
            }

        }).on('change', '.idmodule', function() {
            let id = $(this).val();
            let $this = $(this);

            if (modules.includes(id)) {
                $this.closest("tr").nextUntil('.module-row').remove();
                modules = $('.idmodule').map(function() {
                    return this.value;
                }).get();
                $this.closest("tr").remove();
            } else {
                getListMenu(id, $this);
            }
        });

        $.ajax({
            url: url_ajax + '/module_select_get',
            success: function(rs) {
                modulOption = rs
            }
        });

        //Select2 Config
        $("#iduser").select2({
            placeholder: "Pilih Jenis User"
        }).on('select2:select', function(e) {
            let id = $(this).val();

            $('#module_table').show();
            $('#module').html('');
            $('#delete').val('');

            $.ajax({
                url: url_ajax + '/moduleuser_get',
                method: 'post',
                dataType: 'json',
                data: {
                    id: id,
                    "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
                },
                success: function(rs) {
                    modules = [];

                    Object.keys(rs).forEach(function(key) {
                        if (rs.hasOwnProperty(key)) {
                            $.when($('#tambahmodul').click()).done(function() {
                                let element = $('.idmodule').last();
                                element.val(key);

                                getListMenu(key, element, rs[key]);
                            });
                        }
                    })
                }
            });
        });
    });

    function getListMenu(id, element, data = null) {
        $.get({
            url: url_ajax + '/menu_get/' + id,
            dataType: 'json',
            success: function(rs) {
                let menu = rs.map(x => createForm(x, data));

                element.closest('tr').nextUntil('.module-row').remove();
                $(menu.join()).insertAfter(element.closest('tr'));

                $(".idmenu").each(function() {
                    let index = $(this).index('.idmenu');

                    $(this).attr("name", "idmenu[" + index + "]");
                    $(this).closest('tr').find('.id').attr("name", "id[" + index + "]");
                    $(this).closest('tr').find('.d').attr("name", "d[" + index + "]");
                    $(this).closest('tr').find('.e').attr("name", "e[" + index + "]");
                    $(this).closest('tr').find('.v').attr("name", "v[" + index + "]");
                    $(this).closest('tr').find('.i').attr("name", "i[" + index + "]");
                    $(this).closest('tr').find('.o').attr("name", "o[" + index + "]");
                });

                modules = $('.idmodule').map(function() {
                    return this.value;
                }).get();

                if (data != null) {
                    $('.idmodule').each(function() {
                        $(this).attr("disabled", true);
                        $(this).css("width", "100%");

                    });
                }
            }
        });
    }

    function formModule(id) {
        return `
        <tr class="module-row">
            <th scope="row" class="number text-center">${id}</th>
            <td colspan="7" class="text-start">${modulOption}</td>
            <td class="text-center">
                <a href="#" title="Delete">
                    <i class="fas fa-trash text-danger"></i>
                </a>
            </td>
        </tr>`;
    }

    function createForm(menu, data) {
        if (menu.submenu.length > 0) {
            let subMenu = menu.submenu.map(x => formSubMenu(x, data));

            return `
            <tr>
                <th scope="row" class="number text-center"></th>
                <td class="text-start"><ul class="mt-3" style='padding-inline-start:20px;'><li>${menu.menu_name}</li></ul></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
            </tr> ${subMenu.join()}`;
        } else {
            return formMenu(menu, data);
        }
    }

    function formMenu(menu, data) {
        let checkAll = "";
        let checkD = "";
        let checkE = "";
        let checkV = "";
        let checkI = "";
        let checkO = "";
        let id = null;

        if (data != null) {
            let menuData = data.filter(function(x) {
                return x.menu_id == menu.id
            });

            if (menuData.length > 0) {
                checkAll = (menuData[0].d === "1" && menuData[0].e === "1" && menuData[0].v === "1" && menuData[0].i === "1" && menuData[0].o === "1") ? "checked" : "";
                checkD = (menuData[0].d === "1") ? "checked" : "";
                checkE = (menuData[0].e === "1") ? "checked" : "";
                checkV = (menuData[0].v === "1") ? "checked" : "";
                checkI = (menuData[0].i === "1") ? "checked" : "";
                checkO = (menuData[0].o === "1") ? "checked" : "";
                id = menuData[0].id
            }
        }

        return `
            <tr>
                <input type="hidden" name="id[]" class="id" value="${id}">
                <th scope="row" class="number text-center">
                    <input type="hidden" class="idmenu" name="idmenu[]" value="${menu.id}">
                </th>
                <td class="text-start">
                    <ul class="mt-3" style="padding-inline-start:20px;"><li>${menu.menu_name}</li></ul>
                </td>
                <td class="text-center">
                    <div class="square-switch me-0 mt-3">
                        <input type="checkbox" class="check_all" id="check_all${menu.id}" name="check_all[]" switch="info" value="1" ${checkAll}>
                        <label for="check_all${menu.id}" data-on-label="Yes" data-off-label="No"></label>
                    </div>
                </td>
                <td class="text-center">
                    <div class="square-switch me-0 mt-3">
                        <input type="checkbox" class="v checkbox" id="vCheckbox${menu.id}" name="v[]" switch="info" value="1" ${checkV}>
                        <label for="vCheckbox${menu.id}" data-on-label="Yes" data-off-label="No"></label>
                    </div>
                </td>
                <td class="text-center">
                    <div class="square-switch me-0 mt-3">
                        <input type="checkbox" class="i checkbox" id="iCheckbox${menu.id}" name="i[]" switch="info" value="1" ${checkI}>
                        <label for="iCheckbox${menu.id}" data-on-label="Yes" data-off-label="No"></label>
                    </div>
                </td>
                <td class="text-center">
                    <div class="square-switch me-0 mt-3">
                        <input type="checkbox" class="e checkbox" id="eCheckbox${menu.id}" name="e[]" switch="info" value="1" ${checkE}>
                        <label for="eCheckbox${menu.id}" data-on-label="Yes" data-off-label="No"></label>
                    </div>
                </td>
                <td class="text-center">
                    <div class="square-switch me-0 mt-3">
                        <input type="checkbox" class="d checkbox" id="dCheckbox${menu.id}" name="d[]" switch="info" value="1" ${checkD}>
                        <label for="dCheckbox${menu.id}" data-on-label="Yes" data-off-label="No"></label>
                    </div>
                </td>
                <td class="text-center">
                    <div class="square-switch me-0 mt-3">
                        <input type="checkbox" class="o checkbox" id="oCheckbox${menu.id}" name="o[]" switch="info" value="1" ${checkO}>
                        <label for="oCheckbox${menu.id}" data-on-label="Yes" data-off-label="No"></label>
                    </div>
                </td>
                <td class="text-center"></td>
            </tr>`;
    }

    function formSubMenu(menu, data) {
        let checkAll = "";
        let checkD = "";
        let checkE = "";
        let checkV = "";
        let checkI = "";
        let checkO = "";
        let id = 0;

        if (data != null) {
            let menuData = data.filter(function(x) {
                return x.menu_id === menu.id
            });

            if (menuData.length > 0) {
                checkAll = (menuData[0].d === "1" && menuData[0].e === "1" && menuData[0].v === "1" && menuData[0].i === "1" && menuData[0].o === "1") ? "checked" : "";
                checkD = (menuData[0].d === "1") ? "checked" : "";
                checkE = (menuData[0].e === "1") ? "checked" : "";
                checkV = (menuData[0].v === "1") ? "checked" : "";
                checkI = (menuData[0].i === "1") ? "checked" : "";
                checkO = (menuData[0].o === "1") ? "checked" : "";
                id = menuData[0].id
            }
        }

        return `
        <tr>
            <input type="hidden" name="id[]" class="id" value="${id}">
            <th scope="row" class="number text-center">
                <input type="hidden" class="idmenu" name="idmenu[]" value="${menu.id}">
            </th>
            <td class="text-start" style="padding-inline-start:20px;">
                <ul><li style="list-style-type: circle;">${menu.menu_name}</li></ul>
            </td>
            <td class="text-center">
                <div class="square-switch me-0 mt-3">
                    <input type="checkbox" class="check_all checkbox" id="check_allSub${menu.id}" switch="info" name="check_all[]" value="1" ${checkAll}>
                    <label for="check_allSub${menu.id}" data-on-label="Yes" data-off-label="No"></label>
                </div>
            </td>
            <td class="text-center">
                <div class="square-switch me-0 mt-3">
                    <input type="checkbox" class="v checkbox" id="vCheckboxSub${menu.id}" switch="info" name="v[]" value="1" ${checkV}>
                    <label for="vCheckboxSub${menu.id}" data-on-label="Yes" data-off-label="No"></label>
                </div>
            </td>
            <td class="text-center">
                <div class="square-switch me-0 mt-3">
                    <input type="checkbox" class="i checkbox" id="iCheckboxSub${menu.id}" switch="info" name="i[]" value="1" ${checkI}>
                    <label for="iCheckboxSub${menu.id}" data-on-label="Yes" data-off-label="No"></label>
                </div>
            </td>
            <td class="text-center">
                <div class="square-switch me-0 mt-3">
                    <input type="checkbox" class="e checkbox" id="eCheckboxSub${menu.id}" switch="info" name="e[]" value="1" ${checkE}>
                    <label for="eCheckboxSub${menu.id}" data-on-label="Yes" data-off-label="No"></label>
                </div>
            </td>
            <td class="text-center">
                <div class="square-switch me-0 mt-3">
                    <input type="checkbox" class="d checkbox" id="dCheckboxSub${menu.id}" switch="info" name="d[]" value="1" ${checkD}>
                    <label for="dCheckboxSub${menu.id}" data-on-label="Yes" data-off-label="No"></label>
                </div>
            </td>
            <td class="text-center">
                <div class="square-switch me-0 mt-3">
                    <input type="checkbox" class="o checkbox" id="oCheckboxSub${menu.id}" switch="info" name="o[]" value="1" ${checkO}>
                    <label for="oCheckboxSub${menu.id}" data-on-label="Yes" data-off-label="No"></label>
                </div>
            </td>
            <td class="text-center"></td>
        </tr>`;
    }
</script>