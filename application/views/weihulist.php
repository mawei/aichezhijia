<!DOCTYPE html>
<html>
{head}
<body>
{header}

<div data-am-widget="list_news" class="am-list-news am-list-news-default">
  <!--列表标题-->
  <div class="am-list-news-bd">
    <ul class="am-list">
    {records}
      <li class="am-g am-list-item-desced">
        <a onclick="javascript:void(0);" class="am-list-item-hd ">{itemname}</a>
        <div class="am-list-item-text">
        	<p>数量：{quantity} 价格：{price} 总价：{total} </p>
	   		<p>店铺：{shop}</p>
        </div>
      </li>
    {/records}
    </ul>
  </div>
</div>

</body>
</html>


