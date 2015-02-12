<!DOCTYPE html>
<head>
	<title>登陆</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/templatemo_style.css')?>"/>
	{head}
</head>
<body class="templatemo-bg-gray">
	<div class="container">
		<div class="col-md-12">
			<h1 class="margin-bottom-15">泉林汽车</h1>
			<form class="form-horizontal templatemo-container templatemo-login-form-1 margin-bottom-30" role="form" method="post" action="<?php echo site_url("index/loginpost");?>" data-ajax="false">				
		        <div class="form-group">
		          <div class="col-xs-12">		            
		            <div class="control-wrapper">
		            	<label for="username" class="control-label fa-label"><i class="fa fa-user fa-medium"></i></label>
		            	<input type="text" class="form-control" id="username" name="username" placeholder="用户名">
		            </div>		            	            
		          </div>              
		        </div>
		        <div class="form-group">
		          <div class="col-md-12">
		          	<div class="control-wrapper">
		            	<label for="password" class="control-label fa-label"><i class="fa fa-lock fa-medium"></i></label>
		            	<input type="password" class="form-control" id="password" name="password" placeholder="密码">
		            </div>
		          </div>
		        </div>
		        <input type="hidden" name="weixinID" id="weixinID" value="{weixinID}">
      			<input type="hidden" name="referurl" id="referurl" value="{referurl}">
		        <div class="form-group">
		          <div class="col-md-12">
	             	<div class="checkbox control-wrapper">
	                	<label>
                		</label>
	              	</div>
		          </div>
		        </div>
		        <div class="form-group">
		          <div class="col-md-12">
		          	<div class="control-wrapper">
		          		<input type="submit" value="登陆" class="btn btn-info">
<!-- 		          		<a href="forgot-password.html" class="text-right pull-right">Forgot password?</a>
 -->		          	</div>
		          </div>
		        </div>
		      </form>
		      <div class="text-center">
		      	<a href="<?php echo site_url("index/register");?>" class="templatemo-create-new">注册新账号 <i class="fa fa-arrow-circle-o-right"></i></a>	
		      </div>
		</div>
	</div>
	{footer}
</body>
</html>