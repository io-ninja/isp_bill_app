<div class="vertical-menu">
	<div class="h-100">
		<div id="sidebar-menu">
			<?php
			$session = \Config\Services::session();
			$module_active = uri_segment(0);
			$menu_active = uri_segment(1);
			?>
			<ul class="metismenu list-unstyled" id="side-menu" style="min-height: 400px">
				<li class="menu-title" data-key="t-menu">
					<?= lang('Files.Menu') ?>
				</li>
				<li class="<?= (($module_active == 'main') ? 'active' : '') ?>">
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
				$module = group_by($session->get('menu'), 'module_name');
				foreach ($module as $key => $_module) {
					$badgenew = '';
					if ($key == 'Administrator') {
						echo '<li>
								<a href="javascript: void(0);" class="' . (count($_module) > 0 ? "has-arrow" : "") . '">
									<i data-feather="sliders"></i>
									<span data-key="t-apps">' . $key . '</span>
								</a>';
					} else {
						$badgenew = is_new($_module[0]->created_at) ? '<span class="badge badge-soft-danger badge-pill float-right">New!</span>' : '';
						echo '<li>
								<a href="javascript: void(0);" class="' . (count($_module) > 0 ? "has-arrow" : "") . '">
									<i data-feather="grid"></i>
									<span data-key="t-apps">' . $key . '</span>
									' . $badgenew . '
								</a>';
					}
					echo count($_module) > 0 ? '<ul class="sub-menu" aria-expanded="false">' : '';
					$grouped = group_by($_module, 'menu_parent');
					foreach ($grouped as $_key => $_grouped) {
						if ($_key == "") {
							foreach ($_grouped as $__key => $menu) {
								$url = base_url() . '/' . $menu->module_url . '/' . $menu->menu_url;
								$badgenew = is_new($menu->created_at) ? '<span class="badge badge-soft-danger badge-pill float-right">New!</span>' : '';
								echo '<li class="' . (($menu_active == $menu->menu_url && $module_active == $menu->module_url) ? "active" : "") . '">
											<a href="' . $url . '" class="">
												<span data-key="t-calendar">' . $menu->menu_name . '</span>' . $_key . '
												' . $badgenew . '
											</a>
										</li>';
							}
						} else {
							echo '<li class="' . ((count(array_filter($_grouped, function ($arr) use ($menu_active) {
								return strtolower($arr->menu_url) == strtolower($menu_active);
							})) > 0) ? 'active' : '') . '">
									<a href="javascript: void(0);" class="has-arrow">
										<span data-key="t-contacts">' . $_key . '</span>
									</a>
									<ul class="sub-menu" aria-expanded="false">';
							foreach ($_grouped as $__key => $menu) {
								$badgenew = is_new($menu->created_at) ? '<span class="badge badge-soft-danger badge-pill float-right">New!</span>' : '';
								echo '<li class="' . (($menu_active == $menu->module_url) ? 'active' : '') . '">
											<a href="' . base_url() . '/' . $menu->module_url . '/' . $menu->menu_url . '" class="">
												<span class="nav-text">' . $menu->menu_name . '</span>
												' . $badgenew . '
											</a>
										</li>';
							}
							echo '</ul>
								</li>';
						}
					}
					echo count($_module) > 0 ? '</ul>' : '';
				}
				?>
			</ul>
		</div>
	</div>
</div>