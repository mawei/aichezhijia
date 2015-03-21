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
        <a class="am-list-item-hd " onclick="javascript:void(0);">上次保养日期</a>
        <span class="am-list-date">{last_baoyang_date}</span>
      </li>
      <li class="am-g am-list-item-dated">
        <a class="am-list-item-hd " onclick="javascript:void(0);">下次保养日期</a>
        <span class="am-list-date">{next_baoyang_date}</span>
      </li>
      <li class="am-g am-list-item-dated">
        <a class="am-list-item-hd " onclick="javascript:void(0);">上次保险日期</a>
        <span class="am-list-date">{last_baoxian_date}</span>
      </li>
      <li class="am-g am-list-item-dated">
        <a class="am-list-item-hd " onclick="javascript:void(0);">下次保险日期</a>
        <span class="am-list-date">{next_baoxian_date}</span>
      </li>
      {/user}
    </ul>
  </div>
</div>
</div>


	<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default" id="">
	  <ul class="am-navbar-nav am-cf am-avg-sm-4">
	    <li>
	      <a href="<?=site_url('index/editservice')?>" class="">
	        <span class="am-icon-location-arrow"></span>
	        <span class="am-navbar-label">修改资料</span>
	      </a>
	    </li>
	  </ul>
	</div>
	{footer}
</body>
</html>
