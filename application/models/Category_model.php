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
		// Mapping of frontend column names to database column names and tables
		$columnMappings = [
			'id' => 'categories.id',
			'name' => 'categories.name',
			'media_id' => 'categories.media_id',
			'is_active' => 'categories.is_active',
		];

		// Default column and table
		$orderByColumn = 'categories.id';

		// Check if the provided column is valid and map it to the database column name
		if (array_key_exists($column, $columnMappings)) {
			$orderByColumn = $columnMappings[$column];
		}

		// Prepare the SQL query
		$sql = "SELECT categories.*,
				CASE
					WHEN media.file_path IS NOT NULL
					THEN CONCAT('" . base_url() . "', media.file_path)
					ELSE ''
				END AS full_file_path
				FROM categories
				LEFT JOIN media ON categories.media_id = media.id
				ORDER BY $orderByColumn $dir LIMIT ? OFFSET ?";

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

	public function getTags()
	{
		$sql = "SELECT id, name FROM tags";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function insertCategory($data)
	{
		$this->db->insert('categories', $data);
		return $this->db->insert_id();

	}

	public function linkTags($categoryId, $tags)
	{
		$data = array();
		foreach ($tags as $tag) {
			$data[] = array(
				'category_id' => $categoryId,
				'tag_id' => $tag
			);
		}

		if (!empty($data)) {
			$this->db->insert_batch('category_tags', $data);
		}
	}


}
