<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Model {

	public function register($post)
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('alias', 'Alias', 'trim|required');
		$this->form_validation->set_rules('email', 'Email Address', 'trim|valid_email|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|min_length[8]|matches[confirm_password]|required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required');	
		$this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
		
		if($this->form_validation->run() === FALSE)
		{
			$this->session->set_flashdata('errors', validation_errors());
			return false;		
		}
		else
		{
			$query = "INSERT INTO users(name, alias, email, password, created_at, updated_at)
				VALUES(?,?,?,?,NOW(), NOW())";
			$values = array($post['name'], $post['alias'], $post['email'], $post['password']);
			$this->db->query($query, $values);
			$this->session->set_flashdata('success', 'Thanks for registering!');

		}
	}

	public function login($post)
	{	
		$query = "SELECT * FROM users WHERE email =? AND password = ?";
		$values = array($post['email'], $post['password']);
		return $this->db->query($query, $values)->row_array();
	}

	public function add_quote($id, $post)
	{
		$query = "INSERT INTO quotes (creator_id, quoted_by, content, created_at, updated_at) VALUES(?,?,?,NOW(),NOW())";
		$values = array($id, $post['quoted_by'], $post['content']);
		return $this->db->query($query, $values);
	}

	public function fetch_all_quotes($id)
	{
		// $query = "SELECT quotes.id, quotes.creator_id, quotes.quoted_by, quotes.content, users.name
		// FROM quotes
		// JOIN users ON users.id = quotes.creator_id";
		// return $this->db->query($query)->result_array();

		$query = "SELECT quotes.id, quotes.creator_id, quotes.quoted_by, quotes.content, users.name
		FROM quotes
		JOIN users ON users.id = quotes.creator_id
		WHERE quotes.id
		NOT IN
		(SELECT favorites.quote_id FROM favorites WHERE favorites.user_id=?)";
		$values = array($id);
		return $this->db->query($query, $values)->result_array();
	}

	public function fetch_my_favorites($id)
	{
		$query = "SELECT users.name, quotes.created_at, quotes.quoted_by, quotes.content, quotes.id
		FROM quotes
		JOIN users ON users.id = quotes.creator_id
		JOIN favorites ON quotes.id = favorites.quote_id
		WHERE favorites.user_id = '{$id}'";
		return $this->db->query($query)->result_array();
	}

	public function add_to_favorites($id)
	{
		$query = "INSERT INTO favorites(user_id, quote_id)
				VALUES(?,?)";
				$my_id = ($this->session->userdata['userinfo']['id']);
		$values = array($my_id, $id);
		return $this->db->query($query, $values);
	}

	public function remove_from_favorites($id)
	{
		$my_id = ($this->session->userdata['userinfo']['id']);
		$query = "DELETE FROM favorites
				WHERE (user_id = ? AND quote_id = ?)";
		$values = array($my_id, $id);
		return $this->db->query($query, $values);

	}
}