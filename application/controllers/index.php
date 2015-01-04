<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class index extends CI_Controller {

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
		$this->load->library('parser');
		$this->appid = "wx13facdc7a21c75b6";
		$this->secret = "8ceb383fc897603a7edeab04c5311d37";
		
		$head = $this->load->view("include/head","",true);
		$header = $this->load->view("include/header","",true);
		$footer = $this->load->view("include/footer","",true);
		$this->data['head'] = $head;
		$this->data['header'] = $header;
		$this->data['footer'] = $footer;
	}
	
	private function is_weixin()
	{
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) 
		{         
			return true;   
		}       
		return false;
	}
	
	public function index()
	{
		if(isset($_GET['type']))
		{
			if($_GET['type'] == "")
			{
				$type = "profile";
			}else{
				$type = $_GET['type'];
			}
		}else{
			$type = "profile";
		}
		$this->data['type'] = $type;
		
		//echo  urlencode(site_url("index/login"));die();
		$this->data["error"] = "";
		//已登录
		if($this->session->userdata('userid') > 0)
		{
			$query = $this->db->query("select * from `user` where id={$this->session->userdata('userid')}");
			$this->data['wheel'] = $query->result_array()[0]['wheel'];
			$this->parser->parse('index',$this->data);
		}else{
			//微信
			if(self::is_weixin())
			{
				$redirect_uri = urlencode(site_url("index/login?weixin=1"));
				redirect("https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->appid}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect");
			}else{
				//print_r($this->data);die();
				$this->parser->parse('login',$this->data);
			}
		}
	}
	
	public function login()
	{
		//微信登陆
		if($_REQUEST['code'] != "")
		{
			$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->appid}&secret={$this->secret}&code={$_REQUEST['code']}&grant_type=authorization_code";
		
			$ch = curl_init($url) ;
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
			$output = json_decode(curl_exec($ch)) ;
			if($output->openid != "")
			{
				$query = $this->db->query("select * from `user` where weixinID='{$output->openid}'");
				if(count($query->result_array())>0)
				{
					$this->session->set_userdata('userid', $query->result_array()[0]['id']);
					redirect("index");
				}else{
					$this->data['error'] = "";
					$this->data['weixinID'] = $output->openid;
				}
			}
		}
		$this->data['error'] = "";
		$this->parser->parse('login',$this->data);
	}
	
	public function  loginout()
	{
		$this->session->set_userdata("userid",0);
		$this->data['error'] = "";
		$this->parser->parse('login',$this->data);
	}
	
	public function needLogin()
	{
		if($this->session->userdata('userid') <= 0)
		{
			$error = "请先登陆";
			$this->data['error'] = $error;
			$this->parser->parse('login',$this->data);
		}
		return;
	}
	
	public function loginpost()
	{
		$username = addslashes($_POST['username']);
		$password = addslashes($_POST['password']);
		$weixinID = addslashes($_POST['weixinID']);
		$query = $this->db->query("select * from `user` where username='{$username}' and password='{$password}'");
		if(count($query->result_array())>0)
		{
			$this->session->set_userdata('userid', $query->result_array()[0]['id']);
			if($weixinID != "")
			{
				$this->db->query("update `user` set weixinID='{$weixinID}' where id = {$query->result_array()[0]['id']}");
			}
			if($query->result_array()[0]['type'] == 'admin')
			{
				redirect(site_url("admin/user"));
			}else{
				redirect("index");
			}
		}else{
			$error = "请输入正确的用户名及密码";
			$this->data['error'] = $error;
			$this->parser->parse('login',$this->data);
		}
	}
	
	public function register()
	{
		$this->data['error'] = "";
		$this->parser->parse('register',$this->data);
	}
	
	public function registerpost()
	{
		$username = addslashes($_POST['username']);
		$password = addslashes($_POST['password']);
		$password2 = addslashes($_POST['password2']);
		$phone = addslashes($_POST['phone']);
		$carmodel = addslashes($_POST['carmodel']);
		
		if($username == "" || $password==""||$password2==""||$phone==""||$carmodel=="")
		{
			$error = "请输入完整";
			$this->data['error'] = $error;
			$this->parser->parse('register',$this->data);
		}
		elseif($password != $password2)
		{
			$error = "密码不一致";
			$this->data['error'] = $error;
			$this->parser->parse('register',$this->data);
		}
		else{
			$query = $this->db->query("select * from `user` where username='{$username}'");
			if(count($query->result_array())>0)
			{
				$error = "用户名已存在";
				$this->data['error'] = $error;
				$this->parser->parse('register',$this->data);
			}else {
				$query = $this->db->query("insert into `user` (username,password,phone,carmodel) values ('{$username}','{$password}','{$phone}','{$carmodel}')");
				redirect('index/login');
			}
		}
	}
	
	public function weihulist()
	{
		$this->needLogin();
		$records = $this->db->query("select * from maintenance_record where userid={$this->session->userdata('userid')}");
		$this->data['records'] = $records->result_array();
		$this->parser->parse('weihulist',$this->data);
	}
	
	public function insurancelist(){
		$this->needLogin();
		$records = $this->db->query("select * from insurance where userid={$this->session->userdata('userid')}")->result_array();;
		foreach ($records as $k=>$v)
		{
			$records[$k]['image'] = base_url('assets/uploads/files/' . $v['image']);
			$records[$k]['ID_front_image'] = base_url('assets/uploads/files/' . $v['ID_front_image']);
			$records[$k]['ID_back_image'] = base_url('assets/uploads/files/' . $v['ID_back_image']);
			$records[$k]['bank_image'] = base_url('assets/uploads/files/' . $v['bank_image']);
		}
		$this->data['records'] = $records;
		$this->parser->parse('insurancelist',$this->data);
	}
	
	public function workerlist(){
		$this->needLogin();
		$records = $this->db->query("select * from worker")->result_array();
		foreach ($records as $k=>$v)
		{
			$records[$k]['image'] = base_url('assets/uploads/files/' . $v['image']);
		}
		$this->data['records'] = $records;
		$this->parser->parse('workerlist',$this->data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */