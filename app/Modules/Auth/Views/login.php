<?php echo view('App\Modules\Main\Views\partials\head-main'); ?>

<head>
	<meta charset="utf-8" />
	<title><?= APP_NAME ?> | Login Authentication</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="<?= getenv('prop.appname') ?> | Login <?= getenv('prop.appdesc') ?>" name="description" />
	<meta content="<?= getenv('prop.appauthor') ?>" name="author" />
	<link rel="shortcut icon" href="<?= base_url() ?><?= getenv('prop.favicon') ?>">
	<link rel="stylesheet" href="<?= base_url() ?>/assets/css/preloader.min.css" type="text/css" />
	<link rel="stylesheet" href="<?= base_url() ?>/assets/css/bootstrap.min.css" id="bootstrap-style" type="text/css" />
	<link rel="stylesheet" href="<?= base_url() ?>/assets/css/app.min.css" id="app-style" type="text/css" />
	<link rel="stylesheet" href="<?= base_url() ?>/assets/css/icons.min.css" type="text/css" />
</head>
<style>
	.bg-primary,
	.btn-primary {
		background-color: <?= getenv('prop.primarycolor') ?> !important;
	}

	.auth-bg {
		background-image: url(<?= base_url(getenv('prop.apploginbg')) ?>) !important;
	}
</style>
<?php echo view('App\Modules\Main\Views\partials\body'); ?>
<div class="auth-page">
	<div class="container-fluid p-0">
		<div class="row g-0">
			<div class="col-xxl-3 col-lg-4 col-md-5">
				<div class="auth-full-page-content d-flex p-sm-5 p-4">
					<div class="w-100">
						<div class="d-flex flex-column h-100 text-center">
							<div class="mb-4 mb-md-5 text-center">
								<a href="/" class="d-block auth-logo">
									<img src="<?= base_url() ?><?= getenv('prop.applogo') ?>" alt="" height="28"><span class="logo-txt"><?= getenv('prop.appname') ?></span>
								</a>
								<p class="text-muted mt-2"><?= getenv('prop.appdesc') ?></p>
							</div>
							<div class="auth-content my-auto">
								<div class="text-center">
									<h5 class="mb-0">Halaman Login Dashboard</h5>
									<!-- <p class="text-muted mt-2"></p> -->
								</div>
								<form id="form-login" class="custom-form mt-4 pt-2" method="POST" enctype="multipart/form-data" action="<?= base_url() ?>/main" autocomplete="one-time-code">
									<?= csrf_field() ?>
									<div class="mb-3">
										<label class="form-label">Username</label>
										<input type="text" class="form-control rounded-pill" id="username" name="username" placeholder="Enter username" autocomplete="one-time-code">
									</div>
									<div class="mb-3">
										<div class="d-flex align-items-start">
											<div class="flex-grow-1">
												<label class="form-label">Password</label>
											</div>
										</div>
										<div class="input-group auth-pass-inputgroup position-relative">
											<input type="password" class="form-control rounded-pill pr-5" id="password" name="password" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon" autocomplete="one-time-code">
											<button class="btn btn-light position-absolute end-0 top-0 mt-0 me-0 rounded-circle" type="button" id="password-addon" style="z-index: 10;">
												<i class="mdi mdi-eye-outline"></i>
											</button>
										</div>
									</div>
									<div class="mb-3">
										<button type="submit" class="btn btn-primary w-100 waves-effect waves-light" id="submit_btn">Masuk</button>
									</div>
								</form>
								<!-- <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
									<div class="border-bottom w-100 ml-5" style="border-bottom: 3px solid #EBEDF3 !important"></div>
									<span class="px-2 small text-muted font-weight-bold text-muted">OR</span>
									<div class="border-bottom w-100 mr-5" style="border-bottom: 3px solid #EBEDF3 !important"></div>
								</div>
								<div class="d-flex flex-column position-relative text-center ">
									<div class="row">
										<div class="col-lg-12">
											<div class="w-100 text-center d-flex justify-content-center align-items-center" id="buttonDiv"></div>
										</div>
									</div>
								</div> -->
							</div>
							<div class="mt-4 mt-md-5 text-center">
								<span>© <?= date('Y') ?> <?= getenv('prop.appauthor') ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xxl-9 col-lg-8 col-md-7">
				<div class="auth-bg pt-md-5 p-4 d-flex">
					<div class="bg-overlay bg-primary"></div>
					<ul class="bg-bubbles">
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
					</ul>
					<div class="row justify-content-center align-items-center">
						<div class="col-xl-12">
							<div class="p-0 p-sm-4 px-xl-0">
								<div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
									<div class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
										<button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
									</div>
									<div class="carousel-inner">
										<div class="carousel-item active">
											<div class="testi-contain text-white">
												<i class="bx bxs-quote-alt-left text-success display-6"></i>
												<h4 class="mt-4 fw-medium lh-base text-white"></h4>
												<div class="mt-4 pt-3 pb-5">
													<div class="d-flex align-items-center">
														<div class="flex-shrink-0">
															<img src="<?= base_url() ?><?= getenv('prop.applogo') ?>" class="avatar-md img-fluid" style="height: 55px !important;" alt="...">
														</div>
														<div class="flex-grow-1 ms-3">
															<h5 class="font-size-18 text-white"><?= getenv('prop.appdesc') ?></h5>
															<p class="mb-0 text-white-50"></p>
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
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?= base_url() ?>/assets/libs/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= site_url() ?>assets/js/pages/pass-addon.init.js"></script>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<!-- <script src="https://www.google.com/recaptcha/api.js?render=<?= getenv('RECAPTCHA_SITE_KEY') ?>"></script> -->
<script type="text/javascript">
	$(document).ready(function() {
		window.onload = function() {
			google.accounts.id.initialize({
				client_id: "884122324633-u06ijjlch1912n0l09f7gnkkqlj289ci.apps.googleusercontent.com",
				callback: handleCredentialResponse
			});

			google.accounts.id.renderButton(
				document.getElementById("buttonDiv"), {
					theme: "outline",
					size: "large",
					locale: "id",
				}
			);
			$('#username').focus();
			// google.accounts.id.prompt(); // also display the One Tap dialog
		}

		$('#submit_btn').on('click', function() {
			onSubmit();
		});
	});

	function onSubmit(token) {
		var $form = $("#form-login");
		var url = '<?= base_url() ?>/auth/action/login';
		$.ajax({
			type: "POST",
			url: url,
			data: $form.serialize(),
			dataType: 'json',
			beforeSend: function() {
				Swal.fire({
					title: "",
					icon: "info",
					text: "Mohon ditunggu...",
					willOpen: function() {
						Swal.showLoading()
					}
				});
			},
			success: function(rs) {
				swal.close();
				if (rs.success) {
					window.location = "<?= base_url() ?>/main";
				} else {
					Swal.fire({
						title: rs.title,
						text: rs.text,
						icon: 'warning',
						showConfirmButton: false,
						timer: 5000
					});
				}
			},
			error: function(data) {
				swal.close();
				Swal.fire({
					title: 'Perhatian!',
					text: '404 Halaman Tidak Ditemukan',
					icon: 'warning',
					showConfirmButton: false,
					timer: 1500
				});
			}
		});
	}

	function handleCredentialResponse(response) {
		let jwt = parseJwt(response.credential)
		let email = jwt.email;

		loginWithGoogle(email);
	}

	function loginWithGoogle(email) {
		Swal.fire({
			title: "",
			icon: "info",
			text: "Mohon ditunggu...",
			onOpen: function() {
				Swal.showLoading()
			}
		})

		var url = '<?= base_url() ?>/auth/action/loginGoogle';

		$.post(url, {
			email: email,
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>"
		}, function(data) {
			var ret = $.parseJSON(data);
			swal.close();
			if (ret.success) {
				window.location = "<?= base_url() ?>/main";
			} else {
				Swal.fire({
					title: ret.title,
					text: ret.text,
					icon: 'error',
					showConfirmButton: false,
					timer: 2500
				})
			}
		}).fail(function(data) {
			swal.close();
			Swal.fire({
				title: 'Error',
				text: 'Sesi Anda telah berakhir, silahkan refresh halaman ini',
				icon: 'error',
				showConfirmButton: false,
				timer: 2500
			})
		});
	}

	function parseJwt(token) {
		var base64Url = token.split('.')[1];
		var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
		var jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function(c) {
			return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
		}).join(''));

		return JSON.parse(jsonPayload);
	};
</script>
</body>

</html>