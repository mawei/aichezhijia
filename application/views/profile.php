<!DOCTYPE html>
<html>
{head}
<body>
{header}

<div class="container">
<div data-role="page">
  <div data-role="content">
<button type="button" class="btn btn-primary btn-lg">
  <span class="glyphicon glyphicon-user"></span> 用户资料
</button>
<br/>
<br/>
<ul class="list-group">
      {user}
    <li class="list-group-item">姓名：{name}</li>
    <li class="list-group-item">电话：{phone}</li>
    <li class="list-group-item">车型：{carmodel}</li>
    <li class="list-group-item">轮胎：{wheel}</li>
    {/user}
    <br/>
    <a class="btn btn-default" href="<?=site_url('index/editprofile')?>" role="button">编辑</a>
       
  </ul>
  </div>
</div>
</div>
{footer}
</body>
</html>


