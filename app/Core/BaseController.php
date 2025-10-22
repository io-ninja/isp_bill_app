<?php

namespace App\Core;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use App\Core\BaseModel;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['extension', 'apires'];
	protected $session;
	protected $baseModel;
	protected $db;
	protected $db2;
	protected $token;

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
		$this->baseModel = new BaseModel(\Config\Services::request());
		$this->session = \Config\Services::session();
		$this->db = \Config\Database::connect();
		// $this->db2 = \Config\Database::connect('prod');
	}

	protected function logActivityCron($cronName, $status, $message, $data = [])
	{
		$data = [
			'cron_name' => $cronName,
			'status' => $status,
			'message' => $message,
			'api_response' => json_encode($data),
			'triggered_at' => date('Y-m-d H:i:s')
		];

		try {
			$this->db->table('s_log_cron')->insert($data);
			return true;
		} catch (\Exception $e) {
			log_message('error', 'Log insertion failed: ' . $e->getMessage());
			return false;
		}
	}

	protected function _authView($data = array())
	{
		$url = uri_segment(1);
		$module = uri_segment(0);
		$menu = $this->session->get('menu');

		$authentication = array_filter($menu, function ($arr) use ($url, $module) {
			return strtolower($arr->menu_url) == strtolower($url) && strtolower($arr->module_url) == strtolower($module);
		});

		if (count($authentication) == 1) {
			$authItem = array_values($authentication)[0];

			if ($authItem->v != "1") {
				$data['load_view'] = 'App\Modules\Main\Views\error';
				return view('App\Modules\Main\Views\layout', $data);
			} else {
				$data['page_title'] = $authItem->menu_name;

				// Bangun path dengan subfolder
				$module_url = ucfirst($authItem->module_url);
				$data['load_view'] = "App\Modules\\$module_url\Views\\" . $authItem->menu_url;

				$data['rules'] = $authItem;
				return view('App\Modules\Main\Views\layout', $data);
			}
		} else {
			$data['load_view'] = 'App\Modules\Main\Views\error';
			return view('App\Modules\Main\Views\layout', $data);
		}
	}

	protected function _authViewPage($data = array())
	{
		$url = uri_segment(1);
		$module = uri_segment(0);
		$menu = $this->session->get('menu');

		$authentication = array_filter($menu, function ($arr) use ($url, $module) {
			return strtolower($arr->menu_url) == strtolower($url) && strtolower($arr->module_url) == strtolower($module);
		});

		// echo json_encode($authentication);

		if (count($authentication) == 1) {
			if (array_values($authentication)[0]->v != "1") {
				// $this->baseModel->log_action("view", "Akses Ditolak");

				$data['load_view'] = 'App\Modules\Main\Views\error';
				return view('App\Modules\Main\Views\layoutpage', $data);
			} else {
				// if (array_values($authentication)[0]->user_web_role_id == "10") {
				if (in_array(array_values($authentication)[0]->user_web_role_id, [8, 9, 10, 11])) {
					// $this->baseModel->log_action("view", "Akses Diberikan");
					$data['page_title'] = array_values($authentication)[0]->menu_name;
					$data['load_view'] = 'App\Modules\\' . ucfirst(array_values($authentication)[0]->module_url) . '\Views\\' . array_values($authentication)[0]->menu_url;
					$data['rules'] = array_values($authentication)[0];
					return view('App\Modules\Main\Views\layoutpage_ppa', $data);
				} else {
					// $this->baseModel->log_action("view", "Akses Diberikan");
					$data['page_title'] = array_values($authentication)[0]->menu_name;
					$data['load_view'] = 'App\Modules\\' . ucfirst(array_values($authentication)[0]->module_url) . '\Views\\' . array_values($authentication)[0]->menu_url;
					$data['rules'] = array_values($authentication)[0];
					return view('App\Modules\Main\Views\layoutpage', $data);
				}
			}
		} else {
			// $this->baseModel->log_action("view", "Akses Ditolak");

			$data['load_view'] = 'App\Modules\Main\Views\error';
			return view('App\Modules\Main\Views\layoutpage', $data);
		}
	}

	protected function _authViewmodal($data = array())
	{
		$url = uri_segment(1);
		$module = uri_segment(0);
		$menu = $this->session->get('menu');

		$authentication = array_filter($menu, function ($arr) use ($url, $module) {
			return strtolower($arr->menu_url) == strtolower($url) && strtolower($arr->module_url) == strtolower($module);
		});

		if (count($authentication) == 1) {
			if (array_values($authentication)[0]->v != "1") {
				// $this->baseModel->log_action("view", "Akses Ditolak");

				$data['load_view'] = 'App\Modules\Main\Views\error';
				return view('App\Modules\Main\Views\layoutmodal', $data);
			} else {
				// $this->baseModel->log_action("view", "Akses Diberikan");

				$data['page_title'] = array_values($authentication)[0]->menu_name;
				$data['load_view'] = 'App\Modules\\' . ucfirst(array_values($authentication)[0]->module_url) . '\Views\\' . array_values($authentication)[0]->menu_url;
				$data['rules'] = array_values($authentication)[0];
				return view('App\Modules\Main\Views\layoutmodal', $data);
			}
		} else {
			// $this->baseModel->log_action("view", "Akses Ditolak");

			$data['load_view'] = 'App\Modules\Main\Views\error';
			return view('App\Modules\Main\Views\layoutmodal', $data);
		}
	}

	protected function _auth($action, $var_action, callable $authenticated)
	{
		$referers = explode("/", $_SERVER['HTTP_CUSTOMREF'] ?? $_SERVER['HTTP_REFERER']);
		$referer = end($referers);
		$module = $referers[count($referers) - 2];
		$menu = $this->session->get('menu');

		$authentication = array_filter($menu, function ($arr) use ($referer, $module) {
			return strtolower($arr->menu_url) == strtolower($referer) && strtolower($arr->module_url) == strtolower($module);
		});

		if (count($authentication) == 1 && $referer != "" && array_values($authentication)[0]->$var_action == "1") {
			$this->baseModel->log_action($action, "Akses Diberikan");

			if ($action == "detail") {
				return $authenticated();
			} else {
				$authenticated();
			}
		} else {
			$this->baseModel->log_action($action, "Akses Ditolak");

			if ($action == "load") {
				die(json_encode(array("data" => [], "recordsTotal" => 0, "recordsFiltered" => 0)));
			} else if ($action == "detail") {
				die(view('App\Modules\Main\Views\error'));
			} else {
				die(json_encode(array('success' => false, 'message' => 'Anda tidak mempunyai hak akses untuk ini', 'debug' => array_values($authentication)[0])));
			}
		}
	}

	protected function _authInsert(callable $authenticated)
	{
		$this->_auth("insert", "i", $authenticated);
	}

	protected function _authEdit(callable $authenticated)
	{
		$this->_auth("edit", "e", $authenticated);
	}

	protected function _authDelete(callable $authenticated)
	{
		$this->_auth("delete", "d", $authenticated);
	}

	protected function _authVerif(callable $authenticated)
	{
		$this->_auth("verif", "o", $authenticated);
	}

	protected function _authLoad(callable $authenticated)
	{
		$this->_auth("load", "v", $authenticated);
	}

	protected function _authUpload(callable $authenticated)
	{
		$this->_auth("upload", "i", $authenticated);
	}

	protected function _authDownload(callable $authenticated)
	{
		$this->_auth("download", "v", $authenticated);
	}

	protected function _authDetail(callable $authenticated)
	{
		return $this->_auth("detail", "v", $authenticated);
	}

	protected function _loadDatatable($query, $where, $data, $groupby = NULL, $orderby = NULL)
	{
		$start = $this->request->getPost("start");
		$length = $this->request->getPost("length");
		$search = $this->request->getPost("search");
		$order = $this->request->getPost("order");
		$columns = $this->request->getPost("columns");
		$key = $search["value"];

		if ($orderby && !isset($order)) {
			$orderBy = implode(", ", $orderby);
		} else {
			$orderByItems = array_map(function ($orderItem) use ($columns) {
				$colIndex = $orderItem["column"];
				$colDir = $orderItem["dir"];
				$colName = $columns[$colIndex]["data"];
				return $colName . " " . strtoupper($colDir);
			}, $order);
			$orderBy = implode(", ", $orderByItems);
		}

		$result = $this->baseModel->base_load_datatable($query, $where, $key, $start, $length, $orderBy, $groupby);
		$prequery = $this->baseModel->encrypt_decrypt('encrypt', base64_encode($this->db->getLastQuery()), getenv('jwt.secretkey'));
		// log_message('debug', 'Query: ' . $this->baseModel->encrypt_decrypt('decrypt', $prequery, getenv('jwt.secretkey')));

		$ret = ["data" => $result["data"], "recordsTotal" => $result["allData"], "recordsFiltered" => $result["filteredData"], "query" => $prequery];
		$this->response->setHeader('Content-Type', 'application/json');

		if (getenv('CI_ENVIRONMENT') != 'development') {
			unset($ret['query']);
		}
		echo json_encode($ret);
	}

	protected function _insert($tableName, $data, callable $callback = NULL)
	{

		if ($data['id'] == "") {
			$data['created_by'] = $this->session->get('id');

			if ($this->baseModel->base_insert($data, $tableName)) {
				if ($callback != NULL) {
					$data['id'] = $this->db->insertID();
					$callback($data);
				}
				$this->response->setHeader('Content-Type', 'application/json');
				echo json_encode(array('success' => true, 'message' => $data));
			} else {
				$err = $this->baseModel->db->error();
				if ($err['code'] == '1062') {
					$this->response->setHeader('Content-Type', 'application/json');
					echo json_encode(array('success' => false, 'message' => 'Data sudah ada'));
				} else {
					$this->response->setHeader('Content-Type', 'application/json');
					echo json_encode(array('success' => false, 'message' => $err['message']));
				}
			}
		} else {
			$id = $data['id'];
			$data['last_edited_at'] = date('Y-m-d H:i:s');
			$data['last_edited_by'] = $this->session->get('id');
			unset($data['id']);

			if ($this->baseModel->base_update($data, $tableName, array('id' => $id))) {
				if ($callback != NULL) {
					$data['id'] = $id;
					$callback($data);
				}

				$this->response->setHeader('Content-Type', 'application/json');
				echo json_encode(array('success' => true, 'message' => $data));
			} else {
				$this->response->setHeader('Content-Type', 'application/json');
				echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
			}
		}
	}

	protected function _insertbatch($tableName, $data, callable $callback = NULL)
	{
		if ($this->baseModel->base_insertbatch($data, $tableName)) {
			if ($callback != NULL) {
				$callback();
			}

			echo json_encode(array('success' => true, 'message' => 'data berhasil terinput'));
		} else {
			echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
		}
	}

	protected function _edit($tableName, $data, $keys = NULL, $query = NULL)
	{
		$key = $keys == NULL ? 'id' : $keys;
		$rs = $query == NULL ? $this->baseModel->base_get($tableName, [$key => $data[$key]])->getRow() : $this->baseModel->db->query($query)->getRow();
		$this->response->setHeader('Content-Type', 'application/json');

		if (!is_null($rs)) {
			echo json_encode(array('success' => true, 'data' => $rs));
		} else {
			echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()['message']));
		}
	}

	protected function _otorisasi($tableName, $data, callable $callback = NULL)
	{
		$id = $data['id'];
		$data['last_edited_at'] = date('Y-m-d H:i:s');
		$data['last_edited_by'] = $this->session->get('id');
		unset($data['id']);
		$this->response->setHeader('Content-Type', 'application/json');

		if ($this->baseModel->base_update($data, $tableName, array('id' => $id))) {
			if ($callback != NULL) {
				$callback();
			}

			echo json_encode(array('success' => true, 'message' => $data));
		} else {
			echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
		}
	}

	protected function _editbatch($tableName, $data, $keys = NULL, $query = NULL)
	{
		$key = $keys == NULL ? 'id' : $keys;
		$rs = $query == NULL ? $this->baseModel->base_get($tableName, [$key => $data[$key]])->getResult() : $this->baseModel->db->query($query)->getResult();

		if (!is_null($rs)) {
			echo json_encode(array('success' => true, 'data' => $rs));
		} else {
			echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()['message']));
		}
	}

	protected function _mobile_insert($tableName, $data, callable $callback = NULL)
	{
		if ($data['id'] == "") {
			$data['created_by'] = $data['user_id'];
			unset($data['user_id']);
			if ($this->baseModel->base_insert($data, $tableName)) {
				if ($callback != NULL) {
					$callback();
				}

				echo json_encode(array('success' => true, 'message' => 'success'));
			} else {
				echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
			}
		} else {
			$id = $data['id'];
			$data['last_edited_at'] = date('Y-m-d H:i:s');
			$data['last_edited_by'] = $data['user_id'];
			unset($data['id']);
			unset($data['user_id']);

			if ($this->baseModel->base_update($data, $tableName, array('id' => $id))) {
				if ($callback != NULL) {
					$callback();
				}

				echo json_encode(array('success' => true, 'message' => $data));
			} else {
				echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
			}
		}
	}

	protected function _delete($tableName, $data)
	{
		$this->response->setHeader('Content-Type', 'application/json');
		if ($this->baseModel->base_delete($tableName, $data)) {
			echo json_encode(array('success' => true));
			log_message('info', 'Data berhasil dihapus');
		} else {
			echo json_encode(array('success' => false, 'message' => $this->baseModel->db->error()));
			log_message('error', 'Data gagal dihapus: ' . $this->baseModel->db->error());
		}
	}

	protected function _loadSelect2($data, $query, $where, $orderBy = NULL, $groupBy = NULL, $db = NULL)
	{
		$keyword = $data['keyword'] ?? "";
		$page = $data['page'];
		$perpage = $data['perpage'];
		try {
			$result = $this->baseModel->base_load_select2($query, $where, $keyword, $page, $perpage, $orderBy, $groupBy, $db);
			$this->response->setHeader('Content-Type', 'application/json');
			echo json_encode(array("success" => true, "page" => $page, "perpage" => $perpage, "total" => count($result), "rows" => $result));
		} catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
			if (strpos($e->getMessage(), 'Too many connections') !== false) {
				log_message('error', 'Database connection failed in _loadSelect2: ' . $e->getMessage());
				echo json_encode(array("success" => false, "error" => "Database is busy, please try again later."));
			} else {
				log_message('error', 'Database error in _loadSelect2: ' . $e->getMessage());
				echo json_encode(array("success" => false, "error" => "An unexpected error occurred."));
			}
		} catch (\Exception $e) {
			log_message('error', 'General error in _loadSelect2: ' . $e->getMessage());
			echo json_encode(array("success" => false, "error" => "An unexpected error occurred."));
		}
	}

	protected function _loadSelect2GroupBy($data, $query, $where, $orderBy = NULL, $groupBy = NULL)
	{
		$keyword = $data['keyword'] ?? "";
		$page = $data['page'];
		$perpage = $data['perpage'];

		$result = $this->baseModel->base_load_select2($query, $where, $keyword, $page, $perpage, $orderBy, $groupBy);

		echo json_encode(array("page" => $page, "perpage" => $perpage, "total" => count($result), "rows" => $result));
	}

	protected function _exportRCPdf($data)
	{
		$view = uri_segment(2);
		$module = uri_segment(0);

		$ngilogo = base_url("assets/img/watermark-ngi.PNG");
		$tsmglogo = base_url("assets/images/icon-smg.webp");
		$html = view('App\Modules\\' . ucfirst($module) . '\Views\\' . $view, $data);

		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => [210, 297],
			'tempDir' => ROOTPATH . 'writable/cache',
			'default_font_size' => 11,
			'default_font' => 'Manrope'
		]);

		$html_footer = '
		<table class="border-0" style="font-size: 10px;">
			<tr class="border-0">
				<td class="border-0" rowspan="4" style="width:18%; padding:0px !important;  margin:0px !important;"><img src="' . $ngilogo . '" width="30px"></td>
			</tr class="border-0">
			<tr class="border-0">
				<td class="border-0" style="padding:0px !important; margin:0px !important;"><i>IP Address : ' . $_SERVER["REMOTE_ADDR"] . '</i></td>
			</tr class="border-0">
			<tr class="border-0">
				<td class="border-0" style="padding:0px !important; margin:0px !important;"><i>Tanggal Cetak : ' . date("d-m-Y H:i:s") . '</i></td>
			</tr class="border-0">
			<tr class="border-0">
				<td class="border-0" style="padding:0px !important; margin:0px !important;"><i>Dicetak Oleh : ' . $_SESSION["name"] . '</i></td>
			</tr class="border-0">
		</table>
		';

		$mpdf->SetHTMLFooter($html_footer);

		$pagecount = $mpdf->SetSourceFile('./assets/PDFTemplate-TSRampCheck.pdf', 0);

		$tplId = $mpdf->importPage($pagecount);
		$mpdf->SetPageTemplate($tplId);

		$mpdf->AddPage(
			'P',
			'',
			'',
			'',
			'',
			7, // margin_left
			7, // margin right
			43, // margin top
			30, // margin bottom
			25, // margin header
			10
		); // margin footer

		$mpdf->useTemplate($tplId, 0, 0, 210, 297);
		$mpdf->WriteHTML($html);

		$filename = $data['filename'];
		$this->response->setHeader('Cache-Control', 'private');
		$this->response->setHeader('Content-Type', 'application/pdf');

		ob_clean();
		$rs = $mpdf->Output($filename, 'I'); // INLINE 
		echo $rs;
		// die;
	}

	protected function _exportRCPdf_dl($data)
	{
		$view = uri_segment(2);
		$module = uri_segment(0);

		$ngilogo = base_url("assets/img/watermark-ngi.PNG");
		$tsmglogo = base_url("assets/images/icon-smg.webp");
		$html = view('App\Modules\\' . ucfirst($module) . '\Views\\' . $view, $data);

		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => [210, 297],
			'tempDir' => ROOTPATH . 'writable/cache',
			'default_font_size' => 11,
			'default_font' => 'Manrope'
		]);

		$html_footer = '
		<table class="border-0" style="font-size: 10px;">
			<tr class="border-0">
				<td class="border-0" rowspan="4" style="width:18%; padding:0px !important;  margin:0px !important;"><img src="' . $ngilogo . '" width="30px"></td>
			</tr class="border-0">
			<tr class="border-0">
				<td class="border-0" style="padding:0px !important; margin:0px !important;"><i>IP Address : ' . $_SERVER["REMOTE_ADDR"] . '</i></td>
			</tr class="border-0">
			<tr class="border-0">
				<td class="border-0" style="padding:0px !important; margin:0px !important;"><i>Tanggal Cetak : ' . date("d-m-Y H:i:s") . '</i></td>
			</tr class="border-0">
			<tr class="border-0">
				<td class="border-0" style="padding:0px !important; margin:0px !important;"><i>Dicetak Oleh : ' . $_SESSION["name"] . '</i></td>
			</tr class="border-0">
		</table>
		';

		$mpdf->SetHTMLFooter($html_footer);

		$pagecount = $mpdf->SetSourceFile('./assets/PDFTemplate-TSRampCheck.pdf', 0);

		$tplId = $mpdf->importPage($pagecount);
		$mpdf->SetPageTemplate($tplId);

		$mpdf->AddPage(
			'P',
			'',
			'',
			'',
			'',
			7, // margin_left
			7, // margin right
			43, // margin top
			30, // margin bottom
			25, // margin header
			10
		); // margin footer

		$mpdf->useTemplate($tplId, 0, 0, 210, 297);
		$mpdf->WriteHTML($html);

		$filename = $data['filename'];
		$file_path = '/home/ngi/php/php74/trans_smg/public/rampcheck/pdf/' . $filename;

		// Save the PDF to the specified path
		$mpdf->Output($file_path, 'F');
		// die;
		// Optionally, you can send a response or redirect
		// return $file_path;
	}

	protected function _exportPdf($data, $orientation = 'P')
	{
		$view = uri_segment(2);
		$module = uri_segment(0);
		$mpdf = new \Mpdf\Mpdf([
			'mode' => 'utf-8',
			'format' => [210, 297],
			'tempDir' => ROOTPATH . 'writable/cache',
			'default_font_size' => 11,
			'default_font' => 'Manrope'
		]);
		$html = view('App\Modules\\' . ucfirst($module) . '\Views\export\\' . $view, $data);

		// $pagecount = $mpdf->SetSourceFile('./assets/PDFTemplate-TSRampCheck.pdf', 2);
		// $tplId = $mpdf->importPage($pagecount);
		// $mpdf->SetPageTemplate($tplId);

		$mpdf->AddPage(
			$orientation,
			'',
			'',
			'',
			'',
			16,
			16,
			5,
			20,
			90,
			10
		); // margin footer

		// $mpdf->useTemplate($tplId, 0, 0, 210, 297);

		$html_header = '';
		$mpdf->setAutoTopMargin = 'stretch';
		$mpdf->setHTMLHeader($html_header);
		$mpdf->WriteHTML($html);

		$filename = $view . '-' . date('d-m-Y') . '.pdf';
		$this->response->setHeader('Cache-Control', 'private');
		$this->response->setHeader('Content-Type', 'application/pdf');
		$this->response->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"');

		ob_clean();
		$mpdf->Output($filename, 'I'); // INLINE 
		// echo $rs;
		exit;
	}

	protected function _sendNotification($fcm, $title, $body, $data = null)
	{
		$json_data = [
			"to" => $fcm,
			"notification" => [
				"title" => $title,
				"body" => $body,
				"icon" => "ic_launcher"
			],
			"data" => $data
		];

		$data = json_encode($json_data);
		//FCM API end-point
		$url = 'https://fcm.googleapis.com/fcm/send';
		//api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
		$server_key = '';
		//header with content_type api key
		$headers = array(
			'Content-Type:application/json',
			'Authorization:key=' . $server_key
		);

		//CURL request to route notification to FCM connection server (provided by Google)
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = curl_exec($ch);

		if ($result === FALSE) {
			die('Oops! FCM Send Error: ' . curl_error($ch));
		}

		curl_close($ch);

		return $result;
	}

	/**
	 * Memproses upload satu file.
	 * Fungsi ini mengembalikan array hasil, bukan mencetak JSON.
	 *
	 * @param \CodeIgniter\Files\File $file Objek file dari CodeIgniter
	 * @param string $folder Folder tujuan di dalam 'uploads'
	 * @return array Array berisi status sukses/error dan data file
	 */
	public function _uploadFile(\CodeIgniter\Files\File $file, string $folder)
	{
		// 1. Validasi File
		if (!$file->isValid()) {
			return ['success' => false, 'error' => $file->getErrorString() . '(' . $file->getError() . ')'];
		}
	
		$allowedTypes = [
			'application/pdf',
			'image/png',
			'image/jpeg',
			'image/jpg',
			'image/webp' // Gue tambahin webp biar kekinian
		];
		$maxSize = 15 * 1024 * 1024; // 15MB
	
		if (!in_array($file->getClientMimeType(), $allowedTypes)) {
			return ['success' => false, 'error' => 'Tipe file tidak diizinkan. Hanya PDF, PNG, JPG, JPEG, dan WEBP.'];
		}
	
		if ($file->getSize() > $maxSize) {
			return ['success' => false, 'error' => 'Ukuran file melebihi batas maksimal 15MB.'];
		}
	
		// 2. Siapkan Path dan Nama File Baru
		$uploadPath = PUBLICPATH . 'uploads/' . $folder;
		// $uploadPath = WRITEPATH . 'uploads/' . $folder;
	
		// Buat folder jika belum ada
		if (!is_dir($uploadPath)) {
			if (!mkdir($uploadPath, 0755, true)) {
				return ['success' => false, 'error' => 'Gagal membuat folder tujuan.'];
			}
		}
	
		// 3. Pindahkan File
		$newName = $file->getRandomName();
		
		if ($file->move($uploadPath, $newName)) {
			// Sukses! Kembalikan data file.
			// Path yang disimpan sebaiknya relatif dari `uploads` atau URL-nya.
			$fileUrl = base_url('public/uploads/' . $folder . '/' . $newName);
			return [
				'success' => true,
				'filename' => $newName,
				'path' => $folder . '/' . $newName, // path relatif
				'full_path' => $uploadPath . '/' . $newName, // path server
				'url' => $fileUrl,
				'size' => $file->getSize()
			];
		} else {
			// Gagal memindahkan file
			return ['success' => false, 'error' => 'Gagal mengunggah file ke server.'];
		}
	}

	public function _removeFile($filename, $folder)
	{
		$filename = $this->request->getPost('filename');
		$folder = $this->request->getPost('folder');

		$filePath = PUBLICPATH . 'uploads/' . $folder . '/' . $filename;

		$return = [];
		if (file_exists($filePath)) {
			unlink($filePath);
			$return = ['success' => true];
		} else {
			$return = ['success' => false, 'error' => 'File tidak ditemukan'];
		}

		$this->response->setHeader('Content-Type', 'application/json');
		echo json_encode($return);
	}
}
