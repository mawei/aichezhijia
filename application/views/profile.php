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
    </ul>
  </div>
</div>
<form action="<?php echo site_url("index/edit_insurance");?>" method="post" enctype="multipart/form-data" class="am-form" id="form">
<input name="type" type="hidden" id="type" value="">
  <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2
  am-avg-md-3 am-avg-lg-4 am-gallery-default" data-am-gallery="{ pureview: true }">
  <li>
    <div class="am-gallery-item">
        <img src="<?=base_url('assets/uploads/files/{xingshi_image}')?>"
         />
        <h3 class="am-gallery-title">行驶证</h3>
        <div class="am-gallery-desc">
        </div>
    </div>
  </li>
  <li>
    <div class="am-gallery-item">
        <img src="<?=base_url('assets/uploads/files/{jiashi_image}')?>"/>
        <h3 class="am-gallery-title">驾驶证</h3>
        <div class="am-gallery-desc">
        </div>
    </div>
  </li>
    <li>
    <div class="am-gallery-item">
        <img src="<?=base_url('assets/uploads/files/{jiaoqiangxian_image}')?>"/>
    	<h3 class="am-gallery-title">交强险保单照片</h3>
    	<div class="am-gallery-desc">
        </div>
    </div>
  </li>
  <li>
    <div class="am-gallery-item">
        <img src="<?=base_url('assets/uploads/files/{chesunxian_image}')?>"/>
        <h3 class="am-gallery-title">车损险保单照片
      	</h3>
      	<div class="am-gallery-desc">
        </div>
    </div>
  </li>
  
  <li>
    <div class="am-gallery-item">
        <img src="<?=base_url('assets/uploads/files/{ID_front_image}')?>"
         />
        <h3 class="am-gallery-title">身份证正面</h3>
        <div class="am-gallery-desc">
        </div>
    </div>
  </li>
  <li>
    <div class="am-gallery-item">
        <img src="<?=base_url('assets/uploads/files/{ID_back_image}')?>"
         />
        <h3 class="am-gallery-title">身份证反面</h3>
        <div class="am-gallery-desc">
        </div>
    </div>
  </li>
  <li>
    <div class="am-gallery-item">
        <img src="<?=base_url('assets/uploads/files/{bank_image}')?>"
         />
        <h3 class="am-gallery-title">银行理赔卡照片</h3>
        <div class="am-gallery-desc">
        </div>
    </div>
  </li>
</ul>
  {/user}
</form>
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
