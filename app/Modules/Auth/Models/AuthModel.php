<?php

namespace App\Modules\Auth\Models;

use App\Core\BaseModel;

class AuthModel extends BaseModel
{
    function __construct()
    {
        parent::__construct();
    }

    public function getUser($params = [])
    {
        $query = "SELECT a.*, b.user_web_role_name, b.user_web_role_code
                    FROM m_user_web a
                    LEFT JOIN s_user_web_role b ON a.user_web_role_id = b.id AND b.is_deleted = 0
                    WHERE a.is_deleted = 0";

        $bindings = [];

        if (!empty($params['username'])) {
            $query .= " AND a.user_web_username = ? ";
            $bindings[] = $params['username'];
        }

        if (!empty($params['password'])) {
            $query .= " AND a.user_web_password = md5(?) ";
            $bindings[] = $params['password'];
        }

        if (!empty($params['email'])) {
            $query .= " AND a.user_web_email = ? ";
            $bindings[] = $params['user_web_email'];
        }

        if (!empty($params['id'])) {
            $query .= " AND a.id = ? ";
            $bindings[] = $params['id'];
        }

        return $this->db->query($query, $bindings)->getRow();
    }

    public function getMenu($userRoleId)
    {
        return $this->db->query('SELECT a.*,
                                        b.menu_url, b.menu_name,
                                        c.module_url, c.module_name, IFNULL(c.module_order, 0) AS module_order,
                                        d.menu_name AS menu_parent 
                                   FROM s_user_web_privilege a
                             INNER JOIN s_menu b ON a.menu_id = b.id AND b.is_deleted = 0
                             INNER JOIN s_module c ON b.module_id = c.id AND c.is_deleted = 0
                              LEFT JOIN s_menu d ON b.menu_id = d.id AND d.is_deleted = 0
                                  WHERE a.is_deleted = 0 AND a.v = 1 AND a.user_web_role_id = ?
                               ORDER BY c.module_order ASC, b.created_at ;', array($userRoleId))->getResult();
    }
}
