<!DOCTYPE html>
<html>
{head}
<body>
{header}
{orders}

<div data-am-widget="list_news" class="am-list-news am-list-news-default">
  <!--列表标题-->
  <div class="am-list-news-bd">
    <ul class="am-list">
    
      <li class="am-g am-list-item-dated">
        <a onclick="javascript:void(0)" class="am-list-item-hd ">{product_name}</a>
        <div class="am-list-item-text">
        	<p>数量：{product_count} 价格：{product_price} 总价：{order_total_price} </p>
	   		<p>时间：{order_create_time}</p>
        </div>
      </li>
    </ul>
  </div>
</div>

{/orders}
{footer}
</body>
</html>


