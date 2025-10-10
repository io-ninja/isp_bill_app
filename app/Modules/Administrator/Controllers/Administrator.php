<?php

namespace App\Modules\Administrator\Controllers;

use App\Modules\Administrator\Models\AdministratorModel;
use App\Core\BaseController;

class Administrator extends BaseController
{
    private $administratorModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->administratorModel = new AdministratorModel();
    }

    public function index()
    {
        return redirect()->to(base_url());
    }

    private function generateViewData($title, $li_1, $li_2, $view, $additionalData = [])
    {
        $data = [
            'title_meta' => view('App\Modules\Main\Views\partials\title-meta', ['title' => $title . ' | ' . APP_NAME]),
            'page_titles' => view('App\Modules\Main\Views\partials\page-title', ['title' => '', 'li_1' => $li_1, 'li_2' => $li_2]),
            'load_view' => $view,
            'role_code' => $this->session->get('role_code'),
        ];

        return array_merge($data, $additionalData);
    }

    public function manmodul()
    {
        $data = $this->generateViewData('Manajemen Modul', 'Administrator', 'Manajemen Modul', 'App\Modules\Administrator\Views\manmodul');
        return parent::_authView($data);
    }

    public function manmenu()
    {
        $additionalData = ['modules' => $this->administratorModel->getModules()];
        $data = $this->generateViewData('Manajemen Menu', 'Administrator', 'Manajemen Menu', 'App\Modules\Administrator\Views\manmenu', $additionalData);
        return parent::_authView($data);
    }

    public function manjenisuser()
    {
        $additionalData = ['modules' => $this->administratorModel->getModules()];
        $data = $this->generateViewData('Jenis User', 'Administrator', 'Jenis User', 'App\Modules\Administrator\Views\manjenisuser', $additionalData);
        return parent::_authView($data);
    }

    public function manhakakses()
    {
        $additionalData = [
            'modules' => $this->administratorModel->getModules(),
            'jenisusers' => $this->administratorModel->getUserRoles(),
        ];
        $data = $this->generateViewData('Hak Akses', 'Administrator', 'Hak Akses', 'App\Modules\Administrator\Views\manhakakses', $additionalData);
        return parent::_authView($data);
    }

    public function manuser()
    {
        $additionalData = [
            'modules' => $this->administratorModel->getModules(),
            'jenisusers' => $this->administratorModel->getUserRoles(),
        ];
        $data = $this->generateViewData('Manajemen User', 'Administrator', 'Manajemen User', 'App\Modules\Administrator\Views\manuser', $additionalData);
        return parent::_authView($data);
    }

    public function manprov()
    {
        $data = $this->generateViewData('Master Provinsi', 'Manajemen Wilayah', 'Master Provinsi', 'App\Modules\Administrator\Views\manprov');
        return parent::_authView($data);
    }

    public function mankabkota()
    {
        $data = $this->generateViewData('Master Kabupaten/Kota', 'Manajemen Wilayah', 'Master Kabupaten/Kota', 'App\Modules\Administrator\Views\mankabkota');
        return parent::_authView($data);
    }

    public function mankec()
    {
        $data = $this->generateViewData('Master Kecamatan', 'Manajemen Wilayah', 'Master Kecamatan', 'App\Modules\Administrator\Views\mankec');
        return parent::_authView($data);
    }

    public function mankel()
    {
        $data = $this->generateViewData('Master Kelurahan', 'Manajemen Wilayah', 'Master Kelurahan', 'App\Modules\Administrator\Views\mankel');
        return parent::_authView($data);
    }
}
