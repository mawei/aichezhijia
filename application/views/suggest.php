<!DOCTYPE html>
<head>
{head}
</head>
<body class="templatemo-bg-gray">
	{header}

	<div class="container">
		<div class="col-md-12">	
	<?php if ($message != ''): ?>
	<p><span class="label label-success">{message}</span></p>
	<?php endif; ?>

    <form method="post" action="<?php echo site_url("index/suggest");?>" data-ajax="false">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
				          <div class="col-md-12">
				            <div class="templatemo-input-icon-container">
				            	<i class="fa fa-pencil-square-o"></i>
				            	<textarea rows="10" cols="50" class="form-control"  name="content" id=""content" placeholder="内容"></textarea>
				            </div>
				          </div>
				        </div>
					</div>					
				</div>	        
		        <div class="form-group">
		          <div class="col-md-12">
		            <div class="checkbox pull-left">
		                <label>
		                </label>
		            </div>
		            <br/>
		            <input type="submit" value="提交" class="btn btn-warning pull-right">		            
		          </div>
		        </div>		    	
		      </form>	
              
		</div>
	</div>
	{footer}
</body>
</html>