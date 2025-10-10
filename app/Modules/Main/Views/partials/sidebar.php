<div class="vertical-menu">
	<div class="d-flex justify-content-center">
		<div class="d-none d-md-block">
			<form class="app-search d-none d-lg-block pt-1 pb-1" style="overflow: hidden;">
				<div class="position-relative">
					<div class="input-group">
						<span class="input-group-text position-absolute end-0 mt-0 me-0 rounded-circle" style="z-index: 3;height: 2.5rem;background-color: #00000000;border: none;"><i class="fas fa-search"></i></span>
						<input type="text" class="form-control rounded-pill ps-2 pe-5" id="search" name="search" autocomplete="off" placeholder="<?= lang('Files.Search') ?>" style="background-color: var(--bs-blue-200);border: none;">
					</div>
				</div>
			</form>
		</div>
	</div>
	<div data-simplebar class="h-100 pb-5">
		<div id="sidebar-menu">
			<?php
			$session = \Config\Services::session();
			$module_active = uri_segment(0);
			$menu_active = uri_segment(1);
			$allowed_role = ['sad', 'daj', 'bpw', 'ot1'];
			?>
			<ul class="metismenu list-unstyled" id="side-menu" style="min-height: 400px">
				<li class="menu-title" data-key="t-menu">
					<?= lang('Files.Menu') ?>
				</li>
				<li class="<?= (($module_active == 'main') ? 'active' : '') ?>" data-search="Dashboard">
					<a href="<?= base_url() ?>">
						<i data-feather="home"></i>
						<span class="nav-text">Dashboard</span>
					</a>
				</li>
				<?php
				function group_by($array, $by)
				{
					$groups = array();
					foreach ($array as $key => $value) {
						$groups[$value->$by][] = $value;
					}
					return $groups;
				}
				function is_new($created_at, $weeks = 2)
				{
					$created_date = new DateTime($created_at);
					$now = new DateTime();
					$interval = $now->diff($created_date);
					return $interval->days <= ($weeks * 7);
				}
				function renderMenuItems($grouped, $menu_active, $module_active)
				{
					foreach ($grouped as $_key => $_grouped) {
						if ($_key == "") {
							foreach ($_grouped as $menu) {
								$url = base_url() . '/' . $menu->module_url . '/' . $menu->menu_url;
								$badgenew = is_new($menu->created_at) ? '<span class="badge bg-danger rounded-pill">!</span>' : '';
								echo '<li class="' . (($menu_active == $menu->menu_url && $module_active == $menu->module_url) ? "active" : "") . '" data-search="' . $menu->menu_name . '">
										<a href="' . $url . '" class="text-truncate" data-bs-toggle="tooltip" data-bs-placement="right" title="' . $menu->menu_name . '">
											<span data-key="t-calendar">' . $menu->menu_name . '</span>&nbsp;' . $badgenew . '
										</a>
									</li>';
							}
						} else {
							echo '<li class="' . ((count(array_filter($_grouped, fn($arr) => strtolower($arr->menu_url) == strtolower($menu_active))) > 0) ? 'active' : '') . '" data-search="' . $_key . '">
									<a href="javascript: void(0);" class="has-arrow">
										<span data-key="t-contacts">' . $_key . '</span>
									</a>
									<ul class="sub-menu" aria-expanded="false">';
							foreach ($_grouped as $menu) {
								$badgenew = is_new($menu->created_at) ? '<span class="badge bg-danger rounded-pill">!</span>' : '';
								echo '<li class="' . (($menu_active == $menu->module_url) ? 'active' : '') . '" data-search="' . $menu->menu_name . '">
										<a href="' . base_url() . '/' . $menu->module_url . '/' . $menu->menu_url . '" class="text-truncate" data-bs-toggle="tooltip" data-bs-placement="right" title="' . $menu->menu_name . '">
											<span class="nav-text">' . $menu->menu_name . '</span>&nbsp;' . $badgenew . '
										</a>
									</li>';
							}
							echo '</ul></li>';
						}
					}
				}
				$module = group_by($session->get('menu'), 'module_name');
				foreach ($module as $key => $_module) {
					echo '<li>';
					echo '<a href="javascript: void(0);" class="' . (count($_module) > 0 ? "has-arrow" : "") . '" data-search="' . $key . '">';
					echo '<i data-feather="' . ($key == 'Administrator' ? 'sliders' : 'grid') . '"></i>';
					echo '<span data-key="t-apps">' . $key . '</span>';
					echo '</a>';
					echo count($_module) > 0 ? '<ul class="sub-menu" aria-expanded="false">' : '';
					$grouped = group_by($_module, 'menu_parent');
					renderMenuItems($grouped, $menu_active, $module_active);
					echo count($_module) > 0 ? '</ul>' : '';
					echo '</li>';
				}
				?>
			</ul>
		</div>
	</div>
</div>