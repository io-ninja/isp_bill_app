<?php

namespace App\Modules\Administrator\Models;

use App\Core\BaseModel;

class AdministratorModel extends BaseModel
{
	public function getModules()
	{
		return $this->db->query('SELECT a.* FROM s_module a WHERE a.is_deleted = 0')->getResult();
	}

	public function getUserRoles()
	{
		$role = $this->session->get('role') == "1" ? '' : ' AND a.id > ' . $this->session->get('role') . ' ';
		// return $this->db->query('SELECT a.* FROM s_user_web_role a WHERE a.is_deleted = 0' . $role)->getResult();
		return $this->db->query("SELECT a.id, a.user_web_role_name, a.user_web_role_code, a.user_web_role_sort FROM s_user_web_role a WHERE a.is_deleted = 0 $role ORDER BY a.user_web_role_sort")->getResult();
	}

	public function getModuleUser($role_id)
	{
		return $this->db->query('SELECT a.*, b.menu_name, b.menu_url, c.id AS module_id, c.module_name, c.module_name 
								FROM s_user_web_privilege a 
								INNER JOIN s_menu b ON a.menu_id = b.id AND b.is_deleted = 0
								INNER JOIN s_module c ON b.module_id = c.id AND c.is_deleted = 0
								WHERE a.user_web_role_id = ? AND a.is_deleted = 0 ORDER BY b.created_at
		', array($role_id))->getResult();
	}

	public function getParentMenu($module_id)
	{
		return $this->db->query('SELECT * FROM s_menu WHERE module_id = ? AND menu_id is null AND is_deleted = 0 ORDER BY created_at', array($module_id))->getResult();
	}

	public function getSubMenu($menu_id)
	{
		return $this->db->query('SELECT * FROM s_menu WHERE menu_id = ? AND is_deleted = 0 ORDER BY created_at', $menu_id)->getResult();
	}

	public function deleteByModuleAndUserType($role_id, $id)
	{
		return $this->db->query('DELETE a.* FROM s_user_web_privilege a 
								INNER JOIN s_menu b ON a.menu_id = b.id
								INNER JOIN s_module c ON b.module_id = c.id
								WHERE a.user_web_role_id = ? AND c.id = ? AND a.is_deleted = 1', array($role_id, $id));
	}

	public function deleteMenuByModuleAndUserType($role_id, $id)
	{
		return $this->db->query('UPDATE s_user_web_privilege a 
								INNER JOIN s_menu b ON a.menu_id = b.id
								INNER JOIN s_module c ON b.module_id = c.id
								SET a.is_deleted = 1, a.last_edited_at = ?, a.last_edited_by = ?
								WHERE a.user_web_role_id = ? AND c.id = ?', array(date("Y-m-d H:i:s"), $this->session->get('id'), $role_id, $id));
	}

	public function saveHakAkses($previleges, $deleted, $role_id)
	{
		$this->db->transBegin();

		foreach ($deleted AS $deleted_id) {
			$this->deleteByModuleAndUserType($role_id, $deleted_id);
			$this->deleteMenuByModuleAndUserType($role_id, $deleted_id);
		}

		foreach ($previleges AS $previlege) {

			$previlagesUpdate = [
				"v = '" . $previlege["v"] . "'",
				"i = '" . $previlege["i"] . "'",
				"d = '" . $previlege["d"] . "'",
				"e = '" . $previlege["e"] . "'",
				"o = '" . $previlege["o"] . "'",
				"last_edited_by = '" . $this->session->get('id') . "'",
				"last_edited_at = '" . date("Y-m-d H:i:s") . "'"
			];

			$query = $this->string_insert($previlege, 's_user_web_privilege') . ' ON DUPLICATE KEY UPDATE ' . implode(", ", $previlagesUpdate);
			$this->db->query($query);
		}

		if ($this->db->transStatus() === FALSE) {
			$this->db->transRollback();
			$this->db->transComplete();
			return false;
		} else {
			$this->db->transCommit();
			$this->db->transComplete();
			return true;
		}
	}

	public function getUser($id)
	{
		return $this->db->query('SELECT * FROM m_user_web WHERE is_deleted = 0 AND id = ?', array($id))->getRow();
	}

	public function checkUser($data)
	{
		$email = $data['user_web_email'];
		$username = $data['user_web_username'];

		$queryEmail = $this->db->query('SELECT * FROM m_user_web WHERE is_deleted = 0 AND user_web_email = ?', array($email))->getResult();
		$queryUsername = $this->db->query('SELECT * FROM m_user_web WHERE is_deleted = 0 AND user_web_username = ?', array($username))->getResult();

		if (count($queryEmail) > 0) {
			$result = array('success' => false, 'message' => 'Email sudah terdaftar');
		} else if (count($queryUsername) > 0) {
			$result = array('success' => false, 'message' => 'Username sudah terdaftar');
		} else {
			$result = array('success' => true);
		}

		return $result;
	}

	public function checkUserMobile($data)
	{
		$email = $data['user_web_email'];

		$queryEmail = $this->db->query('SELECT * FROM m_user_mobile WHERE is_deleted = 0 AND user_mobile_email = ?', array($email))->getResult();

		if (count($queryEmail) > 0) {
			$result = array('success' => false, 'message' => 'Email sudah terdaftar');
		} else {
			$result = array('success' => true);
		}

		return $result;
	}
}
