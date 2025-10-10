<?php

namespace App\Modules\Main\Controllers;

use App\Modules\Main\Models\MainModel;
use App\Core\BaseController;

class MainAction extends BaseController
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

	public function changepassword_save()
	{
		$data = $this->request->getPost();	
		$newPassword = $data['user_web_password'] ?? '';

		if (empty($newPassword) || strlen($newPassword) < 8 || !preg_match('/[A-Za-z]/', $newPassword) || !preg_match('/[0-9]/', $newPassword)) {
			return $this->response->setJSON(['success' => false, 'message' => 'Password must be at least 8 characters long and include letters and numbers.']);
		}
		if ($this->session->has('last_password_change') && (time() - $this->session->get('last_password_change')) < 60) {
			return $this->response->setJSON(['success' => false, 'message' => 'Please wait before attempting to change the password again.']);
		}


		$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

		$datapost = [
			'id' => $this->session->get('id'),
			'user_web_password' => $hashedPassword,
		];

		try {
            $this->db->transStart();
            if (!empty($datapost['user_web_password'])) {
                parent::_insert('m_user_web', $datapost);
            } else {
				return $this->response->setJSON(['success' => false, 'message' => 'No action taken: Password field is empty.']);
            }

            $this->db->transComplete();            
			if ($this->db->transStatus() === FALSE) {
                $this->db->transRollback();
                $this->db->transComplete();
            } else {
                $this->db->transCommit();
                $this->db->transComplete();
				$this->session->set('last_password_change', time());
            }
        } catch (\Exception $e) {
            $this->db->transRollback();
			return $this->response->setJSON(['success' => false, 'message' => 'An error occurred while updating the password. Password was not changed.']);
        }
	}

	function main_backLogin()
	{
		$old_session = $this->session->get('old_session');
		$sessionData = [
			'logged_in_apps'		=> true,
			'id'					=> $old_session['id'],
			'role'					=> $old_session['role'],
			'role_code'				=> $old_session['role_code'],
			'role_name'				=> $old_session['role_name'],
			'username'				=> $old_session['username'],
			'name'					=> $old_session['name'],
			'email'					=> $old_session['email'],
			'menu'					=> $old_session['menu'],
		];

		$this->session->set($sessionData);
		$this->session->remove('old_session');
		echo json_encode(['success' => true, 'redirect' => base_url()]);
	}
}
