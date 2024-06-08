<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Media_model extends CI_Model
{
	public function create($fileName, $filePath, $fileType)
	{
		$data = array('file_name' => $fileName, 'file_path' => $filePath, 'file_type' => $fileType);
		$this->db->insert('media', $data);
		return $this->db->insert_id();

	}
}
