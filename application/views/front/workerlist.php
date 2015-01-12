<!DOCTYPE html>
<html>
	{head}
	<body>
		<!--  Navigation Bar -->
		{header}
		<!-- Main Page -->
		
		
		<div class="container-fluid noPadding">
					
		<div class="list-group">
		{workerlist}
		  <a href="#" class="list-group-item">
		  <span></span>
		    <h4 class="list-group-item-heading">{name}</h4>
		    <p class="list-group-item-text">联系方式：{phone}</p>
		  </a>
		{/workerlist}
		</div>
		
			<!-- Footer -->
		</div>

		<script src="<?=base_url('assets/js/jquery-1.11.0.min.js')?>"></script> 
		<script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
		<script src="<?=base_url('assets/js/myscript.js')?>"></script>
	</body>
</html>