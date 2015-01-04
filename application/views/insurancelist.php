<!DOCTYPE html>
<html>
{head}
<body>

<div data-role="page">
{header}
  <div data-role="content">
  	<ul data-role="listview">
  	{records}
	    <h2>保单照片：</h2>
	    <br/>
	    <img src={image} />
	    <h2>身份证正面：</h2>
	    <br/>
	    <img src={ID_front_image} />
	    <h2>身份证反面：</h2>
	    <br/>
	    <img src={ID_back_image} />
	    <h2>银行理赔卡照片：</h2>
	    <br/>
	    <img src={bank_image} />
	 {/records}
	</ul>
  </div>
  {footer}
</div>

</body>
</html>


