<!DOCTYPE html>
<html>
{head}
<body>
{header}
{news}

<div data-am-widget="list_news" class="am-list-news am-list-news-default">
  <!--列表标题-->
  <div class="am-list-news-bd">
    <ul class="am-list">
      <li class="am-g am-list-item-dated">
        <a href="<?=site_url('index/baodian?id=')?>{id}" class="am-list-item-hd ">{title}</a>
        <span class="am-list-date">{create_date}</span>
      </li>
    </ul>
  </div>
</div>

{/news}
{footer}
</body>
</html>


