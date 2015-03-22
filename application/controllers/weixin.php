<?php
require_once 'checkMessage.php';
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
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function valid() {
		$echoStr = isset ( $_GET ["echostr"] ) ? $_GET ["echostr"] : "";
		
// 		$checkMessage = new checkMessage();
// 		$order = $checkMessage->getOrderById("12924112555910455451")['order'];
// 		$log['message'] = $order['product_name'];
// 		$this->db->insert('log', $log);
// 		$order['order_create_time'] = date("Y-m-d H:i:s",$order['order_create_time']);
// 		$checkMessage->MessagePaySuccess($order);
// 		$this->db->insert('order', $order);
		
// 		print_r($order);die();
		
		// valid signature , option
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
					$checkMessage = new checkMessage();
					$order = $checkMessage->getOrderById($postObj->OrderId)['order'];
					//$log['message'] = $order['product_name'];
					//$this->db->insert('log', $log);
					$order['order_create_time'] = date("Y-m-d H:i:s",$order['order_create_time']);
					$this->db->insert('order', $order);
					$checkMessage->MessagePaySuccess($order);
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */