<!DOCTYPE html>
<html>
{head}
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
    <a href="<?php echo site_url("index/register");?>">点击注册</a>
  </div>
</div>

</body>
</html>


