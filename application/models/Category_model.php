<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category_model extends CI_Model
{

	public function categoryCount()
	{
		$sql = "SELECT * FROM categories";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function getCategories($limit, $start, $column, $dir)
	{
		$sql = "SELECT * FROM categories ORDER BY $column $dir LIMIT ? OFFSET ?";
		$query = $this->db->query($sql, array($limit, $start));
		return $query->result_array();
	}

	public function categorySearch($search, $limit, $start, $column, $dir, )
	{
		$search = "%$search%";
		$sql = "SELECT * FROM categories
            WHERE (id LIKE ? OR name LIKE ?)
            ORDER BY $column $dir
            LIMIT ? OFFSET ?";
		$query = $this->db->query($sql, array($search, $search, $limit, $start));
		return $query->result_array();
	}

	public function updateStatus($id)
	{
		$this->db->select('is_active');
		$this->db->from('categories');
		$this->db->where('id', $id);
		$query = $this->db->get();

		if ($query->num_rows() == 0) {
			return false;
		}

		$status = $query->row()->is_active;

		$newStatus = !$status;

		$data = array(
			'is_active' => $newStatus
		);

		$this->db->where('id', $id);
		if ($this->db->update('categories', $data)) {
			return true;
		} else {
			return false;
		}
	}




}
