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
		$this->load->helper('text');
		
		$this->appid = "wx13facdc7a21c75b6";
		$this->secret = "8ceb383fc897603a7edeab04c5311d37";
		$this->weixinID = "";
		
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
	
	public function needlogin()
	{
		if(self::is_weixin())
		{
			if($this->session->userdata('userid') > 0)
			{
				return "success";
			}
			else
			{
				$redirect_uri = urlencode(site_url("index/loginInWeixin?weixin=1"));
				$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->appid}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
				redirect($url);
// 				$curl = curl_init();
// 				curl_setopt($curl, CURLOPT_URL,$url);
// 				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
// 				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
// 				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// 				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
// 				curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
// 				$rs = curl_exec($curl);
// 				return $rs;
			}
		}else{
			if($this->session->userdata('userid') > 0)
			{
				return "success";
			}else{
				redirect("index/login");
			}
		}
	}
	
	public function loginInWeixin()
	{
		$result = "";
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
					redirect('index');
// 					$result = 'success';
				}else{
					redirect("index/login?weixinID={$output->openid}");
// 					$result = $output->openid;
				}
			}
		}
		echo $result;
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
		$this->data["error"] = "";
		//微信
		$loginResult = $this->needlogin();
		if($loginResult == 'success')
		{
			$this->parser->parse('index',$this->data);
		}elseif($loginResult != ''){
			redirect("index/login?weixinID={$loginResult}");
		}
	}
	
	public function login()
	{
		//微信登陆
		$this->data['weixinID'] = isset($_GET['weixinID']) ? $_GET['weixinID'] :"";
		$this->data['referurl'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "index";
		$this->data['error'] = "";
		$this->parser->parse('login',$this->data);
	}
	
	public function  loginout()
	{
		$this->session->set_userdata("userid",0);
		$this->data['error'] = "";
		$this->parser->parse('login',$this->data);
	}
	
	public function loginpost()
	{
		$username = addslashes($_POST['username']);
		$password = addslashes($_POST['password']);
		$weixinID = addslashes($_POST['weixinID']);
		$referurl = addslashes($_POST['referurl']);
		//print_r($referurl);die();
		$query = $this->db->query("select * from `user` where username='{$username}' and password='{$password}'");
		if(count($query->result_array())>0)
		{
			$this->session->set_userdata('userid', $query->result_array()[0]['id']);
			if($weixinID != "")
			{
				$this->db->query("update `user` set weixinID='{$weixinID}' where id = {$query->result_array()[0]['id']}");
			}
			//print_r($referurl);die();
			redirect("index");
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
		
		$loginResult = $this->needlogin();
		if($loginResult == 'success')
		{
			$records = $this->db->query("select * from maintenance_record where userid={$this->session->userdata('userid')}");
			$this->data['records'] = $records->result_array();
			$this->parser->parse('weihulist',$this->data);
		}elseif($loginResult != '')
		{
			redirect("index/login?weixinID={$loginResult}");
		}
	}
	
	public function insurancelist(){
		$loginResult = $this->needlogin();
		if($loginResult == 'success')
		{
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
		elseif($loginResult != '')
		{
			redirect("index/login?weixinID={$loginResult}");
		}
		
	}
	
	public function workerlist(){
		$loginResult = $this->needlogin();
		if($loginResult == 'success')
		{
			$records = $this->db->query("select * from worker")->result_array();
			foreach ($records as $k=>$v)
			{
				$records[$k]['image'] = base_url('assets/uploads/files/' . $v['image']);
			}
			$this->data['records'] = $records;
			$this->parser->parse('workerlist',$this->data);
		}
		elseif($loginResult != '')
		{
			redirect("index/login?weixinID={$loginResult}");
		}
	}
	
	public function baodian()
	{
		if(isset($_GET['id']) && $_GET['id'] != ""){
			$news = $this->db->query("select * from news where id={$_GET['id']}")->result_array();
			$this->data['news'] = $news[0];
			$this->parser->parse('newsdetail',$this->data);
		}else{
			$news = $this->db->query("select * from news")->result_array();
			$this->data['news'] = $news;
			$this->parser->parse('newslist',$this->data);
		}
	}
	
	public function suggest()
	{
		$message = "";
		$this->data['message'] = $message;
		if(isset($_POST['content']) && $_POST['content'] != "")
		{
			$this->db->query("insert into `suggest` (content,userid) values (\"{$_POST['content']}\",\"{$this->session->userdata('userid')}\")");
			$this->data['message'] = "提交成功";
			$message = "提交成功";
			$this->parser->parse('suggest',$this->data);
		}else{
			$this->parser->parse('suggest',$this->data);
		}
	}
	
	public function joinus()
	{
		$result = $this->db->query("select * from `config` where `key`='joinus'")->result_array();
		if(count($result) > 0)
		{
			$this->data['joinus'] = $result[0]['value'];
		}else{
			$this->data['joinus'] = "暂时没有";
		}
		$this->parser->parse('joinus',$this->data);
	}
	
	public function  findus()
	{
		$result = $this->db->query("select * from `config` where `key`='findus'")->result_array();
		if(count($result) > 0)
		{
			$this->data['findus'] = $result[0]['value'];
		}else{
			$this->data['findus'] = "暂时没有";
		}
		$this->parser->parse('findus',$this->data);
	}
	
	public function  wheel()
	{
		$loginResult = $this->needlogin();
		if($loginResult == 'success')
		{
			$query = $this->db->query("select * from `user` where id={$this->session->userdata('userid')}");
			$this->data['wheel'] = $query->result_array()[0]['wheel'];
			$this->parser->parse('wheel',$this->data);
		}elseif($loginResult != '')
		{
			redirect("index/login?weixinID={$loginResult}");
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */