<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('handleFileUpload')) {
	function handleFileUpload($fieldName, $uploadPath = 'uploads/', $allowedTypes = 'jpg|jpeg|png|gif', $maxSize = 2048)
	{
		$CI = &get_instance();
		$CI->load->library('upload');
		$CI->load->model('Media_model', 'media');

		$config['upload_path'] = $uploadPath;
		$config['allowed_types'] = $allowedTypes;
		$config['max_size'] = $maxSize; // 2MB

		$CI->upload->initialize($config);

		if (!$CI->upload->do_upload($fieldName)) {
			// File upload failed
			return ['success' => false, 'message' => $CI->upload->display_errors()];
		} else {
			// File upload succeeded
			$uploadData = $CI->upload->data();
			$imagePath = $uploadPath . $uploadData['file_name'];
			$mediaId = $CI->media->create($uploadData['file_name'], $imagePath, $uploadData['file_type']);

			return ['success' => true, 'media_id' => $mediaId];
		}
	}
}
