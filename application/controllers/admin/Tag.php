<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tag extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('auth');
		$this->load->model('Tag_model', 'tag');
		if (!isAdminLoggedIn()) {
			redirect('admin/login');
		}
	}

	public function index()
	{
		$this->load->view('admin/template/header', ['title' => 'Tag']);
		$this->load->view('admin/tag/index');
		$this->load->view('admin/template/footer');
	}

	public function getTags()
	{
		// Retrieve request parameters for DataTables
		$columns = array(
			0 => 'id',
			1 => 'name',
			2 => 'slug',
		);

		// Receiving 6 Param from Frontend dataTable
		$draw = intval($this->input->post('draw'));
		$limit = intval($this->input->post('length'));
		$start = intval($this->input->post('start'));
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = $this->input->post('search')['value'];

		$totalData = $this->tag->tagCount();
		$totalFiltered = $totalData;

		if (empty($search)) {
			$tags = $this->tag->getTags($limit, $start, $order, $dir);
		} else {
			$tags =  $this->tag->tagSearch($search, $limit, $start, $order, $dir);

			$totalFiltered = count($tags);
		}

		// Prepare the data array
		$data = [];
		if (!empty($tags)) {
			foreach ($tags as $key => $row) {
				$id = $row['id'];

				$actionBtn = "<a href='javascript:;' onClick='editTag($id)'><i class='fa fa-edit'></i></a>";
				$data[] = [
					'id' => $row['id'],
					'name' => $row['name'],
					'slug' => $row['slug'],
					'action' => $actionBtn
				];
			}
		}

		// Create the result array for DataTables
		$result = array(
			"draw" => $draw,
			"recordsTotal" => $totalData,
			"recordsFiltered" => $totalFiltered,
			"data" => $data,
		);

		// Return the JSON response
		echo json_encode($result);
		exit();
	}

}
