<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mains extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('main');
		// $this->output->enable_profiler();
	}

	public function index()
	{
		$this->load->library('form_validation');
		$this->load->view('index');
	}

	public function register()
	{
		$this->main->register($this->input->post());
		redirect('/');
	}

	public function login()
	{
		$this->main->login($this->input->post());
		$user = $this->main->login($this->input->post());
		if($user)
		{
			$this->session->set_userdata('userinfo', $user);
			redirect('/quotes');
		}
		else{
			$this->session->set_flashdata("login_errors", "Invalid email or password");
			redirect(base_url());
		}
		
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}

	public function quotes()
	{
		$user_info = $this->session->userdata('userinfo');
		$allquoteinfo = $this->main->fetch_all_quotes($this->session->userdata['userinfo']['id']);
		$myfavoritesinfo = $this->main->fetch_my_favorites($this->session->userdata['userinfo']['id']);
		$this->load->view('quotes', array('user' => $user_info,
										  'all_quoteinfo' => $allquoteinfo,
										  'my_favoritesinfo' => $myfavoritesinfo));
	}

	public function add_quote()
	{
		$this->main->add_quote($this->session->userdata['userinfo']['id'], $this->input->post());
		redirect('/quotes');
	}

	public function add_to_favorites($id)
	{
		$this->main->add_to_favorites($id);
		redirect('quotes');
	}

	public function remove_from_favorites($id)
	{
		$this->main->remove_from_favorites($id);
		redirect('quotes');
	}
}
?>