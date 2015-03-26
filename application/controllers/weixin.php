<?php
require_once 'checkMessage.php';
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class weixin extends CI_Controller {
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
	
	//feedback
	public function get_pay_info()
	{
		$postStr = $GLOBALS ["HTTP_RAW_POST_DATA"];
		$log['message'] = "paysuccess";
		$this->db->insert('log',$log);
		// extract post data
		if (! empty ( $postStr )) {
			/*
			 * libxml_disable_entity_loader is to prevent XML eXternal Entity Injection, the best way is to check the validity of xml by yourself
			*/
			libxml_disable_entity_loader ( true );
			$postObj = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
			if($postObj->return_code == "SUCCESS")
			{
				$sql = "update `order` set status='已付款' where md5(id) = '{$postObj->out_trade_no}'";
				$this->db->query($sql);
				$order = "select t1.*,t2.name,t2.price from `order` t1 left join `product` t2 on t1.product_id=t2.id where md5(id) = '{$postObj->out_trade_no}' ";
				$checkMessage = new checkMessage();
				$checkMessage->MessagePaySuccess($order);
			}else{
				$sql = "update `order` set status='{$postObj->return_msg}' where md5(id) = '{$postObj->out_trade_no}'";
				$this->db->query($sql);
			}
		}
	
		$return['return_code'] = $postStr->return_code;
		$return['return_msg'] = $postStr->return_msg;
		echo $this->arrayToXml($return);
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
		return $xml;
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
		
		if ($this->checkSignature ()) {
			echo $echoStr;
			exit ();
		}
	}
	
// 	public function responseMsg() {
// 		// get post data, May be due to the different environments
// 		$postStr = $GLOBALS ["HTTP_RAW_POST_DATA"];
// 		// extract post data
// 		if (! empty ( $postStr )) {
// 			/*
// 			 * libxml_disable_entity_loader is to prevent XML eXternal Entity Injection, the best way is to check the validity of xml by yourself
// 			 */
// 			libxml_disable_entity_loader ( true );
// 			$postObj = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
			
// 			$log['message'] = $postObj;
// 			$this->db->insert('log', $log);
				
// 			$fromUsername = $postObj->FromUserName;
// 			$toUsername = $postObj->ToUserName;
// 			$keyword = trim ( $postObj->Content );
// 			$time = time ();
			
// 			$msgtype = $postObj->MsgType;
// 			$event = $postObj->Event;
			
// 			$log['message'] = $msgtype."&".$event;
// 			$this->db->insert('log', $log);
// 			if($msgtype == "event")
// 			{
// 				if($event == "merchant_order")
// 				{
// 					$checkMessage = new checkMessage();
// 					$order = $checkMessage->getOrderById($postObj->OrderId)['order'];
// 					$log['message'] = $postObj->OrderId;
// 					$this->db->insert('log', $log);
// 					$order['order_create_time'] = date("Y-m-d H:i:s",$order['order_create_time']);
// 					$order['order_id'] = $postObj->OrderId;
// 					$this->db->insert('order', $order);
// 					$checkMessage->MessagePaySuccess($order);
// 				}else if ($event == "TEMPLATESENDJOBFINISH"){
// 					$status = $postObj->Status;
// 					$msgid = $postObj->MsgID;
// 					$this->db->query("update `message` set status='{$status}' where message_id='{$msgid}'");
// 				}
// 			}
// 			$xmlTpl = "<xml>
// 						<ToUserName><![CDATA[%s]]></ToUserName>
// 						<FromUserName><![CDATA[%s]]></FromUserName>
// 						<CreateTime>%s</CreateTime>
// 						<MsgType><![CDATA[transfer_customer_service]]></MsgType>
// 						</xml>";
// 			$result = sprintf ( $xmlTpl, $fromUsername, $toUsername, time () );
// 			echo $result;
// 		} else {
// 			echo "";
// 			exit ();
// 		}
// 	}

	public function responseMsg()
	{
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
	
		if (!empty($postStr)){
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$keyword = trim($postObj->Content);
			$time = time();
			$textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
			if($keyword == "?" || $keyword == "？")
			{
				$msgType = "text";
				$contentStr = date("Y-m-d H:i:s",time());
				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
				echo $resultStr;
			}
		}else{
			echo "";
			exit;
		}
	}
	
	private function getOrderInfo($orderid) {
		$url = site_url("checkMessage/getOrderById/".$orderid);
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		
		$output = curl_exec ( $ch );
		$output_array = json_decode ( $output, true );
		curl_close ( $ch );
		// 打印获得的数据
		return $output_array;
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