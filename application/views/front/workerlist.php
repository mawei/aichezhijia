<!DOCTYPE html>
<html>
	{head}
	<body>
		<!--  Navigation Bar -->
		{header}
		<!-- Main Page -->
		
		
		<div class="container-fluid noPadding">
					<div class="container text-center">
					
		<table class="table">
		  <tr align="left">
		  	<th align="left"></th>
		  	<th align="left">名字</th>
		  	<th align="left">号码</th>
		  </tr>
		  {workerlist}
		  <tr align="left">
		  	<td align="left"><img alt="" src="{image}"></td>
		  	<td align="left">{name}</td>
		  	<td>{phone}</td>
		  </tr>
		  {/workerlist}
		</table>
		
		</div>
			<!-- Footer -->
		</div>

		<script src="<?=base_url('assets/js/jquery-1.11.0.min.js')?>"></script> 
		<script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
		<script src="<?=base_url('assets/js/myscript.js')?>"></script>
	</body>
</html>