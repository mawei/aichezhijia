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
		$this->secret = "";
	}
	
	function is_weixin()
	{
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) 
		{         
			return true;   
		}       
		return false;
	}
	
	public function index()
	{
		$data = array('error'=>"");
		
		if($this->session->userdata('userid') > 0)
		{
			$query = $this->db->query("select * from `user` where id={$this->session->userdata('userid')}");
			$data['wheel'] = $query->result_array()[0]['wheel'];
			$this->parser->parse('index',$data);
			
		}else{
			if(is_weixin())
			{
				$redirect_uri = "login";
				redirect("https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect");
			}else{
				$this->parser->parse('login',$data);
			}
		}
	}
	
	public function login()
	{
		if($_REQUEST['code'] != "")
		{
			$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secret}&code={$_REQUEST['code']}&grant_type=authorization_code";
		
			$ch = curl_init($url) ;
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
			curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
			$output = json_decode(curl_exec($ch)) ;
			if($output['openid'] != "")
			{
				$query = $this->db->query("select * from `user` where weixinID='{$output['openid']}'");
				if(count($query->result_array())>0)
				{
					$this->session->set_userdata('userid', $query->result_array()[0]['id']);
					redirect("index");
				}else{
					$this->parser->parse('login',array('error'=>"",'weixinID'=>$output['openid']));
				}
			}
		}
		$this->parser->parse('login',array('error'=>""));
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
			$this->db->query("update `user` set weixinID='{$weixinID}' where id = {$query->result_array()[0]['id']}");
			redirect("index");
		}else{
			$error = "请输入正确的用户名及密码";
			$this->parser->parse('login',array('error'=>$error));
		}
	}
	
	public function register()
	{
		$error = "";
		$this->parser->parse('register',array('error'=>$error));
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
			$this->parser->parse('register',array('error'=>$error));
		}
		elseif($password != $password2)
		{
			$error = "请确认密码是否一致";
			$this->parser->parse('register',array('error'=>$error));
		}
		else{
			$query = $this->db->query("select * from `user` where username='{$username}'");
			if(count($query->result_array())>0)
			{
				$error = "用户名已存在";
				$this->parser->parse('register',array('error'=>$error));
			}else {
				$query = $this->db->query("insert into `user` (username,password,phone,carmodel) values ('{$username}','{$password}','{$phone}','{$carmodel}')");
				redirect('index/login');
			}
		}
	}
	
	public function weihulist()
	{
		$records = $this->db->query("select * from maintenance_record where userid={$this->session->userdata('userid')}");
		$this->parser->parse('weihulist',array('records'=>$records->result_array()));
	}
	
	public function insurancelist(){
		$records = $this->db->query("select * from insurance where userid={$this->session->userdata('userid')}");
		$this->parser->parse('insurancelist',array('records'=>$records->result_array()));
	}
	
	public function workerlist(){
		$records = $this->db->query("select * from worker")->result_array();
		foreach ($records as $k=>$v)
		{
			$records[$k]['image'] = base_url($v['image']);
		}
		$this->parser->parse('workerlist',array('records'=>$records));
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */