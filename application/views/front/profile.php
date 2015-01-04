<!DOCTYPE html>
<html>
	{head}
	<body>
		<!--  Navigation Bar -->
		{header}
		<!-- Main Page -->
		
		
		<div class="container-fluid noPadding">
					<div class="container text-left">
		<div style="float: right"><a href="<?php echo site_url('index/loginout') ?>"><font color="red">退出</font></a></div>
		
		<table class="table table-striped">
		  <thead>我的维修列表</thead>
		  <tr>
		  	<th align='left'>项目</th>
		  	<th align='left'>数量</th>
		  	<th align='left'>价格</th>
		  	<th align='left'>总价</th>
		  	<th align='left'>店铺</th>
		  </tr>
		  {weihus}
		  <tr>
		  	<td align='left'>{itemname}</td>
		  	<td align='left'>{quantity}</td>
		  	<td align='left'>{price}</td>
		  	<td align='left'>{total}</td>
		  	<td align='left'>{shop}</td>
		  </tr>
		  {/weihus}
		</table>
		
		</div>
			<div class="container textstyle">
				<div class="row text-left latestProjects">
					
					<div class="col-md-4 col-sm-6">
						<a href="http://dribbble.com/shots/1210363-Weather-App-Washing-Machine-iOS7" >
						<img  src="<?=$insurances['image']?>">
												</a>
						<p>银行理赔卡照片</p>
					</div>
					
					<div class="col-md-4 col-sm-6">
						<a href="http://dribbble.com/shots/202313-British-Tea-Cup" >
							<img src="<?=$insurances['ID_front_image']?>">
												</a>
						<p>身份证正面</p>
					</div>

					<div class="col-md-4 col-sm-12">
						<a href="http://dribbble.com/shots/606745-In-app-Visual-Data" >
							<img src="<?=$insurances['ID_back_image']?>">
						<p>身份证反面</p>
					</div>
					<div class="col-md-4 col-sm-12">
						<a href="http://dribbble.com/shots/606745-In-app-Visual-Data" >
							<img src="<?=$insurances['ID_back_image']?>">
						<p>银行理赔卡</p>
					</div>
				</div>
			</div>
			<!-- Footer -->

		<script src="<?=base_url('assets/js/jquery-1.11.0.min.js')?>"></script> 
		<script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
		<script src="<?=base_url('assets/js/myscript.js')?>"></script>
	</body>
</html>