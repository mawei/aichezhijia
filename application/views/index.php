<!DOCTYPE html>
<html>
{head}
<body>

<div data-role="page" id="pageone">
{header}
  <div data-role="content">
<!--     <h2>我的资料</h2> -->
  <?php if($type == "profile"): ?>
    <ul data-role="listview">
      <li><a href="#">我的轮胎<span class="ui-li-count">{wheel}</span></a></li>
      <li><a href="<?php echo site_url('index/weihulist') ?>">我的维护</a></li>
      <li><a href="<?php echo site_url('index/insurancelist') ?>">我的保险</a></li>
      
    </ul>
    
    
  <?php endif;?>
<!--     <h2>爱车师傅</h2> -->
      <?php if($type == "worker"): ?>
    
    <ul data-role="listview">
      <li><a href="<?php echo site_url('index/workerlist') ?>">师傅预约</a></li>
      <li><a href="<?php echo site_url('index/workerlist') ?>">师傅在线</a></li>
      <li><a href="#">师傅上门</a></li>
      <li><a href="#">增值服务</a></li>
    </ul>
      <?php endif;?>
    
<!--     <h2>爱车导航</h2> -->
        <?php if($type == "daohang"): ?>
      
    <ul data-role="listview">
      <li><a href="#">建议意见</a></li>
      <li><a href="#">养车宝典</a></li>
      <li><a href="#">加入我们</a></li>
    </ul>
          <?php endif;?>
    
  </div>
  {footer}
</div> 

<!-- 	<form id="slick-login" method="post" action="login/userlogin"> -->
<!-- 	<label for="username">用户名</label><input type="text" name="username" class="placeholder" placeholder="me@tutsplus.com"> -->
<!-- 	<label for="password">密码</label><input type="password" name="password" class="placeholder" placeholder="password"> -->
<!-- 	<input type="submit" value="Log In"> -->

</body>
</html>


