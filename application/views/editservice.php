<!DOCTYPE html>
<html>
{head}
<body>
{header}
{user}
<form class="am-form am-form-horizontal" method="post" action="<?=site_url('index/editservice')?>">
  <div class="am-form-group">
    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">上次保养日期</label>
    <div class="am-u-sm-10">
      <input type="text" id="doc-ipt-3" name="last_baoyang_date" value="{last_baoyang_date}" placeholder="上次保养日期" data-am-datepicker readonly/>
    </div>
  </div>

  <div class="am-form-group">
    <label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">下次保养日期</label>
    <div class="am-u-sm-10">
      <input type="text" id="doc-ipt-pwd-2" placeholder="下次保养日期" name="next_baoyang_date" value="{next_baoyang_date}" data-am-datepicker readonly/>
    </div>
  </div>
  
  <div class="am-form-group">
    <label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">上次保险日期</label>
    <div class="am-u-sm-10">
      <input type="text" id="doc-ipt-pwd-3" placeholder="上次保险日期" name="last_baoxian_date" value="{last_baoxian_date}" data-am-datepicker readonly/>
    </div>
  </div>
  
  <div class="am-form-group">
    <label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">保险到期日</label>
    <div class="am-u-sm-10">
      <input type="text" id="doc-ipt-pwd-4" placeholder="保险到期日" name="next_baoxian_date" value="{next_baoxian_date}" data-am-datepicker readonly/>
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


