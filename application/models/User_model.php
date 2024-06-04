<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

	/**
	 * Authenticate a user based on email and password
	 *
	 * @param string $email
	 * @param string $password
	 * @return bool
	 */
	public function isAuthenticated($email, $password)
	{
		if (empty($email) || empty($password)) {
			log_message('error', 'Empty email or password provided for authentication.');
			return false;
		}

		$hash = $this->getPasswordHashByEmail($email);

		if (is_null($hash)) {
			log_message('error', 'Password hash not found for email: ' . $email);
			return false;
		}

		return $this->verifyPasswordHash($password, $hash);
	}

	/**
	 * Get user password hash by email
	 *
	 * @param string $email
	 * @return string|null
	 */
	private function getPasswordHashByEmail($email)
	{
		$this->db->select('password');
		$this->db->from('users');
		$this->db->where('email', $email);
		$query = $this->db->get();

		if ($query->num_rows() === 1) {
			return $query->row()->password;
		}

		return null;
	}

	public function getUserIdFromEmail($email)
	{

		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('email', $email);

		return $this->db->get()->row('id');
	}

	/**
	 * getUser function.
	 *
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function getUser($user_id)
	{

		$this->db->from('users');
		$this->db->where('id', $user_id);
		return $this->db->get()->row();
	}

	/**
	 * hashPassword function.
	 *
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	public function hashPassword($password)
	{

		return password_hash($password, PASSWORD_BCRYPT);
	}

	/**
	 * verifyPasswordHash function.
	 *
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verifyPasswordHash($password, $hash)
	{
		return password_verify($password, $hash);
	}

}
