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

	public function isTagUnique($tagName)
	{
		$sql = "SELECT * FROM tags WHERE name = ?";
		$query = $this->db->query($sql, array($tagName));
		return empty($query->result_array()); // Return true if no record is found, false otherwise
	}

	public function createTag($tagName)
	{
		$data = array('name' => $tagName, 'slug' => url_title($tagName, 'dash', true));
		return $this->db->insert('tags', $data);
	}

	public function deleteTag($tagId)
	{
		$tagId = (int)$tagId;

		$this->db->where('id', $tagId);
		$query = $this->db->get('tags');

		if ($query->num_rows() > 0) {

			$this->db->where('id', $tagId);
			if ($this->db->delete('tags')) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function deleteTags(array $ids)
	{
		if (empty($ids)) {
			return ['success' => false, 'message' => 'No IDs provided for deletion.'];
		}

		$this->db->where_in('id', $ids);
		$this->db->delete('tags');

		if ($this->db->affected_rows() > 0) {
			return ['success' => true, 'message' => 'Tags deleted successfully.'];
		} else {
			return ['success' => false, 'message' => 'Failed to delete tags or tags not found.'];
		}
	}


}
