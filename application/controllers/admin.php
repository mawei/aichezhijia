<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('parser');
		$this->load->library('grocery_CRUD');
	}
		
	public function User()
	{
		$crud = new grocery_CRUD();
// 		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('user');	
		$crud->columns('id','username','phone','carmodel');
		//$crud->edit_fields('username','phone','secret','type');
		
		$crud->display_as('username','用户名');
		$crud->display_as('phone','手机号');
		$crud->display_as('carmodel','车型');
		$crud->display_as('password','密码');
		$crud->display_as('miles_per_day','每日公里数');
		$crud->display_as('last_maintenance_mile','上次保养公里数');
		$crud->display_as('next_maintenance_mile','下次保养公里数');
		$crud->display_as('last_maintenance_detail','上次保养明细');
		$crud->display_as('jiashi_image','驾驶证');
		$crud->display_as('xingshi_image','行驶证');
		$crud->display_as('ID_front_image','身份证正面');
		$crud->display_as('ID_back_image','身份证反面');
		$crud->display_as('bank_image','银行理赔卡');
		$crud->display_as('jiaoqiangxian_image','交强险');
		$crud->display_as('chesunxian_image','车损险');
		$crud->display_as('type','类型');
		
		$crud->set_field_upload('jiashi_image','assets/uploads/files');
		$crud->set_field_upload('xingshi_image','assets/uploads/files');
		$crud->set_field_upload('ID_front_image','assets/uploads/files');
		$crud->set_field_upload('ID_back_image','assets/uploads/files');
		$crud->set_field_upload('bank_image','assets/uploads/files');
		$crud->set_field_upload('jiaoqiangxian_image','assets/uploads/files');
		$crud->set_field_upload('chesunxian_image','assets/uploads/files');
		
		$crud->set_subject('用户');
		$output = $crud->render();	
		$this->load->view('UserManagement',$output);
	}
	
	public function appointment()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('appointment');
		$crud->columns('id','workerid');
		$crud->set_subject('保养预约');
		$crud->display_as('workerid','师傅');
		$crud->set_relation('workerid','worker','name');
		$output = $crud->render();
		$this->load->view('UserManagement',$output);
	}
	
	public function product()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('product');
		$crud->set_subject('预约项目');
		$crud->display_as('name','项目名称');
		$crud->display_as('price','价格（单位：分，只能输入整数）');
		$output = $crud->render();
		$this->load->view('UserManagement',$output);
	}
	
	
	public function order()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('order');
		$crud->set_subject('订单管理');
		$crud->display_as('date','预约时间');
		$crud->display_as('user_id','用户');
		$crud->display_as('status','付款状态');
		$crud->display_as('product_id','购买项目');
		$crud->display_as('create_time','创建时间');
		$crud->set_relation('user_id','user','username');
		$crud->set_relation('product_id','product','name');
		$output = $crud->render();
		$this->load->view('UserManagement',$output);
	}
	
	public function worker()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('worker');
 		$crud->columns('id','name','phone');
		//$crud->edit_fields('partner_id','name','sex','age','photo','type');
 		$crud->set_subject('师傅');
		$crud->display_as('name','姓名');
		$crud->display_as('phone','手机号');
		$crud->display_as('image','照片');
		$crud->set_field_upload('image','assets/uploads/files');
		$output = $crud->render();
		$this->load->view('UserManagement',$output);
	}
	
	public function shop()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('shop');
		$crud->columns('id','name','phone','address');
		//$crud->edit_fields('partner_id','name','sex','age','photo','type');
		$crud->set_subject('分店');
		$crud->display_as('name','名称');
		$crud->display_as('phone','手机号');
		$crud->display_as('address','地址');
		$output = $crud->render();
		$this->load->view('UserManagement',$output);
	}
	
	public function maintenance_record()
	{
		$crud = new grocery_CRUD();
		//$crud->set_theme('twitter-bootstrap');
		$crud->set_table('maintenance_record');
		//$crud->columns('id','userid','itemname','quantity','price','total','shop','date');
		//$crud->edit_fields('partner_id','name','sex','age','photo','type');
		$crud->set_subject('维修记录');
		$crud->display_as('userid','用户名');
		$crud->display_as('itemname','配件名称');
		$crud->display_as('price','价格');
		$crud->display_as('quantity','数量');
		$crud->display_as('total','总数');
		$crud->display_as('shop','店名');
		$crud->display_as('date','日期');
		$crud->set_relation('userid','user','username');
		
		$output = $crud->render();
		$this->load->view('UserManagement',$output);
	}
	
	public function config()
	{
		$crud = new grocery_CRUD();
		//$crud->set_theme('twitter-bootstrap');
		$crud->set_table('config');
		//$crud->columns('id','userid','itemname','quantity','price','total','shop','date');
		//$crud->edit_fields('partner_id','name','sex','age','photo','type');
		$crud->set_subject('网站设置');
		$crud->display_as('key','字段');
		$crud->display_as('alias','名称');
		$crud->display_as('value','内容');
	
		$output = $crud->render();
		$this->load->view('UserManagement',$output);
	}
	
	public function news()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('news');
		$crud->set_subject('新闻');
		$crud->display_as('title','标题');
		$crud->display_as('content','内容');
	
		$output = $crud->render();
		$this->load->view('UserManagement',$output);
	}
	
	public function suggest()
	{
		$crud = new grocery_CRUD();
		$crud->set_table('suggest');
		$crud->set_subject('意见管理');
		$crud->display_as('content','内容');
		$crud->display_as('userid','用户');
		$crud->set_relation('userid','user','username');
		$output = $crud->render();
		$this->load->view('UserManagement',$output);
	}
	
	
	
	public function insurance()
	{
		$crud = new grocery_CRUD();
// 		$crud->set_theme('twitter-bootstrap');
		$crud->set_table('insurance');
		$crud->columns('id','userid','image');
		//$crud->edit_fields('partner_id','name','sex','age','photo','type');
		$crud->set_subject('保险记录');
		$crud->display_as('userid','用户名');
		$crud->display_as('image','保单照片');
		$crud->display_as('ID_front_image','身份证正面');
		$crud->display_as('ID_back_image','身份证反面');
		$crud->display_as('bank_image','银行理赔卡照片');
		$crud->set_relation('userid','user','username');
		
		$crud->set_field_upload('ID_front_image','assets/uploads/files');
		$crud->set_field_upload('ID_back_image','assets/uploads/files');
		$crud->set_field_upload('bank_image','assets/uploads/files');
		$crud->set_field_upload('image','assets/uploads/files');
		
		$output = $crud->render();
		$this->load->view('UserManagement',$output);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */