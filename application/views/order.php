

<!DOCTYPE html>
<html>
{head}
<body>
{header}

<form class="am-form" method="post" action="<?=site_url('index/submit_order?showwxpaytitle=1')?>">
  <div class="am-form-group">
    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">预约产品及定金</label>
    <div class="am-u-sm-10">
      <div class="am-form-group am-form-select">
    	<select class="" name="product">
    	{products}
     	 <option value="{id}">{name}------费用：{price}元</option>
     	 {/products}
    	</select>
  	  </div>
    </div>
  </div>

  <div class="am-form-group">
    <label for="doc-ipt-pwd-2" class="am-u-sm-2 am-form-label">预约日期</label>
    <div class="am-u-sm-10">
        <input type="text" id="doc-ipt-3" name="date" value="" placeholder="预约日期" data-am-datepicker readonly/>
    </div>
  </div>

  <div class="am-form-group">
    <div class="am-u-sm-10 am-u-sm-offset-2">
      <button type="submit" class="am-btn am-btn-default">提交</button>
    </div>
  </div>
</form>
  
{footer}
</body>
</html>





