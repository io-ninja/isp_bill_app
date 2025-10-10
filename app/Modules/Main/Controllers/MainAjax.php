<?php

namespace App\Modules\Main\Controllers;

use App\Modules\Main\Models\MainModel;
use App\Core\BaseController;

class MainAjax extends BaseController
{
	private $mainModel;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->mainModel = new MainModel();
	}

	public function index()
	{
		return redirect()->to(base_url());
	}
}
