<!DOCTYPE html>
<html>
{head}
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


