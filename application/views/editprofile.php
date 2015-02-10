<!DOCTYPE html>
<html>
{head}
<body>
{header}

<div class="container">
<div data-role="page">
  <div data-role="content">
  
  <form method="post" action="<?=site_url('index/editprofile')?>">
        {user}
  
     <div class="form-group">
      <label for="name" class="col-sm-2 control-label">名字</label>
      <div class="col-sm-10">
         <input type="text" class="form-control" id="name" name="name" value="{name}"
            placeholder="请输入姓名">
      </div>
   </div>
      <div class="form-group">
      <label for="phone" class="col-sm-2 control-label">电话</label>
      <div class="col-sm-10">
         <input type="text" class="form-control" id="phone" name="phone" value="{phone}"
            placeholder="请输入电话">
      </div>
   </div>
      <div class="form-group">
      <label for="name" class="col-sm-2 control-label">车型</label>
      <div class="col-sm-10">
         <input type="text" class="form-control" id="carmodel" name="carmodel" value="{carmodel}"
            placeholder="请输入车型">
      </div>
   </div>
      <div class="form-group">
      <label for="name" class="col-sm-2 control-label">轮胎</label>
      <div class="col-sm-10">
         <input type="text" class="form-control" id="wheel" name="wheel" value="{wheel}"
            placeholder="请输入轮胎">
      </div>
   </div>
   <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
         <button type="submit" class="btn btn-default">提交</button>
         <button type="submit" class="btn btn-default" onclick="javascript:history.go(-1);">取消</button>
      </div>      
      </div>      
   </div>
   {/user}
</form>
  
  
  
  </div>
</div>
</div>
</body>
</html>


