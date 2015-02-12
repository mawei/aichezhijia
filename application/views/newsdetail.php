<!DOCTYPE html>
<html>
{head}
<body>
<div class="container">

{header}
<div data-role="page">
  <a href="javascript:history.go(-1);" class="btn btn-primary" ><font style="color: white">返回</font></a>
  <div class="jumbotron">
  <center><h3><?=$news['title']?></h3></center>
  <br/>
  <br/>
  	<p><?=$news['content']?></p>
  </div>
</div>
{footer}
</div>
</body>
</html>


