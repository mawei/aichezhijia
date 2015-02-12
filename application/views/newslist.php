<!DOCTYPE html>
<html>
{head}
<body>
{header}
<div class="container">
<div data-role="page">
  <div data-role="content">
  
  	<div class="list-group">
		<? foreach ($news as $n):?>
			<a href="<?=site_url('index/baodian?id=')?><?=$n['id']?>" class="list-group-item">
		    <h4 class="list-group-item-heading"><?=$n['title']?></h4>
	   		</a>
		<?endforeach;?>
	</div>
  </div>
</div>
</div>
{footer}
</body>
</html>


