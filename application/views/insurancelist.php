<!DOCTYPE html>
<html>
{head}
<script type="text/javascript">
function syncimage(type){
		$("#type").val(type);
		$("#form").submit();
} 
	
</script>
<body>

{header}
<form action="<?php echo site_url("index/edit_insurance");?>" method="post" enctype="multipart/form-data" class="am-form" id="form">
<input name="type" type="hidden" id="type" value="">
  	{records}
  <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2
  am-avg-md-3 am-avg-lg-4 am-gallery-default" data-am-gallery="{ pureview: true }">
  <li>
    <div class="am-gallery-item">
        <img src="<?=base_url('assets/uploads/files/{xingshi_image}')?>"
         />
        <h3 class="am-gallery-title">行驶证</h3>
        <div class="am-gallery-desc">
        <input type="file" onchange="syncimage('xingshi_image');" value="{xingshi_image}" name="xingshi_image" capture="camera" accept="image/*" class="cameraInput" id="cameraInput" >
        </div>
    </div>
  </li>
  <li>
    <div class="am-gallery-item">
        <img src="<?=base_url('assets/uploads/files/{jiashi_image}')?>"/>
        <h3 class="am-gallery-title">驾驶证</h3>
        <div class="am-gallery-desc">
        <input type="file" onchange="syncimage('jiashi_image');" value="jiashi_image" name="jiashi_image" capture="camera" accept="image/*" class="cameraInput" id="cameraInput" >
        </div>
    </div>
  </li>
    <li>
    <div class="am-gallery-item">
        <img src="<?=base_url('assets/uploads/files/{jiaoqiangxian_image}')?>"/>
    	<h3 class="am-gallery-title">交强险保单照片</h3>
    	<div class="am-gallery-desc">
        <input type="file" onchange="syncimage('jiaoqiangxian_image');" value="{jiaoqiangxian_image}" name="jiaoqiangxian_image" capture="camera" accept="image/*" class="cameraInput" id="cameraInput" >
        </div>
    </div>
  </li>
  <li>
    <div class="am-gallery-item">
        <img src="<?=base_url('assets/uploads/files/{chesunxian_image}')?>"/>
        <h3 class="am-gallery-title">车损险保单照片
      	</h3>
      	<div class="am-gallery-desc">
        <input type="file" onchange="syncimage('chesunxian_image');" value="{chesunxian_image}" name="chesunxian_image" capture="camera" accept="image/*" class="cameraInput" id="cameraInput" >
        </div>
    </div>
  </li>
  
  <li>
    <div class="am-gallery-item">
        <img src="<?=base_url('assets/uploads/files/{ID_front_image}')?>"
         />
        <h3 class="am-gallery-title">身份证正面</h3>
        <div class="am-gallery-desc">
        <input type="file" onchange="syncimage('ID_front_image');" value="{ID_front_image}" name="ID_front_image" capture="camera" accept="image/*" class="cameraInput" id="cameraInput" >
        </div>
    </div>
  </li>
  <li>
    <div class="am-gallery-item">
        <img src="<?=base_url('assets/uploads/files/{ID_back_image}')?>"
         />
        <h3 class="am-gallery-title">身份证反面</h3>
        <div class="am-gallery-desc">
        <input type="file" onchange="syncimage('ID_back_image');" value="{ID_back_image}" name="ID_back_image" capture="camera" accept="image/*" class="cameraInput" id="cameraInput" >
        </div>
    </div>
  </li>
  <li>
    <div class="am-gallery-item">
        <img src="<?=base_url('assets/uploads/files/{bank_image}')?>"
         />
        <h3 class="am-gallery-title">银行理赔卡照片</h3>
        <div class="am-gallery-desc">
        <input type="file" onchange="syncimage('bank_image');" value="{bank_image}" name="bank_image" capture="camera" accept="image/*" class="cameraInput" id="cameraInput" >
        </div>
    </div>
  </li>
</ul>
  {/records}
</form>
  
</body>
</html>


