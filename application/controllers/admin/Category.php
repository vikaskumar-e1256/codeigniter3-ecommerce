<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('auth');
		$this->load->model('Category_model', 'category');
		if (!isAdminLoggedIn()) {
			redirect('admin/login');
		}
	}

	public function index()
	{
		$this->load->view('admin/template/header', ['title' => 'Category']);
		$this->load->view('admin/category/index');
		$this->load->view('admin/template/footer');
	}

	public function getCategories()
	{
		// Retrieve request parameters for DataTables
		$columns = array(
			0 => 'id',
			1 => 'name',
			2 => 'slug',
			3 => 'image',
			4 => 'is_active',
		);

		// Receiving 6 Param from Frontend dataTable
		$draw = intval($this->input->post('draw'));
		$limit = intval($this->input->post('length'));
		$start = intval($this->input->post('start'));
		$order = $columns[$this->input->post('order')[0]['column']];
		$dir = $this->input->post('order')[0]['dir'];
		$search = $this->input->post('search')['value'];

		$totalData = $this->category->categoryCount();
		$totalFiltered = $totalData;

		if (empty($search)) {
			$categories = $this->category->getCategories($limit, $start, $order, $dir);
		} else {
			$categories =  $this->category->categorySearch($search, $limit, $start, $order, $dir);

			$totalFiltered = $this->category->categorySearchCount($search);
		}

		// Prepare the data array
		$data = [];
		if (!empty($categories)) {
			foreach ($categories as $key => $row) {
				$id = $row['id'];
				if ($row['is_active']) {
					$class = "btn bg-olive margin";
					$value = "active";
				}else{
					$class = "btn bg-maroon margin";
					$value = "disabled";
				}

				$statusBtn = "<span onClick='updateCategoryStatus($id)' class='$class'>$value</span>";
				$actionBtn = "<a href='javascript:;' onClick='editCategory($id)'><i class='fa fa-edit'></i></a>";
				$data[] = [
					'id' => $row['id'],
					'name' => $row['name'],
					'slug' => $row['slug'],
					'image' => $row['image'],
					'is_active' => $statusBtn,
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

	public function updateCategoryStatus()
	{
		$id = $this->input->post('id');
		$result = $this->category->updateStatus($id);
		if ($result) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['error' => 'Failed to update category status']);
		}
	}

}
