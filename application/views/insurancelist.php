<!DOCTYPE html>
<html>
{head}
<body>
<div class="container">

<div data-role="page">
{header}
  <div data-role="content">
  
<div class="row">
  	{records}

  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img data-src="{image}" alt="...">
      <div class="caption">
        <h3>保单照片</h3>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img data-src="{ID_front_image}" alt="...">
      <div class="caption">
        <h3>身份证正面</h3>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img data-src="{ID_back_image}" alt="...">
      <div class="caption">
        <h3>身份证反面</h3>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <img data-src="{bank_image}" alt="...">
      <div class="caption">
        <h3>银行理赔卡照片</h3>
      </div>
    </div>
  </div>
  {/records}
</div>
  
  
  </div>
  {footer}
</div>
</div>
</body>
</html>


