<?php

namespace App\Modules\Administrator\Controllers;

use App\Modules\Administrator\Models\AdministratorModel;
use App\Modules\Auth\Models\AuthModel;
use App\Core\BaseController;

class AdministratorAction extends BaseController
{
    private $administratorModel;
    private $authModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->administratorModel = new AdministratorModel();
        $this->authModel = new AuthModel();
    }

    public function index()
    {
        return redirect()->to(base_url());
    }

    public function manmodul_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* FROM s_module a WHERE a.is_deleted = 0";
            $where = ["a.module_url", "a.module_name"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function manmodul_save()
    {
        parent::_authInsert(function () {
            parent::_insert('s_module', $this->request->getPost());
        });
    }

    public function manmodul_otorisasi()
    {
        parent::_authVerif(function () {
            $data = $this->request->getPost();
            unset($data['bsOriginalTitle']);
            $data['is_new'] = $data['isnew'];
            unset($data['isnew']);
            parent::_otorisasi('s_module', $data);
        });
    }

    public function manmodul_edit()
    {
        parent::_authEdit(function () {
            parent::_edit('s_module', $this->request->getPost());
        });
    }

    public function manmodul_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('s_module', $this->request->getPost());
        });
    }

    public function manmenu_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.*, b.module_name, c.menu_name as menu_parent from s_menu a
            left join s_module b on a.module_id = b.id
            left join s_menu c on a.menu_id = c.id
            where a.is_deleted = 0 ";
            $where = ["a.menu_url", "a.menu_name", "b.module_name", "c.menu_name"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function manmenu_save()
    {
        parent::_authInsert(function () {
            $data = $this->request->getPost();
            $data['menu_id'] = empty($data['menu_id']) ? null : $data['menu_id'];
            parent::_insert('s_menu', $data);
        });
    }

    public function manmenu_otorisasi()
    {
        parent::_authVerif(function () {
            $data = $this->request->getPost();
            unset($data['bsOriginalTitle']);
            $data['is_new'] = $data['isnew'];
            unset($data['isnew']);
            parent::_otorisasi('s_menu', $data);
        });
    }

    public function manmenu_edit()
    {
        parent::_authEdit(function () {
            parent::_edit('s_menu', $this->request->getPost());
        });
    }

    public function manmenu_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('s_menu', $this->request->getPost());
        });
    }

    public function manjenisuser_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* from s_user_web_role a where a.is_deleted = 0";
            $where = ["a.user_web_role_name"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function manjenisuser_save()
    {
        parent::_authInsert(function () {
            parent::_insert('s_user_web_role', $this->request->getPost());
        });
    }

    public function manjenisuser_edit()
    {
        parent::_authEdit(function () {
            parent::_edit('s_user_web_role', $this->request->getPost());
        });
    }

    public function manjenisuser_delete()
    {
        parent::_authDelete(function () {
            $data = $this->request->getPost();
            $this->db->transBegin();
            $newdata = [
                'is_deleted' => 1,
                'last_edited_at' => date("Y-m-d H:i:s"),
                'last_edited_by' => $this->session->get('id')
            ];

            $hakakses = $this->db->query("SELECT a.* FROM s_user_web_privilege a WHERE a.is_deleted = 0 AND a.user_web_role_id = '" . $data['id'] . "' ")->getResult();
            if (count($hakakses) > 0) {
                $uppriv = $this->db->query("UPDATE s_user_web_privilege SET ? WHERE user_web_role_id = '" . $data['id'] . "' ", $newdata);
                if ($uppriv) {
                    parent::_delete('s_user_web_role', $this->request->getPost());
                    $this->db->transCommit();
                } else {
                    $this->db->transRollback();
                    echo json_encode(array('success' => false, 'message' => $this->db->error()));
                }
            } else if (count($hakakses) == 0) {
                parent::_delete('s_user_web_role', $this->request->getPost());
                $this->db->transCommit();
            } else {
                $this->db->transRollback();
                echo json_encode(array('success' => false, 'message' => $this->db->error()));
            }
            $this->db->transComplete();
        });
    }

    public function manuser_load()
    {
        parent::_authLoad(function () {
            $data = $this->request->getPost();
            $filter = $data['filter'];
            $role = isset($filter['role_id']) && $filter['role_id'] != '' ? ' AND b.user_web_role_sort >= ' . $filter['role_id'] . ' ' : (!empty($this->session->get('role')) && $this->session->get('role') != '1' ? ' AND b.user_web_role_sort > ' . $this->session->get('role') . ' ' : '');

            $query = "SELECT a.id, a.user_web_username, a.user_web_password, a.user_web_email, a.user_web_phone, a.user_web_name, a.user_web_role_id, b.user_web_role_name , b.user_web_role_code , b.user_web_role_sort
                        FROM m_user_web a
                        LEFT JOIN s_user_web_role b ON a.user_web_role_id = b.id AND b.is_deleted = 0
                        WHERE a.is_deleted = 0 $role";
            $where = ["a.user_web_name", "a.user_web_username", "a.user_web_email", "b.user_web_role_name"];
            $orderby = ["b.user_web_role_sort ASC, a.user_web_name ASC"];

            parent::_loadDatatable($query, $where, $this->request->getPost(), null, $orderby);
        });
    }

    public function manuser_save()
    {
        parent::_authInsert(function () {
            $data = $this->request->getPost();
            unset($data['user_web_role_code']);

            if ($data['id'] == "") {
                $data['user_web_password'] = md5($data['user_web_password']);
            } else {
                unset($data['user_web_email']);
                unset($data['user_web_password']);
            }
            parent::_insert('m_user_web', $data);
        });
    }

    public function manuser_edit()
    {
        parent::_authEdit(function () {
            $data = $this->request->getPost();
            $query = "SELECT a.id, a.user_web_username, a.user_web_password, a.user_web_email, a.user_web_phone, a.user_web_name, a.user_web_role_id, b.user_web_role_name , b.user_web_role_code
                        FROM m_user_web a
                        LEFT JOIN s_user_web_role b ON a.user_web_role_id = b.id AND b.is_deleted = 0
                        WHERE a.is_deleted = 0
                        AND a.id = " . $data['id'] . " ";
            parent::_edit('m_user_web', $this->request->getPost(), null, $query);
        });
    }

    public function manuser_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('m_user_web', $this->request->getPost());
        });
    }

    public function manuser_login()
    {
        parent::_authLoad(function () {
            $data = $this->request->getPost();
            $session = \Config\Services::session();
            $query = $this->authModel->getUser(['id' => $data['id']]);

            if ($query) {
                $menu = $this->authModel->getMenu($query->user_web_role_id);
                $old_sessionData = [
                    'logged_in_apps'        => true,
                    'id'                    => $this->session->get('id'),
                    'role'                  => $this->session->get('role'),
                    'role_code'             => $this->session->get('role_code'),
                    'role_name'             => $this->session->get('role_name'),
                    'username'              => $this->session->get('username'),
                    'name'                  => $this->session->get('name'),
                    'email'                 => $this->session->get('email'),
                    'menu'                  => $this->session->get('menu'),
                ];
                $sessionData = [
                    'logged_in_apps'        => true,
                    'id'                    => $query->id,
                    'role'                  => $query->user_web_role_id,
                    'role_code'             => $query->user_web_role_code,
                    'role_name'             => $query->user_web_role_name,
                    'username'              => $query->user_web_username,
                    'name'                  => $query->user_web_name,
                    'email'                 => $query->user_web_email,
                    'menu'                   => $this->authModel->getMenu($query->user_web_role_id)
                ];

                $session->set($sessionData);
                $session->set('old_session', $old_sessionData);

                $this->baseModel->log_action("login", "Akses Diberikan");
                $result = ["success" => TRUE, "title" => "Success", "redirect" => base_url('main')];
            } else {
                $this->baseModel->log_action("login", "Akses Ditolak");
                $result = ["success" => false, "title" => "Error", "text" => "User tidak terdaftar"];
            }

            $this->response->setHeader('Content-Type', 'application/json');
            echo json_encode($result);
        });
    }

    public function manhakakses_save()
    {
        parent::_authInsert(function () {
            $number_menu = count($this->request->getPost('idmenu'));
            $deleted = explode(",", $this->request->getPost('delete'));

            $previlagesData = [];
            for ($i = 0; $i < $number_menu; $i++) {
                $previlagesData[] = [
                    "id" => $this->request->getPost('id')[$i],
                    "menu_id" => $this->request->getPost('idmenu')[$i],
                    "v" => unwrap_null(@$this->request->getPost('v')[$i], "0"),
                    "i" => unwrap_null(@$this->request->getPost('i')[$i], "0"),
                    "d" => unwrap_null(@$this->request->getPost('d')[$i], "0"),
                    "e" => unwrap_null(@$this->request->getPost('e')[$i], "0"),
                    "o" => unwrap_null(@$this->request->getPost('o')[$i], "0"),
                    "user_web_role_id" => $this->request->getPost('iduser'),
                    "created_by" => $this->session->get('id'),
                    "created_at" => date("Y-m-d H:i:s")
                ];
            }

            if ($this->administratorModel->saveHakAkses($previlagesData, $deleted, $this->request->getPost('iduser'))) {
                echo json_encode(array('success' => true, 'message' => $previlagesData));
            } else {
                echo json_encode(array('success' => false, 'message' => $this->administratorModel->db->error()));
            }
        });
    }

    public function manprov_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.* from m_lokprov a where a.is_deleted = 0";
            $where = ["a.prov"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function manprov_save()
    {
        parent::_authInsert(function () {
            parent::_insert('m_lokprov', $this->request->getPost());
        });
    }

    public function manprov_edit()
    {
        parent::_authEdit(function () {
            parent::_edit('m_lokprov', $this->request->getPost());
        });
    }

    public function manprov_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('m_lokprov', $this->request->getPost());
        });
    }

    public function mankabkota_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.*, b.prov as namaprov from m_lokabkota a inner join m_lokprov b on a.idprov=b.id and b.is_deleted='0' where a.is_deleted = 0";
            $where = ["a.kabkota", "b.prov"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function mankabkota_save()
    {
        parent::_authInsert(function () {
            parent::_insert('m_lokabkota', $this->request->getPost());
        });
    }

    public function mankabkota_edit()
    {
        parent::_authEdit(function () {
            $data = $this->request->getPost();
            $query = "SELECT a.*, b.prov as namaprov from m_lokabkota a inner join m_lokprov b on a.idprov=b.id and b.is_deleted='0' where a.is_deleted = 0 and a.id = '" . $this->request->getPost('id') . "' ";

            parent::_edit('m_lokabkota', $data, null, $query);
        });
    }

    public function mankabkota_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('m_lokabkota', $this->request->getPost());
        });
    }

    public function mankec_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.*,b.kabkota, c.prov as namaprov FROM m_lokec a INNER JOIN m_lokabkota b on a.idkabkota=b.id and b.is_deleted='0' inner join m_lokprov c on b.idprov=c.id and c.is_deleted='0' where a.is_deleted = 0";
            $where = ["a.kec", "b.kabkota", "c.prov"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function mankec_save()
    {
        parent::_authInsert(function () {
            parent::_insert('m_lokec', $this->request->getPost());
        });
    }

    public function mankec_edit()
    {
        parent::_authEdit(function () {
            $data = $this->request->getPost();
            $query = "SELECT a.*, b.idprov ,b.kabkota as namakabkota, c.prov as namaprov FROM m_lokec a INNER JOIN m_lokabkota b on a.idkabkota=b.id and b.is_deleted='0' inner join m_lokprov c on b.idprov=c.id and c.is_deleted='0' where a.is_deleted = 0 and a.id = '" . $this->request->getPost('id') . "' ";

            parent::_edit('m_lokec', $data, null, $query);
        });
    }

    public function mankec_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('m_lokec', $this->request->getPost());
        });
    }

    public function mankel_load()
    {
        parent::_authLoad(function () {
            $query = "SELECT a.id, a.kel, b.kec as namakec  , b.idkabkota, c.kabkota as namakabkota  , c.idprov, d.prov as namaprov FROM m_lokkel a INNER JOIN m_lokec b on a.idkec=b.id and b.is_deleted='0' INNER JOIN m_lokabkota c on b.idkabkota=c.id and c.is_deleted='0' INNER JOIN m_lokprov d on c.idprov=d.id and d.is_deleted='0' WHERE a.is_deleted = 0";
            $where = ["a.kel", "b.kec", "c.kabkota", "d.prov"];

            parent::_loadDatatable($query, $where, $this->request->getPost());
        });
    }

    public function mankel_save()
    {
        parent::_authInsert(function () {
            parent::_insert('m_lokkel', $this->request->getPost());
        });
    }

    public function mankel_edit()
    {
        parent::_authEdit(function () {
            $data = $this->request->getPost();
            $query = "SELECT a.*, b.kec as nama_kec  , b.idkabkota, c.kabkota as namakabkota  , c.idprov, d.prov as namaprov FROM m_lokkel a INNER JOIN m_lokec b on a.idkec=b.id and b.is_deleted='0' INNER JOIN m_lokabkota c on b.idkabkota=c.id and c.is_deleted='0' INNER JOIN m_lokprov d on c.idprov=d.id and d.is_deleted='0' WHERE a.is_deleted = 0 and a.id = '" . $this->request->getPost('id') . "' ";

            parent::_edit('m_lokkel', $data, null, $query);
        });
    }

    public function mankel_delete()
    {
        parent::_authDelete(function () {
            parent::_delete('m_lokkel', $this->request->getPost());
        });
    }
}
