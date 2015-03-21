<!DOCTYPE html>
<html>
{head}
<body>
{header}
<div class="box">
<div data-am-widget="list_news" class="am-list-news am-list-news-default">
  <div class="am-list-news-bd">
    <ul class="am-list">
    {user}
      <li class="am-g am-list-item-dated">
        <a class="am-list-item-hd " onclick="javascript:void(0);">姓名</a>
        <span class="am-list-date">{name}</span>
      </li>
      <li class="am-g am-list-item-dated">
        <a class="am-list-item-hd " onclick="javascript:void(0);">电话</a>
        <span class="am-list-date">{phone}</span>
      </li>
      <li class="am-g am-list-item-dated">
        <a class="am-list-item-hd " onclick="javascript:void(0);">车型</a>
        <span class="am-list-date">{carmodel}</span>
      </li>
      <li class="am-g am-list-item-dated">
        <a class="am-list-item-hd " onclick="javascript:void(0);">轮胎</a>
        <span class="am-list-date">{wheel}</span>
      </li>
      <li class="am-g am-list-item-dated">
        <a class="am-list-item-hd " onclick="javascript:void(0);">车牌</a>
        <span class="am-list-date">{chepai}</span>
      </li>
      {/user}
    </ul>
  </div>
</div>
</div>


	<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default" id="">
	  <ul class="am-navbar-nav am-cf am-avg-sm-4">
	    <li>
	      <a href="<?=site_url('index/editprofile')?>" class="">
	        <span class="am-icon-location-arrow"></span>
	        <span class="am-navbar-label">修改资料</span>
	      </a>
	    </li>
	  </ul>
	</div>
	{footer}
</body>
</html>
