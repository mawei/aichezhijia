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
        	<p>项目：{name} 定金：({price}/100) 预约时间：{date} </p>
	   		<p>订单创建时间：{create_time}</p>
        </div>
      </li>
    </ul>
  </div>
</div>

{/orders}
{footer}
</body>
</html>


