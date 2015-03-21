<!DOCTYPE html>
<html>
{head}
<body>
{header}
{user}
<form class="am-form am-form-horizontal" method="post" action="<?=site_url('index/editprofile')?>">
  <div class="am-form-group">
    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">名字</label>
    <div class="am-u-sm-10">
      <input type="text" id="doc-ipt-3" name="name" value="{name}" placeholder="输入你的姓名">
    </div>
  </div>

  <div class="am-form-group">
    <label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">电话</label>
    <div class="am-u-sm-10">
      <input type="text" id="doc-ipt-pwd-2" placeholder="请输入你的电话" name="phone" value="{phone} ">
    </div>
  </div>
  
  <div class="am-form-group">
    <label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">车型</label>
    <div class="am-u-sm-10">
      <input type="text" id="doc-ipt-pwd-4" placeholder="请输入你的车型" name="carmodel" value="{carmodel}">
    </div>
  </div>
  
  <div class="am-form-group">
    <label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">轮胎</label>
    <div class="am-u-sm-10">
      <input type="text" id="doc-ipt-pwd-3" placeholder="请输入你的轮胎" name="wheel" value="{wheel}">
    </div>
  </div>
  
  <div class="am-form-group">
    <label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">车牌</label>
    <div class="am-u-sm-10">
      <input type="text" id="doc-ipt-pwd-4" placeholder="请输入你的车牌" name="chepai" value="{chepai}">
    </div>
  </div>

  <div class="am-form-group">
    <div class="am-u-sm-10 am-u-sm-offset-2">
    <button class="am-btn am-btn-secondary" type="submit">提交</button>
    <button type="button" class="am-btn am-btn-secondary" onclick="javascript:history.go(-1);">取消</button>
    </div>
  </div>
</form>
{/user}





{footer}
</body>
</html>


