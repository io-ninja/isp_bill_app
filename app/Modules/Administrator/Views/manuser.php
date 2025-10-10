<?php $session = \Config\Services::session(); ?>
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
			<div class="tab-content p-3 text-muted">
				<div class="tab-pane active" id="tab-data" role="tabpanel">
					<div class="row align-items-center">
						<div class="col-lg-12 align-self-center">
							<div class="mb-3">
								<div class="accordion" id="filtertabs">
									<div class="accordion-item">
										<h2 class="accordion-header" id="headingFilter">
											<button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#filter1" aria-expanded="false" aria-controls="filter1">Filter data User</button>
										</h2>
										<div id="filter1" class="accordion-collapse collapse" aria-labelledby="headingFilter" data-bs-parent="#headingFilter">
											<div class="accordion-body">
												<div class="d-flex flex-row justify-content-start align-items-center gap-3">
													<div class="col-auto flex-fill">
														<div class="mb-3">
															<label for="filter_jenuser_id">Jenis User</label>
															<select class="form-select select2-container sel2" id="filter_jenuser_id" name="filter_jenuser_id">
																<option></option>
																<?php
																foreach ($jenisusers as $jenisuser) {
																	if ($session->get('role_code') === 'sad') {
																		echo '<option value="' . $jenisuser->id . '" data-code="' . $jenisuser->user_web_role_code . '">' . $jenisuser->user_web_role_name . '</option>';
																	} else {
																		echo '<option value="' . $jenisuser->id . '" data-code="' . $jenisuser->user_web_role_code . '">' . $jenisuser->user_web_role_name . '</option>';
																	}
																}
																?>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="table-responsive">
							<table id="datatable" class="table table-theme table-row v-middle">
								<thead>
									<tr>
										<th><span>#</span></th>
										<th><span>Nama User</span></th>
										<th><span>Email User</span></th>
										<th><span>Username</span></th>
										<th><span>Jenis User</span></th>
										<th></th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
				<?php if ($rules->i == "1") { ?>
					<div class="tab-pane" id="tab-form" role="tabpanel">
						<div class="row" id="alert_user_exist"></div>
						<div class="card-body">
							<form data-plugin="parsley" data-option="{}" id="form" validate>
								<input type="hidden" class="form-control" id="id" name="id" required>
								<input type="hidden" id="user_web_role_code" name="user_web_role_code">
								<?= csrf_field(); ?>
								<div class="row">
									<div class="col-md-12">
										<div class="mb-3">
											<label>Nama</label>
											<input type="text" class="form-control" id="user_web_name" name="user_web_name" autocomplete="one-time-code" placeholder="Nama lengkap" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label>Email</label>
											<input type="email" class="form-control" id="user_web_email" name="user_web_email" autocomplete="one-time-code" placeholder="Email user" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label>No. HP</label>
											<div class="input-group">
												<span class="input-group-text">+62</span>
												<input type="text" class="form-control" id="user_web_phone" name="user_web_phone" autocomplete="one-time-code" placeholder="No. HP user">
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label>Username</label>
											<input type="text" class="form-control" id="user_web_username" name="user_web_username" autocomplete="one-time-code" placeholder="Username untuk login" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="user_web_password">Password</label>
											<div class="input-group auth-pass-inputgroup">
												<input type="password" class="form-control" id="user_web_password" name="user_web_password" autocomplete="one-time-code" aria-describedby="password-addon" placeholder="Password untuk login" required>
												<button class="btn btn-light ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="mb-3">
											<label>Jenis User</label>
											<select class="form-select sel2" id="user_web_role_id" name="user_web_role_id" required>
												<option></option>
												<?php
												foreach ($jenisusers as $jenisuser) {
													if ($session->get('role_code') === 'sad') {
														echo '<option value="' . $jenisuser->id . '" data-code="' . $jenisuser->user_web_role_code . '">' . $jenisuser->user_web_role_name . '</option>';
													} else {
														echo '<option value="' . $jenisuser->id . '" data-code="' . $jenisuser->user_web_role_code . '">' . $jenisuser->user_web_role_name . '</option>';
													}
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<hr>
								<div class="d-flex flex-row pt-3 justify-content-between align-items-center">
									<button class="btn btn-dark" type="reset">
										<i class="fa fa-undo me-1"></i>Reset
									</button>
									<button type="submit" class="btn btn-primary" id="btn_save">
										<i class="fa fa-save me-1"></i>Simpan
									</button>
								</div>
							</form>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<script src="<?= site_url() ?>assets/js/pages/pass-addon.init.js"></script>
<script type="text/javascript">
	const auth_insert = '<?= $rules->i ?>';
	const auth_edit = '<?= $rules->e ?>';
	const auth_delete = '<?= $rules->d ?>';
	const auth_otorisasi = '<?= $rules->o ?>';

	const url = '<?= base_url() . "/" . uri_segment(0) . "/action/" . uri_segment(1) ?>';
	const url_ajax = '<?= base_url() . "/" . uri_segment(0) . "/ajax" ?>';
	const role_code = '<?= $role_code ?>';
	const segment = '<?= uri_segment(1) ?>';

	var dataStart = 0;
	var ce;

	const select2Array = [{
			id: 'filter_jenuser_id',
			url: '/user_web_role_select_get',
			placeholder: 'Pilih Jenis User',
			params: null
		},
	];

	$(document).ready(function() {
		ce = new CoreEvents();
		ce.url = url;
		ce.ajax = url_ajax;
		ce.csrf = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>"
		};
		ce.tableColumn = datatableColumn();

		ce.insertHandler = {
			placeholder: 'Berhasil menyimpan user',
			afterAction: function(result) {}
		}

		ce.editHandler = {
			placeholder: '',
			afterAction: function(result) {
				var data = result.data;
				$('#user_web_password').attr('readonly', 'readonly');
				$('#password-addon').attr('disabled', 'disabled');
				$('label[for="user_web_password"]').html(`Password <span class="text-danger font-size-11">*(Ubah password di menu profil kanan atas)</span>`);
				$('#user_web_role_id').val(data.user_web_role_id).trigger('change');
				$('#user_web_email').attr('readonly', 'readonly');

				var kode = data.user_web_role_code;
				console.log(kode);

				// if (kode === 'bpw') {
				// 	ce.select2Init('#bptd_id', '/bptd_select_get', 'Pilih Lokasi BPTD', {}, null, function(data) {});
				// 	$('#bptd_id').select2("trigger", "select", {
				// 		data: {
				// 			id: data.lokker_id,
				// 			text: data.lokker_name
				// 		}
				// 	});
				// 	$('#bptd_select').show();
				// } else if (['ot1', 'ot2', 'ot3', 'ot4', 'ot5', 'ot6', 'ot7', 'ot8', 'ot9'].includes(kode)) {
				// 	if (data.user_web_opr_id != null) {
				// 		ce.select2Init('#user_web_opr_id', '/po_select_get', 'Pilih PO');
				// 		$('#user_web_opr_id').select2("trigger", "select", {
				// 			data: {
				// 				id: data.user_web_opr_id,
				// 				text: data.user_web_opr_name
				// 			}
				// 		});

				// 		if ($('#form').find('input[name="user_web_bptd_id"]').length > 0) {
				// 			$('#form').find('input[name="user_web_bptd_id"]').val(data.user_web_bptd_id);
				// 		} else {
				// 			$(`<input type="hidden" name="user_web_bptd_id" value="${data.user_web_bptd_id}">`).appendTo('#form');
				// 		}
				// 		$('#po_select').show();
				// 	} else {
				// 		ce.select2Init('#user_web_opr_id', '/po_select_get', 'Pilih PO');
				// 		$('#po_select').show();
				// 	}
				// }
			}
		}

		ce.deleteHandler = {
			placeholder: 'Berhasil menghapus user',
			afterAction: function() {}
		}

		ce.resetHandler = {
			action: function() {
				$('.select_').hide();
				$('.sel2').val(null).trigger('change');
				$('#user_web_role_id').select2('enable');
			}
		}

		select2Array.forEach(function(x) {
			ce.select2Init('#' + x.id, x.url, x.placeholder, x.params);
		});

		$('#user_web_role_id').select2({
			placeholder: "Pilih jenis user",
			width: '100%'
		}).on('select2:select', function(e) {
			$('.select_').hide();
			$('#user_web_role_code').val('');
			const kode = $("#user_web_role_id").select2().find(":selected").data("code");
		});

		$('#filter_jenuser_id').select2({
			placeholder: "Pilih jenis user",
			width: '100%',
			allowClear: true
		}).on('select2:select', function(e) {
			const kode = $("#filter_jenuser_id").select2().find(":selected").data("code");
			ce.filter = {
				role_id: $(this).val()
			};
			ce.load(ce.filter, ce.placeholder, ce.dom, ce.buttons);
			$('.buttons-html5').removeClass('btn-secondary').addClass('btn-link');
		});

		$(document)
			.on('keypress', '#user_web_phone', function(e) {
				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
					return false;
				}
			})
			.on('click', '#otorisasi_login', function(e) {
				e.preventDefault();
				var id = $(this).data('id');
				Swal.fire({
					title: 'Otorisasi Login',
					text: "Anda yakin ingin login sebagai user ini?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#6c757d',
					confirmButtonText: 'Ya, Login!'
				}).then((result) => {
					if (result.isConfirmed) {
						ce.sendRequest(`${url}_login`, 'post', 'json', {
							id: id,
							"<?= csrf_token() ?>": "<?= csrf_hash() ?>"
						});
						ce.requestHandler.beforeAction = function() {
							$('#otorisasi_login').attr('disabled', 'disabled');
						};
						ce.requestHandler.afterAction = function(rs) {
							$('#otorisasi_login').removeAttr('disabled');
							if (rs.success) {
								window.location.href = rs.redirect;
							} else {
								Swal.fire({
									icon: 'error',
									title: 'Oops...',
									text: rs.message,
								});
							}
						};
						ce.requestHandler.errorAction = function() {
							$('#otorisasi_login').removeAttr('disabled');
							swal.fire('Oops...', 'Terjadi kesalahan saat mengirim data', 'error');
						};
					}
				});
			})

		ce.placeholder = 'Cari User...';
		ce.load(null, ce.placeholder);
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
				data: "user_web_name",
				className: "text-start align-middle",
				orderable: true,
				width: 80
			},
			{
				data: "user_web_email",
				className: "text-start align-middle",
				orderable: true,
				width: 20
			},
			{
				data: "user_web_username",
				className: "text-center align-middle",
				orderable: true,
				width: 20,
				render: function(a, type, data, index) {
					return `<a href="javascript:void(0)" class="text-primary tooltipp" id="alert-message" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to copy" onclick="copyToClipboard('Username', '${data.user_web_username}')">${data.user_web_username}</a>`;
				}
			},
			{
				data: "user_web_role_sort",
				className: "text-start align-middle",
				orderable: true,
				width: 100,
				render: function(a, type, data, index) {
					if (data.user_web_role_id === '1') {
						return `<span><i class="fas fa-crown text-warning"></i> ${data.user_web_role_name}</span>`;
					} else if (data.user_web_role_id === '2') {
						return `<span><i class="fas fa-shield-alt text-secondary"></i> ${data.user_web_role_name}</span>`;
					} else {
						return `<span><i class="fas fa-user-tag text-primary"></i> ${data.user_web_role_name}</span>`;
					}
				}
			},
			{
				data: "id",
				title: null,
				orderable: false,
				width: 1,
				className: 'text-center align-middle',
				render: function(a, type, data, index) {
					let button = ''
					if (role_code == "sad") {
						button += `<button class="btn btn-sm btn-outline-success" id="otorisasi_login" data-id="${data.id}" title="Otorisasi"><i class="fa fa-key"></i> Login</button>`;
					}
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