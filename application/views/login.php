<!DOCTYPE html>
<head>
	{head}
</head>
<body>
{header}
<form action="<?php echo site_url("index/loginpost");?>" method="post" class="am-form" data-am-validator>
  <fieldset>
    <legend>登陆</legend>
    <div class="am-form-group">
      <label for="doc-vld-name-2">手机号：</label>
      <input type="text" id="doc-vld-name-2" minlength="11"
             placeholder="手机号" name="username" pattern="^\d{11}$" required/>
    </div>

    <div class="am-form-group">
      <label for="doc-vld-pwd-1">密码：</label>
      <input type="password" id="doc-vld-pwd-1" minlength="6" name="password"
       placeholder="密码（至少6位）" required/>
    </div>
    
	<input type="hidden" name="weixinID" id="weixinID" value="{weixinID}">
    <input type="hidden" name="referurl" id="referurl" value="{referurl}">
    
    <button class="am-btn am-btn-secondary" type="submit">提交</button>
</fieldset>
</form>
		<div class="text-center">
		     <a href="<?php echo site_url("index/register");?>" class="templatemo-create-new">注册新账号 <i class="fa fa-arrow-circle-o-right"></i></a>	
	    </div>

	{footer}
</body>

</html>