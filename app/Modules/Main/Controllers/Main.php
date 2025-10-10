<?php

namespace App\Modules\Main\Controllers;

use App\Modules\Main\Models\MainModel;
use App\Core\BaseController;

class Main extends BaseController
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
        $session = \Config\Services::session();
        $data = [
            'title_meta' => view('App\Modules\Main\Views\partials\title-meta', ['title' => 'Dashboard | ' . APP_NAME]),
            'page_title' => view('App\Modules\Main\Views\partials\page-title', ['title' => 'Dashboard ' . APP_NAME , 'li_1' => '', 'li_2' => '']),
            'css_file'   => base_url('assets/css/dashboard.css'),
            'role'       => $session->get('role'),
            'role_code'  => $session->get('role_code'),
            'role_name'  => $session->get('role_name'),
        ];

        return view('App\Modules\Main\Views\layout', $data);
    }

    public function changepassword()
    {
        $data = [
            'title_meta' => view('App\Modules\Main\Views\partials\title-meta', ['title' => 'Change Password | ' . APP_NAME]),
            'page_titles' => view('App\Modules\Main\Views\partials\page-title', ['title' => '', 'li_1' => 'Dashboard', 'li_2' => 'Change Password']),
            'load_view' => 'App\Modules\Main\Views\changepassword',
        ];

        return view('App\Modules\Main\Views\layout', $data);
    }

    public function dashboard_map()
    {
        $session = \Config\Services::session();
        $data = [
            'customjs'      => 'dashboard_map',
            'title_meta'    => view('App\Modules\Main\Views\partials\title-meta', ['title' => 'Dashboard Control Center']),
            'page_titles'   => view('App\Modules\Main\Views\partials\page-title', ['title' => '', 'li_1' => 'Dashboard', 'li_2' => 'Control Center']),
            'load_view'     => 'App\Modules\Main\Views\dashboard_map',
            'role_code'     => $session->get('role_code'),
        ];
        return view('App\Modules\Main\Views\layout_map', $data);
    }
}
