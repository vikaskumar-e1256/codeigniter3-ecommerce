<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function index()
	{
		if ($this->session->userdata('auth')) {
			redirect('admin/dashboard/index');
		} else {
			$this->load->view('admin/auth/login');
		}
	}

	public function postLogin()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin/auth/login');
		} else {
			$this->load->model('User_model', 'user');

			$email    = $this->input->post('email');
			$password = $this->input->post('password');

			if ($this->user->isAuthenticated($email, $password)) {

				$user_id = $this->user->getUserIdFromEmail($email);
				$user    = $this->user->getUser($user_id);

				$userSession = array(
					'id' => (int)$user->id,
					'username'  => $user->username,
					'email'     => $user->email,
					'logged_in' => TRUE,
					'is_admin' => (bool)$user->is_admin
				);

				$this->session->set_userdata('auth', $userSession);
				redirect('admin/dashboard/index');
			} else {
				$this->session->set_flashdata('error', 'Credentials does not match.');
				$this->load->view('admin/auth/login');
			}
		}
	}

	public function logout()
	{
		if ($this->session->has_userdata('auth')) {
			$this->session->unset_userdata('auth');
			redirect('admin/login', 'refresh');
		} else {
			redirect('/');
		}
	}
}
