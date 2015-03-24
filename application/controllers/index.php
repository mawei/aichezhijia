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
		
		header("Content-type:text/html;charset=utf-8");
		
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
		if(isset($_REQUEST['code']) && $_REQUEST['code'] != "")
		{
			$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->appid}&secret={$this->secret}&code={$_REQUEST['code']}&grant_type=authorization_code";
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL,$url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
			$output = json_decode(curl_exec($curl)) ;
			if($output->openid != "")
			{
				$query = $this->db->query("select * from `user` where weixinID='{$output->openid}'");
				if(count($query->result_array())>0)
				{
					$this->session->set_userdata('userid', $query->result_array()[0]['id']);
					redirect('profile');
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
// 		if(isset($_GET['type']))
// 		{
// 			if($_GET['type'] == "")
// 			{
// 				$type = "profile";
// 			}else{
// 				$type = $_GET['type'];
// 			}
// 		}else{
// 			$type = "profile";
// 		}
// 		$this->data['type'] = $type;
		$this->data["error"] = "";
		//微信
		if(self::is_weixin())
		{
			$loginResult = $this->needlogin();
			if($loginResult == 'success')
			{
				$this->parser->parse('index',$this->data);
			}elseif($loginResult != ''){
				redirect("index/login?weixinID={$loginResult}");
			}
		}else{
			$this->parser->parse('index',$this->data);
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
			if($weixinID != "" && $weixinID != "{weixinID}")
			{
				$this->db->query("update `user` set weixinID='{$weixinID}' where id = {$query->result_array()[0]['id']}");
			}
			//print_r($referurl);die();
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
	
	public function usercenter()
	{
		$this->parser->parse('usercenter',$this->data);
	}
	
	public function aboutus()
	{
		$this->parser->parse('aboutus',$this->data);
	}
	
	public function order()
	{
		$loginResult = $this->needlogin();
		if($loginResult == 'success')
		{
			$products = $this->db->query("select * from product")->result_array();
			$this->data['products'] = $products;
			$this->parser->parse('order',$this->data);
		}elseif($loginResult != '')
		{
			redirect("index/login?weixinID={$loginResult}");
		}
		
		
	}
	
	public function submit_order()
	{
		$product = addslashes($_POST['product']);
		$date = addslashes($_POST['date']);
		$order['product_id'] = $product;
		$order['create_time'] = date("Y-m-d H:i:s");
		$order['date'] = $date;
		$order['user_id'] = $this->session->userdata('userid');
		$this->db->insert('order',$order);
		$p = $this->db->query("select t1.*,t2.phone,t2.chepai,t2.weixinID,t2.carmodel,t3.name,t3.price from `order` t1 left join user t2 on t1.user_id=t2.id
				left join product t3 on t3.id=t1.product_id
				 where t1.id={$this->db->insert_id()}")->result_array()[0];
		
		$data['appid'] = 'wx13facdc7a21c75b6';
		$data['body'] = $p['name'];
		$data['device_info'] = 'WEB';
		$data['mch_id'] = '1227215102';
		$data['nonce_str'] = md5(rand(100000, 99999));
		$data['notify_url'] = site_url("index/wechat_pay_notifyurl");
		$data['openid'] = $p['weixinID'];
		$data['out_trade_no'] = md5($p['id']);
		$data['spbill_create_ip'] = "8.8.8.8";
		$data['total_fee'] = $p['price'];
		$data['trade_type'] = "JSAPI";
		$string = "appid={$data['appid']}&body={$data['body']}&device_info={$data['device_info']}&mch_id={$data['mch_id']}&nonce_str={$data['nonce_str']}&notify_url={$data['notify_url']}&openid={$data['openid']}&out_trade_no={$data['out_trade_no']}&spbill_create_ip={$data['spbill_create_ip']}&total_fee={$data['total_fee']}&trade_type={$data['trade_type']}";
		$string = $string . "&key=7c914cc19e472a13e7b93aad9aa7bc69";
		//echo $string;die();
		$data['sign'] = strtoupper(MD5($string));
		$post_data = $this->arrayToXml($data);
		$ch = curl_init();
		// 设置选项，包括URL
		curl_setopt ( $ch, CURLOPT_URL, "https://api.mch.weixin.qq.com/pay/unifiedorder" );
		curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
		// post的变量
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
		
		$output = curl_exec ( $ch );
		libxml_disable_entity_loader ( true );
		$result = simplexml_load_string ( $output, 'SimpleXMLElement', LIBXML_NOCDATA );
			
		//$result = json_decode ( $output, true );
		//print_r($postObj);die();
		if($result->return_code == "SUCCESS")
		{
			$this->data['timeStamp'] = time();
			$this->data['appId'] = $result->appid;
			$this->data['nonceStr'] = $result->nonce_str; 
			$this->data['signType'] = 'MD5';
			$this->data['package'] = "prepay_id=".$result->prepay_id;
						
			$result['appid'] = 
			$string = "appid={$this->data['appId']}&nonceStr={$this->data['nonce_str']}&package={$this->data['package']}&signType=MD5&timeStamp={$this->data['timeStamp']}";
			$string = $string . "&key=7c914cc19e472a13e7b93aad9aa7bc69";
			$this->data['paySign'] = strtoupper(MD5($string));
			$this->data['phone'] = $p['phone'];
			$this->data['chepai'] = $p['chepai'];
			$this->data['carmodel'] = $p['carmodel'];
			$this->data['name'] = $p['name'];
			$this->data['price'] = $p['price'];
			$this->data['date'] = $p['date'];
			$this->parser->parse('order_confirm',$this->data);
		}else{
			echo $result->return_code.$result->return_msg;
		}
	}
	
	function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
        	 if (is_numeric($val))
        	 {
        	 	$xml.="<".$key.">".$val."</".$key.">"; 

        	 }
        	 else
        	 	$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";  
        }
        $xml.="</xml>";
//       echo $xml;die();
        return $xml; 
    }
	
	public function registerpost()
	{
		$username = addslashes($_POST['username']);
		$password = addslashes($_POST['password']);
		$password2 = addslashes($_POST['password2']);
		$phone = addslashes($_POST['username']);
		//$carmodel = addslashes($_POST['carmodel']);
		
		if($username == "" || $password==""||$password2=="")
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
				$query = $this->db->query("insert into `user` (username,password,phone) values ('{$username}','{$password}','{$phone}')");
				redirect('index/login');
			}
		}
	}
	
	public function complete_profile()
	{
		$this->parser->parse('complete_profile',$this->data);
	}
	
	public function complete_profile_post()
	{
		$wheel = addslashes($_POST['wheel']);
		$carmodel = addslashes($_POST['carmodel']);
		if($wheel == "" || $carmodel=="")
		{
			$error = "请输入完整";
			$this->data['error'] = $error;
			$this->parser->parse('complete_profile',$this->data);
		}
		else
		{
			$query = $this->db->query("select * from `user` where username='{$username}'");
			if(count($query->result_array())>0)
			{
				$error = "用户名已存在";
				$this->data['error'] = $error;
				$this->parser->parse('register',$this->data);
			}else{
				$query = $this->db->query("update `user` (carmodel,wheel) values ('{$carmodel}','{$wheel}')");
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
	
	public function shoplist()
	{
		$loginResult = $this->needlogin();
		$records = $this->db->query("select * from shop");
		$this->data['shops'] = $records->result_array();
		$this->parser->parse('shoplist',$this->data);
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
			$this->data['news'] = $news;
			$this->parser->parse('newsdetail',$this->data);
		}else{
			$news = $this->db->query("select * from news where type='养车宝典'")->result_array();
			$this->data['news'] = $news;
			$this->parser->parse('newslist',$this->data);
		}
	}
	
	public function orderlist()
	{
		$loginResult = $this->needlogin();
		if($loginResult == 'success')
		{
			$orders = $this->db->query("select t1.* from `order` t1 left join user t2 on t1.buyer_openid = t2.weixinID where t2.id={$this->session->userdata('userid')}");
			$this->data['orders'] = $orders->result_array();
			$this->parser->parse('orderlist',$this->data);
		}elseif($loginResult != '')
		{
			redirect("index/login?weixinID={$loginResult}");
		}
	}
	
	public function activity()
	{
		if(isset($_GET['id']) && $_GET['id'] != ""){
			$news = $this->db->query("select * from news where id={$_GET['id']}")->result_array();
			$this->data['news'] = $news;
			$this->parser->parse('newsdetail',$this->data);
		}else{
			$news = $this->db->query("select * from news where type='活动'")->result_array();
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
	
	public function  profile()
	{
		$loginResult = $this->needlogin();
		if($loginResult == 'success')
		{
			$query = $this->db->query("select * from `user` where id={$this->session->userdata('userid')}");
			$this->data['user'] = $query->result_array();
			$this->parser->parse('profile',$this->data);
		}elseif($loginResult != '')
		{
			redirect("index/login?weixinID={$loginResult}");
		}
	}
	
	public function  service()
	{
		$loginResult = $this->needlogin();
		if($loginResult == 'success')
		{
			$query = $this->db->query("select * from `user` where id={$this->session->userdata('userid')}");
			$this->data['user'] = $query->result_array();
			$this->parser->parse('service',$this->data);
		}elseif($loginResult != '')
		{
			redirect("index/login?weixinID={$loginResult}");
		}
	}
	
	public function  editservice()
	{
		$loginResult = $this->needlogin();
		if($loginResult == 'success')
		{
			if(isset($_POST['last_baoxian_date']))
			{
				$last_baoxian_date = $_POST['last_baoxian_date'];
				$next_baoxian_date = $_POST['next_baoxian_date'];
				$last_baoyang_date = $_POST['last_baoyang_date'];
				$next_baoyang_date = $_POST['next_baoyang_date'];
				$this->db->query("update `user` set 
						last_baoxian_date='{$last_baoxian_date}',
						next_baoxian_date='{$next_baoxian_date}',
						last_baoyang_date='{$last_baoyang_date}',
						next_baoyang_date='{$next_baoyang_date}' where id={$this->session->userdata('userid')}");
				redirect("index/service");
			}else{
				$query = $this->db->query("select * from `user` where id={$this->session->userdata('userid')}");
				$this->data['user'] = $query->result_array();
				$this->parser->parse('editservice',$this->data);
			}
		}
	}
		
	public function  editprofile()
	{
		$loginResult = $this->needlogin();
		if($loginResult == 'success')
		{
			if(isset($_POST['name']))
			{
				$name = $_POST['name'];
				$phone = $_POST['phone'];
				$carmodel = $_POST['carmodel'];
				$wheel = $_POST['wheel'];
				$wheel = $_POST['chepai'];
				$this->db->query("update `user` set name='{$name}',phone='{$phone}',carmodel='{$carmodel}',wheel='{$wheel}',chepai='{$chepai}' where id={$this->session->userdata('userid')}");
				redirect("index/profile");
			}else{
				$query = $this->db->query("select * from `user` where id={$this->session->userdata('userid')}");
				$this->data['user'] = $query->result_array();
				$this->parser->parse('editprofile',$this->data);
			}
		}
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */