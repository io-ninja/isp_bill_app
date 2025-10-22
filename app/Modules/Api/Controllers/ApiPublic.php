<?php

namespace App\Modules\Api\Controllers;

use App\Modules\Api\Models\ApiModel;
use App\Modules\Authramp\Models\AuthrampModel;
use App\Core\BaseController;

class ApiPublic extends BaseController
{
	private $apiModel;
	var $secretKey;
	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->apiModel = new ApiModel();
		$this->secretKey = '4zTWX3HKQJF52gtDNrcu16bZVweS07yO';
	}

	private function decrypted($data)
	{
		if (strlen($this->secretKey) != 32) {
			echo json_encode("SecretKey length is not 32 chars");
		} else {
			$iv = substr($this->secretKey, 0, 16);
			$key = [$this->secretKey, $iv];
			$decrypted = openssl_decrypt($data, 'aes-256-cbc', $key[0], 0, $key[1]);
			return $decrypted;
		}
	}
    

	public function upload_file()
	{
		// Ambil semua file dari request
		$files = $this->request->getFiles();
		
		// Tentukan folder tujuan, dengan fallback ke folder default
		$folder = $this->request->getPost('folder') ?? 'tradisi/files';
	
		// Cek apakah ada file yang dikirim
		if (empty($files)) {
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Tidak ada file yang dikirim.',
				'data' => null
			])->setStatusCode(400); // Bad Request
		}
	
		$uploadedResults = [];
		$hasError = false;
	
		// Loop untuk menangani satu atau banyak file
		foreach ($files as $fieldName => $fileObjects) {
			// $fileObjects bisa berupa satu objek file atau array of objek file.
			// Kita normalisasi jadi array biar mudah di-loop.
			if (!is_array($fileObjects)) {
				$fileObjects = [$fileObjects];
			}
	
			foreach ($fileObjects as $file) {
				// Proses setiap file dengan fungsi dari BaseController
				$result = parent::_uploadFile($file, $folder);
				$uploadedResults[] = $result;
	
				// Tandai jika ada error
				if (!$result['success']) {
					$hasError = true;
				}
			}
		}
	
		// Siapkan respons final
		$response = [
			'success' => !$hasError,
			'message' => $hasError ? 'Beberapa file gagal diunggah.' : 'Semua file berhasil diunggah.',
			'data' => $uploadedResults
		];
	
		// Kirim respons JSON
		// Jika ada error, kita bisa kirim status code 400 (Bad Request) atau 207 (Multi-Status)
		$statusCode = $hasError ? 400 : 200;
		
		return $this->response->setJSON($response)->setStatusCode($statusCode);
	}

	public function remove_file()
	{
		$filename = $this->request->getPost('filename');
		$folder = $this->request->getPost('folder');
		$folder_default = 'tradisi/images';
		$folder = isset($folder) ? $folder : $folder_default;
		// Log payload untuk debug
		log_message('debug', 'Remove Payload: ' . print_r($this->request->getPost(), true));

		if (empty($filename) || empty($folder)) {
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Filename atau folder tidak ditemukan'
			]);
		}

		// Validasi filename biar aman
		if (!preg_match('/^[a-zA-Z0-9._-]+$/', $filename)) {
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Nama file tidak valid'
			]);
		}

		parent::_removeFile(
			$filename,
			$folder
		);
	}
}
