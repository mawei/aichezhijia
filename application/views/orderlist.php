<!DOCTYPE html>
<html>
{head}
<body>
{header}

<div data-am-widget="list_news" class="am-list-news am-list-news-default">
  <!--列表标题-->
  <div class="am-list-news-bd">
    <ul class="am-list">
    {orders}
      <li class="am-g am-list-item-desced">
        <a onclick="javascript:void(0)" class="am-list-item-hd ">项目:{name} &nbsp&nbsp定金:{price}&nbsp&nbsp预约时间:{date}</a>
        <div class="am-list-item-text">
	   		<p>创建时间：{create_time}</p>
        </div>
      </li>
      {/orders}
    </ul>
  </div>
</div>


{footer}
</body>
</html>


