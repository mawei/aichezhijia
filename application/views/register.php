<!DOCTYPE html>
<html>
{head}
<body>

<div data-role="page">
  <div data-role="content">
  	<?php echo $error;?>
    <form method="post" action="<?php echo base_url("index.php/index/registerpost");?>" data-ajax="false">
      <input type="text" name="username" id="username" placeholder="用户名">
      <input type="text" name="phone" id="phone" placeholder="手机号">
      <input type="text" name="carmodel" id="carmodel" placeholder="车型">
      <input type="text" name="password" id="password" placeholder="密码">
      <input type="text" name="password2" id="password2" placeholder="再次密码">
      <input type="submit" data-inline="false" value="注册">
    </form>
  </div>
</div>

</body>
</html>


