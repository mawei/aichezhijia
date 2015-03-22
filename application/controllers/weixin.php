<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Weixin extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * http://example.com/index.php/welcome
	 * - or -
	 * http://example.com/index.php/welcome/index
	 * - or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * 
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {
		define ( "TOKEN", "weixin" );
		$wechatObj = new wechatCallbackapiTest ();
		
		//$postStr = $GLOBALS ["HTTP_RAW_POST_DATA"];
		if (! isset ( $_GET ['echostr'] )) {
			$wechatObj->responseMsg ();
		} else {
			$wechatObj->valid ();
		}
	}
}

class wechatCallbackapiTest  extends CI_Controller {
	var $appid = "wx13facdc7a21c75b6";
	var $secret = "8ceb383fc897603a7edeab04c5311d37";
	var $access_token = "";
	var $feedback_url = "http://www.qlqc.net.cn/aichezhijia/index.php?/weixin?t=3808430971";
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	
		$this->access_token = $this->getAccessToken();
	
	}
	
	public function valid() {
		$echoStr = isset ( $_GET ["echostr"] ) ? $_GET ["echostr"] : "";
		
		if ($this->checkSignature ()) {
			echo $echoStr;
			exit ();
		}
	}
	
	public function responseMsg() {
		// get post data, May be due to the different environments
		
		$postStr = $GLOBALS ["HTTP_RAW_POST_DATA"];
		// extract post data
		if (! empty ( $postStr )) {
			/*
			 * libxml_disable_entity_loader is to prevent XML eXternal Entity Injection, the best way is to check the validity of xml by yourself
			 */
			libxml_disable_entity_loader ( true );
			$postObj = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
			
			$log['message'] = "message";
			$this->db->insert('log', $log);
				
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$keyword = trim ( $postObj->Content );
			$time = time ();
			
			$msgtype = $postObj->MsgType;
			$event = $postObj->Event;
			
			$log['message'] = $msgtype."&".$event;
			$this->db->insert('log', $log);
			if($msgtype == "event")
			{
				if($event == "merchant_order")
				{
					$url = site_url("weixin/processOrder/".$postObj->OrderId);
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL,$url);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
					curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
					$output = json_decode(curl_exec($curl)) ;
					
					$order = $output['order'];
					$order['order_create_time'] = date("Y-m-d H:i:s",$order['order_create_time']);
					$this->db->insert('order', $order);
					$this->MessagePaySuccess($order);
						
				}else if ($event == "TEMPLATESENDJOBFINISH"){
					$status = $postObj->Status;
					$msgid = $postObj->MsgID;
					$this->db->query("update `message` set status='{$status}' where message_id='{$msgid}'");
				}
			}
			
			$xmlTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[transfer_customer_service]]></MsgType>
						</xml>";
			$result = sprintf ( $xmlTpl, $fromUsername, $toUsername, time () );
			echo $result;
		} else {
			echo "";
			exit ();
		}
	}
	
	private function checkSignature() {
		// you must define TOKEN by yourself
		if (! defined ( "TOKEN" )) {
			throw new Exception ( 'TOKEN is not defined!' );
		}
		
		$signature = isset ( $_GET ["signature"] ) ? $_GET ["signature"] : "";
		$timestamp = isset ( $_GET ["timestamp"] ) ? $_GET ["timestamp"] : "";
		$nonce = isset ( $_GET ["nonce"] ) ? $_GET ['nonce'] : "";
		$token = TOKEN;
		$tmpArr = array (
				$token,
				$timestamp,
				$nonce 
		);
		// use SORT_STRING rule
		sort ( $tmpArr, SORT_STRING );
		$tmpStr = implode ( $tmpArr );
		$tmpStr = sha1 ( $tmpStr );
		
		if ($tmpStr == $signature) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getAccessToken() {
		// 初始化
		$ch = curl_init();
		// 设置选项，包括URL
		curl_setopt ( $ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->secret}" );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false);
		// 执行并获取HTML文档内容
		$output = curl_exec ($ch);
		$output_array = json_decode ( $output, true );
		// 释放curl句柄
		curl_close ( $ch );
		return $output_array['access_token'];
	}
	
	public function MessagePaySuccess($info) {
		//print_r($info);die();
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$this->access_token}";
		$post_data = array (
				"touser" => $info['buyer_openid'],
				"template_id" => "9DuC0s4n8iA2O7TAJSkZ6DX-U83UAup7P1dxW66SpzU",
				"url" =>$this->feedback_url,
				"topcolor" => "#FF0000",
				"data" => array(
						"first"=>array("value" => "恭喜你，购买成功", "color"=>"#173177"),
						"keyword1"=>array("value" => $info['product_name'], "color"=>"#173177"),
						"keyword2"=>array("value" => $info['product_id'], "color"=>"#173177"),
						"keyword3"=>array("value" => $info['order_total_price'], "color"=>"#173177"),
						"keyword4"=>array("value" => $info['order_create_time'], "color"=>"#173177"),
						"remark"=>array("value" => "欢迎再次购买", "color"=>"#173177")
				)
		);
		$data = json_encode($post_data);
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false);
		// post数据
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		// post的变量
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		$output = curl_exec ( $ch );
		$output_array = json_decode ( $output, true );
		curl_close ( $ch );
		// 打印获得的数据
		$msgid = $output_array['errcode'] == "0" ?  $output_array['msgid'] : "";
	
		$this->saveMessage($info['buyer_openid'],$msgid,"ngqIpbwh8bUfcSsECmogfXcV14J0tQlEpBO27izEYtY",$output_array['errmsg']);
	}
	
	public function maintanceComplete($info) {
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$this->access_token}";
		$post_data = array (
				"touser" => $info['weixinID'],
				"template_id" => "CULBZkGJc21QkzWeIIVDLtnxYFnjSA6R0PO2YwqT5X8",
				"url" =>$this->feedback_url,
				"topcolor" => "#FF0000",
				"data" => array(
						"first"=>array("value" => "尊敬的{$info['name']}，您{$info['date']}的保养维修服务已完成。", "color"=>"#173177"),
						"keynote1"=>array("value" => $info['carmodel'] . $info['paizhao'], "color"=>"#173177"),
						"keynote2"=>array("value" => $info['itemname'], "color"=>"#173177"),
						"keynote3"=>array("value" => $info['date'], "color"=>"#173177"),
						"keynote4"=>array("value" => $info['mile'], "color"=>"#173177"),
						"keynote5"=>array("value" => $info['total'], "color"=>"#173177"),
						"remark"=>array("value" => "服务热线：021-64369885", "color"=>"#173177")
				)
		);
		$data = json_encode($post_data);
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false);
		// post数据
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		// post的变量
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		$output = curl_exec ( $ch );
		$output_array = json_decode ( $output, true );
		curl_close ( $ch );
		// 打印获得的数据
		$msgid = $output_array['errcode'] == "0" ?  $output_array['msgid'] : "";
	
		$this->saveMessage($info['weixinID'],$msgid,"CULBZkGJc21QkzWeIIVDLtnxYFnjSA6R0PO2YwqT5X8",$output_array['errmsg']);
	}
	
	public function maintanceExpire($info) {
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$this->access_token}";
		$post_data = array (
				"touser" => $info['weixinID'],
				"template_id" => "UYBBw6I_-VQtTaVI2WI5RmRDU5RdkfsB-wXdAkrr16M",
				"url" =>$this->feedback_url,
				"topcolor" => "#FF0000",
				"data" => array(
						"first"=>array("value" => "尊敬的{$info['name']}，您车牌为{$info['chepai']}的汽车保养还有七天将到期", "color"=>"#173177"),
						"keynote1"=>array("value" => $info['next_baoyang_date'], "color"=>"#173177"),
						"keynote2"=>array("value" => $info['last_baoyang_date'], "color"=>"#173177"),
						"keynote3"=>array("value" => $info['last_mile'], "color"=>"#173177"),
						"remark"=>array("value" => "若保养时间提醒有误，可重新设置保养时间！
							温馨提示：保养到期时间是通过分析您以往的保养记录而计算出的结果，保养数据越完整，分析结果越准确。服务热线：021-64369885", "color"=>"#173177")
				)
		);
		$data = json_encode($post_data);
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false);
		// post数据
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		// post的变量
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		$output = curl_exec ( $ch );
	
		$output_array = json_decode ( $output, true );
	
		curl_close ( $ch );
		// 打印获得的数据
		$msgid = $output_array['errcode'] == "0" ?  $output_array['msgid'] : "";
		$this->saveMessage($info['weixinID'],$msgid,"UYBBw6I_-VQtTaVI2WI5RmRDU5RdkfsB-wXdAkrr16M",$output_array['errmsg']);
	}
	
	public function insecureExpire($info) {
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$this->access_token}";
		$post_data = array (
				"touser" => $info['weixinID'],
				"template_id" => "WOA-cd7-By7HiRWGkEA51p5jLa9W2Yk5KdVGkUsf3Zc",
				"url" =>$this->feedback_url,
				"topcolor" => "#FF0000",
				"data" => array(
						"first"=>array("value" => "尊敬的{$info['name']}，您车牌为{$info['chepai']}的汽车保险还有1个月到期", "color"=>"#173177"),
						"keynote1"=>array("value" => $info['last_baoxian_date'], "color"=>"#173177"),
						"keynote2"=>array("value" => $info['next_baoxian_date'], "color"=>"#173177"),
						"remark"=>array("value" => "请及时续保,若保险时间提醒有误，可重新设置保险时间。服务热线：021-64369885", "color"=>"#173177")
				)
		);
		$data = json_encode($post_data);
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false);
	
		// post数据
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		// post的变量
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		$output = curl_exec ( $ch );
		$output_array = json_decode ( $output, true );
		curl_close ( $ch );
		// 打印获得的数据
		$msgid = $output_array['errcode'] == "0" ?  $output_array['msgid'] : "";
	
		$this->saveMessage($info['weixinID'],$msgid,"WOA-cd7-By7HiRWGkEA51p5jLa9W2Yk5KdVGkUsf3Zc",$output_array['errmsg']);
	}
	
	public function  processOrder($orderid)
	{
		$access_token = $this->getAccessToken();
	
		$url = "https://api.weixin.qq.com/merchant/order/getbyid?access_token={$access_token}";
		$post_data = array("order_id" => $orderid);
		$data = json_encode($post_data);
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false);
		// post数据
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		// post的变量
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		$output = curl_exec ( $ch );
		$output_array = json_decode ( $output, true );
		curl_close ( $ch );
		// 打印获得的数据
		return $output_array;
	}
	
	public function saveMessage($openid,$message_id,$templete_id,$status)
	{
		echo $openid;
		print_r($status);
	
		$message['openid'] = $openid;
		$message['message_id'] = $message_id;
		$message['template_id'] = $templete_id;
		$message['create_time'] = date("Y-m-d H:i:s",time());
		$message['status'] = $status;
		$this->load->database();
		$this->db->insert('message', $message);
	}
	
	public function updateMessage($message_id,$status)
	{
		$message['message_id'] = $message_id;
		$this->db->query("update `message` set status={$status} where message_id = '{$message_id}'");
	}
	
	public function postmessage(){
	
		$this->checkMaintanceExpire();
		$this->checkBaoxianExpire();
		echo 'success';
	}
	
	private function checkMaintanceExpire()
	{
		$sql = "select * from user where DATEDIFF(next_baoyang_date,NOW()) > 7";
		$result = $this->db->query($sql)->result_array();
		foreach ($result as $r)
		{
			$this->maintanceExpire($r);
		}
	}
	
	private function checkBaoxianExpire()
	{
		$sql = "select * from user where DATEDIFF(next_baoxian_date,NOW()) = 30";
		$result = $this->db->query($sql)->result_array();
		foreach ($result as $r)
		{
			$this->insecureExpire($r);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */