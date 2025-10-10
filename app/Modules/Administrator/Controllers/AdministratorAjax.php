<?php

namespace App\Modules\Administrator\Controllers;

use App\Modules\Administrator\Models\AdministratorModel;
use App\Core\BaseController;

class AdministratorAjax extends BaseController
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

    public function menu_select_get($module_id)
    {
        $menu = $this->administratorModel->base_get('s_menu', ['module_id' => $module_id, 'menu_id' => NULL, 'is_deleted' => 0])->getResult();
        $option = array_map(function ($data) {
            return "<option value='" . $data->id . "'>" . $data->menu_name . "</option>";
        }, $menu);
        echo "<option value=''>Jadikan Menu Utama</option>" . implode("", $option);
    }

    public function moduleuser_get()
    {
        $module_user = groupby($this->administratorModel->getModuleUser($_POST['id']), 'module_id');
        echo json_encode($module_user);
    }

    public function menu_get($module_id)
    {
        $menus = $this->administratorModel->getParentMenu($module_id);
        $array = array_map(function ($menu) {
            $x = json_decode(json_encode($menu), true);
            $x['submenu'] = $this->administratorModel->getSubMenu($x['id']);
            return $x;
        }, $menus);

        echo json_encode($array);
    }

    public function module_select_get()
    {
        $module = $this->administratorModel->getModules();
        $option = array_map(function ($data) {
            return "<option value='" . $data->id . "'>" . $data->module_name . "</option>";
        }, $module);
        return "<select class='idmodule' name='idmodule[]' required><option value=''>Pilih Modul</option>" . implode("", $option) . "<select>";
    }

    public function idprov_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.prov AS 'text' , a.singkatan, b.id AS bptd_id , b.terminal_name , b.timezone , b.tz
                    FROM m_lokprov a
                    INNER JOIN m_bptd b ON a.id = b.lokprov_id AND b.lokker_type = 'BPTD' AND b.is_deleted = 0
                    WHERE a.is_deleted = 0
        ";
        $where = ["a.prov", "a.singkatan"];
        $groupby = ["a.id"];
        $orderby = ["a.id", "b.idkabkota"];
        parent::_loadSelect2($data, $query, $where, $orderby, $groupby);
    }

    public function idkabkota_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id , a.kabkota AS `text` , a.kode , a.ibukota , a.group_nm
                    FROM m_lokabkota a
                    WHERE a.is_deleted = 0 AND a.idprov = " . $data['idprov'];
        $where = ["a.kabkota", "a.kode", "a.ibukota", "a.group_nm"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function id_kec_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.kec as 'text' from m_lokec a where a.is_deleted='0' and  a.idkabkota='" . $data['idkabkota'] . "' ";
        $where = ["a.kec"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function id_kel_select_get()
    {
        $data = $this->request->getGet();
        $query = "SELECT a.id, a.kel as 'text' from m_lokkel a where a.is_deleted='0' and  a.idkec='" . $data['idkec'] . "' ";
        $where = ["a.kel"];

        parent::_loadSelect2($data, $query, $where);
    }

    public function user_web_role_select_get()
    {
        $data = $this->request->getGet();
        $rolebyid = isset($data['role']) ? ' AND a.id >= ' . $data['role'] : '';
        $query = "SELECT a.id AS user_web_role_id, a.user_web_role_name AS 'text', a.user_web_role_code, a.user_web_role_sort AS id FROM s_user_web_role a WHERE a.is_deleted = 0 $rolebyid";
        $where = ["a.user_web_role_name", "a.user_web_role_code"];
        $orderby = ["a.user_web_role_sort ASC"];

        parent::_loadSelect2($data, $query, $where, $orderby);
    }
}
