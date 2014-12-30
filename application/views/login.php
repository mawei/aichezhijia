<!DOCTYPE html>
<html>
<head>
	<script src="<?php echo base_url('assets/static/js/jquerymobile/jquery-1.10.2.min.js')?>"></script>
	<link rel="stylesheet" href="<?php echo base_url('assets/static/js/jquerymobile/jquery.mobile-1.4.1.min.css')?>">
	<script src="<?php echo base_url('assets/static/js/jquerymobile/jquery.mobile-1.4.1.min.js')?>"></script>
</head>
<body>

<div data-role="page">
  <div data-role="content">
   {error}
    <form method="post" action="<?php echo base_url("index.php/index/loginpost");?>" data-ajax="false">
      <input type="text" name="username" id="username" placeholder="用户名">
      <input type="text" name="password" id="password" placeholder="密码">
      <input type="submit" data-inline="false" value="提交">
    </form>
    <br/>
    <br/>
    <a href="<?php echo base_url("index.php/index/register");?>">点击注册</a>
  </div>
</div>

</body>
</html>


