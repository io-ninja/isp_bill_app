<?php

namespace App\Core;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class BaseModel extends Model
{
	protected $db;
	protected $db2;
	protected $session;
	protected $request;

	function __construct(RequestInterface $request = null)
	{
		$this->db 	= \Config\Database::connect();
		// $this->db2 	= \Config\Database::connect(prod);
		$this->db2 	= \Config\Database::connect();
		$this->session = \Config\Services::session();
		$this->request = $request;
	}

	// function log_action($action, $result)
	// {
	// 	helper("extension");
	// 	$builder = $this->db->table('s_log_privilege');
	// 	$post = $this->request->getVar();

	// 	foreach ($post as $key => $value) {
	// 		if (strpos($key, 'password') !== false) {
	// 			$post[$key] = md5(base64_encode($value . "abcdexxxyqt"));
	// 		}
	// 	}

	// 	$log_data = [
	// 		'log_action' => $action,
	// 		'log_url' => $_SERVER['REQUEST_URI'],
	// 		'log_param' => json_encode($post),
	// 		'log_result' => $result,
	// 		'log_ip' => get_client_ip(),
	// 		'log_user_agent' => get_client_user_agent(),
	// 		'user_web_id' => $this->session->get('id')
	// 	];

	// 	$builder->insert($log_data);
	// }
	function log_action($action, $result)
	{
		helper("extension");
		$builder = $this->db->table('s_log_privilege');
		$post = $this->request->getVar();

		// Securely hash sensitive fields, if any
		foreach ($post as $key => $value) {
			if (strpos($key, 'password') !== false) {
				// Use password_hash for better security
				$post[$key] = password_hash($value, PASSWORD_BCRYPT);
			}
		}

		// Prepare log data
		$log_data = [
			'log_action' => $action,
			'log_url' => $this->request->getURI(), // Use CodeIgniter method
			'log_param' => json_encode($post),
			'log_result' => $result,
			'log_ip' => get_client_ip(),
			'log_user_agent' => get_client_user_agent(),
			'user_web_id' => $this->session->get('id')
		];

		// Insert log data into the database
		if (!$builder->insert($log_data)) {
			// Handle potential insertion errors (optional)
			log_message('error', 'Failed to log action: ' . json_encode($log_data));
		}
	}

	function log_api($data)
	{
		$builder = $this->db->table('s_log_api');
		$builder->insert($data);
	}

	function base_get($table, $where)
	{
		$builder = $this->db->table($table);
		$builder->where($where);
		return $builder->get();
	}

	function base_insert($data, $table)
	{
		$builder = $this->db->table($table);
		return $builder->insert($data);
	}

	function base_insertbatch($data, $table)
	{
		$builder = $this->db->table($table);
		return $builder->insertBatch($data);
	}

	function string_insert($data, $table)
	{
		$builder = $this->db->table($table);
		return $builder->set($data)->getCompiledInsert();
	}

	function base_update($data, $table, $where)
	{
		$builder = $this->db->table($table);
		$builder->where($where);
		return $builder->update($data);
	}

	function base_updatebatch($data, $table, $field)
	{
		$builder = $this->db->table($table);
		return $builder->updateBatch($data, $field);
	}

	function base_upsertbatch($data, $table)
	{
		$builder = $this->db->table($table);
		return $builder->upsertBatch($data);
	}

	function base_upsert($data, $table)
	{
		$builder = $this->db->table($table);
		return $builder->upsert($data);
	}

	function base_delete($table, $where)
	{
		$builder = $this->db->table($table);
		$builder->where($where);

		$updateData['is_deleted'] = 1;
		$updateData['last_edited_at'] = date('Y-m-d H:i:s');
		$updateData['last_edited_by'] = $this->session->get('id');

		return $builder->update($updateData);
	}

	function base_load_datatable($baseQuery, $whereQuery, $whereTerm, $start, $length, $orderBy = NULL, $groupBy = NULL)
	{
		$whereClause = ($whereTerm != "" ?
			" AND (" . implode(" OR ", array_map(function ($x) use ($whereTerm) {
				return $x == "json" ? "JSON_SEARCH(" . $x . ", 'one', ?, '', '$[*]')" : $x . " LIKE ?";
			}, $whereQuery)) . ")"
			: "");
		$groupByClause = $groupBy ? " GROUP BY " . implode(", ", $groupBy) : "";
		$orderByClause = " ORDER BY " . $orderBy;

		$q = $baseQuery . $whereClause . $groupByClause . $orderByClause;
		$whereKey = array_map(function ($x) use ($whereTerm) {
			return "%" . addslashes($whereTerm) . "%";
		}, $whereQuery);

		$allData = count($this->db->query($baseQuery)->getResult());
		$filteredData = count($this->db->query($q, $whereKey)->getResult());
		$q .= $length > -1 ? " LIMIT " . $start . "," . $length : "";

		$data = $this->db->query($q, $whereKey)->getResult();
		return ["data" => $data, "allData" => $allData, "filteredData" => $filteredData];
	}

	function base_load_select2($baseQuery, $whereField, $keyword, $page, $perpage, $orderby = NULL, $groupby = NULL, $db = NULL)
	{
		$q = $whereField != "" ? $baseQuery . " AND (" . implode(" OR ", array_map(function ($x) use ($keyword) {
			return $x . " LIKE ?";
		}, $whereField)) . ")" : $baseQuery;

		$q = is_array($groupby) ? $q . " GROUP BY " . implode(",", $groupby) : $q;
		$q = is_array($orderby) ? $q . " ORDER BY " . implode(",", $orderby) : $q;

		$whereKey = array_map(function ($x) use ($keyword) {
			return "%" . addslashes($keyword) . "%";
		}, $whereField);

		switch ($db) {
			case 'db2':
				return $whereField != "" ? $this->db2->query($q, $whereKey)->getResult() : $this->db2->query($q)->getResult();
				break;
			default:
				return $whereField != "" ? $this->db->query($q, $whereKey)->getResult() : $this->db->query($q)->getResult();
				break;
		}
	}

	public function export_view($menu, $filter)
	{
		return $this->$menu($filter);
	}

	public function encrypt_decrypt($action, $string, $secret)
	{
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash('sha256', $secret);

		$iv_length = openssl_cipher_iv_length($encrypt_method);
		$iv = substr(hash('sha256', $secret), 0, $iv_length);

		if ($action == 'encrypt') {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		} elseif ($action == 'decrypt') {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}

		return $output;
	}
}
