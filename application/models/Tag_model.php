<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tag_model extends CI_Model
{

	public function tagCount()
	{
		$sql = "SELECT * FROM tags";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}

	public function getTags($limit, $start, $column, $dir)
	{
		$sql = "SELECT * FROM tags ORDER BY $column $dir LIMIT ? OFFSET ?";
		$query = $this->db->query($sql, array($limit, $start));
		return $query->result_array();
	}

	public function tagSearch($search, $limit, $start, $column, $dir, )
	{
		$search = "%$search%";
		$sql = "SELECT * FROM tags
            WHERE (id LIKE ? OR name LIKE ?)
            ORDER BY $column $dir
            LIMIT ? OFFSET ?";
		$query = $this->db->query($sql, array($search, $search, $limit, $start));
		return $query->result_array();
	}
}
