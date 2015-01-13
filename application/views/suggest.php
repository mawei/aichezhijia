<!DOCTYPE html>
<html>
{head}
<body>
<div class="container">

<div data-role="page">
  <div data-role="content">
    <form method="post" action="<?php echo site_url("index/suggest");?>" data-ajax="false">
      <input type="text" name="content" id="content" placeholder="意见建议">
      <input type="submit" data-inline="false" value="提交">
    </form>
  </div>
</div>
</div>
</body>
</html>


