<!DOCTYPE html>
<html>
<head>
	<script src="<?php echo base_url('assets/static/js/jquerymobile/jquery-1.10.2.min.js')?>"></script>
	<link rel="stylesheet" href="<?php echo base_url('assets/static/js/jquerymobile/jquery.mobile-1.4.1.min.css')?>">
	<script src="<?php echo base_url('assets/static/js/jquerymobile/jquery.mobile-1.4.1.min.js')?>"></script>
</head>
<body>

<div data-role="page">
  <div data-role="content">
  	<ul data-role="listview">
  	{records}
	  <li>
	    <h2>{itemname}</h2>
	    <p>数量：{quantity} 价格：{price} 总价：{total} </p>
	   	<p>店铺：{shop}</p>
	  </li>
	  {/records}
	</ul>
  </div>
</div>

</body>
</html>


