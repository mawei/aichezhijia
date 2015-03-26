

<!DOCTYPE html>
<html>
{head}
<body>
{header}

<form class="am-form" method="post" action="<?=site_url('index/submit_order?showwxpaytitle=1')?>">
  <fieldset>

  <div class="am-form-group">
    <label for="doc-ipt-3">预约产品及定金</label>
    	<select class="" name="product">
    	{products}
     	 <option value="{id}">{name}------费用：{price}元</option>
     	 {/products}
    	</select>
  </div>

  <div class="am-form-group">
    <label for="doc-ipt-pwd-2">预约日期</label>
        <input type="text" id="doc-ipt-3" name="date" value="" placeholder="预约日期" data-am-datepicker required readonly/>
  </div>
		    <button type="submit" class="am-btn am-btn-primary am-btn-block">提交订单</button>
  
  </fieldset>
</form>
  
{footer}
</body>
</html>





