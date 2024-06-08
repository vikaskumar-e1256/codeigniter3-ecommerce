<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('auth');
		$this->load->model('Category_model', 'category');
		$this->load->helper('file');
		if (!isAdminLoggedIn()) {
			redirect('admin/login');
		}
	}

	public function index()
	{
		$tags = $this->category->getTags();
		$this->load->view('admin/template/header', ['title' => 'Category']);
		$this->load->view('admin/category/index', ['tags' => $tags]);
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
			// echo "<pre>";
			// print_r($categories);
			// die;
		} else {
			$categories =  $this->category->categorySearch($search, $limit, $start, $order, $dir);

			$totalFiltered = count($categories);
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
				$img = "<img src='" . $row['full_file_path'] . "' height='50px' width='50px'>";
				
				$data[] = [
					'id' => $row['id'],
					'name' => $row['name'],
					'slug' => $row['slug'],
					'image' => $img,
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

	public function store()
	{
		$this->form_validation->set_rules(
			'name',
			'Name',
			'required|min_length[3]|max_length[30]|is_unique[categories.name]',
			array(
				'required'  => '%s field is required',
				'is_unique' => 'This %s already exists.'
			)
		);
		$this->form_validation->set_rules('status', 'Status', 'required');

		if ($this->form_validation->run() == FALSE) {
			// Validation failed
			echo json_encode(['success' => false, 'message' => validation_errors()]);
			return;
		}

		// Start transaction
		$this->db->trans_start();

		// Handle file upload if image is provided
		$mediaId = NULL;
		if (!empty($_FILES['image']['name'])) {
			$uploadResult = handleFileUpload('image');
			if ($uploadResult['success'] == false) {
				// File upload failed
				echo json_encode(['success' => false, 'message' => $uploadResult['message']]);
				return;
			}
			$mediaId = $uploadResult['media_id'];
		}

		// Prepare data for insertion
		$data = [
			'name' => $this->input->post('name'),
			'description' => $this->input->post('description') ?? NULL,
			'slug' => url_title($this->input->post('name'), '-', false),
			'media_id' => $mediaId,
			'is_active' => $this->input->post('status'),
			'meta_title' => $this->input->post('meta_title'),
			'meta_description' => $this->input->post('meta_description'),
			'meta_keywords' => $this->input->post('meta_keywords'),
		];

		// Insert category data
		$categoryId = $this->category->insertCategory($data);

		// Link tags if provided
		if (!empty($this->input->post('tags'))) {
			$tags = $this->input->post('tags');
			$this->category->linkTags($categoryId, $tags);
		}

		// Complete the transaction
		$this->db->trans_complete();

		// Check if the transaction was successful
		if ($this->db->trans_status() === FALSE) {
			echo json_encode(['success' => false, 'message' => 'An error occurred while creating the category.']);
		} else {
			echo json_encode(['success' => true, 'message' => 'Category created successfully.']);
		}
	}

}
