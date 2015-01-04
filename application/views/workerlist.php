<!DOCTYPE html>
<html>
{head}
<body>

<div data-role="page">
  <div data-role="content">
  	<ul data-role="listview">
  	{records}
	  <li>
	  	<img alt="" src={image} >
	    <h2>{name}</h2>
	    <p><a href="tel:{phone}">电话：{phone}</a></p>
	  </li>
	  {/records}
	</ul>
  </div>
</div>

</body>
</html>


