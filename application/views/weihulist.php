<!DOCTYPE html>
<html>
{head}
<body>
{header}
<div data-role="page">
  <div data-role="content">
  
  	<div class="list-group">
		{records}
			<a href="#" class="list-group-item">
		    <h4 class="list-group-item-heading">{title}</h4>
		    <p>数量：{quantity} 价格：{price} 总价：{total} </p>
	   		<p>店铺：{shop}</p>
	   		</a>
		{/records}
	</div>
  </div>
</div>
{footer}
</body>
</html>


