
<!DOCTYPE html>
<head>
	<title>登陆</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/templatemo_style.css')?>"/>
	{head}
</head>

<body>
{header}
<form action="<?php echo site_url("index/registerpost");?>" method="post" class="am-form" data-am-validator>
  <fieldset>
    <legend>注册</legend>
    <div class="am-form-group">
      <label for="doc-vld-name-2">用户名：</label>
      <input type="text" id="doc-vld-name-2" minlength="11"
             placeholder="手机号" name="username" pattern="^\d{11}$" required/>
    </div>

    <div class="am-form-group">
      <label for="doc-vld-pwd-1">密码：</label>
      <input type="password" id="doc-vld-pwd-1" minlength="6" name="password"
       placeholder="密码（至少6位）" required/>
    </div>

    <div class="am-form-group">
      <label for="doc-vld-pwd-2">确认密码：</label>
      <input type="password" id="doc-vld-pwd-2" name="password"
       placeholder="请与上面输入的值一致" data-equal-to="#doc-vld-pwd-1" required/>
    </div>

    <button class="am-btn am-btn-secondary" type="submit">提交</button>
</fieldset>
</form>
	{footer}

</body>



</body>
</html>


