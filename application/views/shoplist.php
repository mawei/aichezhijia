<!DOCTYPE html>
<html>
{head}
<body>
{header}

<div data-am-widget="list_news" class="am-list-news am-list-news-default">
  <!--列表标题-->
  <div class="am-list-news-bd">
    <ul class="am-list">
    {shops}
      <li class="am-g am-list-item-desced">
        <a onclick="javascript:void(0);" class="am-list-item-hd ">{name}</a>
        <div class="am-list-item-text">
        	<p>地址：{address}</p>
	   		<p>电话：{phone}</p>
        </div>
      </li>
    {/shops}
    </ul>
  </div>
</div>

</body>
</html>


