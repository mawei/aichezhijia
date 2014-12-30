<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class api extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->database();
		$this->load->helper('url');
	}
	
	public function index()
	{		
		$error = "";
		$this->load->view('login',$error);
	}
	
	public function getUsers()
	{
		$query = $this->db->query("select * from `user`");
		echo json_encode($query->result_array());
// 		$error = "";
// 		$username = $this->input->post("username");
// 		$password = $this->input->post("password");
// 		$query = $this->db->query("select id from `user` where `username`='{$username}' and `password`='{$password}'");
		
// 		if(count($query->result_array()) > 0)
// 		{
// 			$id = $query->result_array()[0]['id'];
// 			$session_array = array('id'=>$id);
// 			$this->session->set_userdata($session_array);
// 			redirect('main/employee');
// 		}else{
// 			$error = "用户名密码错误";
// 		}
	}
	
	public function getNews()
	{
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */