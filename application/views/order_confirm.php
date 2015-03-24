<!DOCTYPE html>
<html>
{head}
<script type="text/javascript">
function onBridgeReady(){
	   WeixinJSBridge.invoke(
	       'getBrandWCPayRequest', {
	           "appId" : "{appId}",     //公众号名称，由商户传入     
	           "timeStamp":"{timeStamp}",         //时间戳，自1970年以来的秒数     
	           "nonceStr" : "{nonce_str}", //随机串     
	           "package" : "{package}",     
	           "signType" : "MD5",         //微信签名方式:     
	           "paySign" : "{paySign}" //微信签名 
	       },
	       function(res){  
		       alert(res);   
	           if(res.err_msg == "get_brand_wcpay_request:ok" ) {} 
	           else{
		           alert(res.err_msg);
	           }    // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。 
	       }
	   ); 
	}

$(function(){
	$("#getBrandWCPayRequest").click(function(){
		if (typeof WeixinJSBridge == "undefined"){
			alert('1');
			
			   if( document.addEventListener ){
			       document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
			   }else if (document.attachEvent){
			       document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
			       document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
			   }
			}else{
				alert('1');
				
			   onBridgeReady();
			}
		}
	);
});
</script>
<body>
{header}
<div class="box">
<div data-am-widget="list_news" class="am-list-news am-list-news-default">
  <div class="am-list-news-bd">
    <ul class="am-list">
      <li class="am-g am-list-item-dated">
        <a class="am-list-item-hd " onclick="javascript:void(0);">手机号</a>
        <span class="am-list-date">{phone}</span>
      </li>
      <li class="am-g am-list-item-dated">
        <a class="am-list-item-hd " onclick="javascript:void(0);">车牌号</a>
        <span class="am-list-date">{chepai}</span>
      </li>
      <li class="am-g am-list-item-dated">
        <a class="am-list-item-hd " onclick="javascript:void(0);">车型</a>
        <span class="am-list-date">{carmodel}</span>
      </li>
      <li class="am-g am-list-item-dated">
        <a class="am-list-item-hd " onclick="javascript:void(0);">项目</a>
        <span class="am-list-date">{name}</span>
      </li>
      <li class="am-g am-list-item-dated">
        <a class="am-list-item-hd " onclick="javascript:void(0);">定金</a>
        <span class="am-list-date">{price}</span>
      </li>
      <li class="am-g am-list-item-dated">
        <a class="am-list-item-hd " onclick="javascript:void(0);">日期</a>
        <span class="am-list-date">{date}</span>
      </li>
      <li class="am-g am-list-item-dated">
        <a class="am-list-item-hd " onclick="javascript:void(0);">支付方式</a>
        <span class="am-list-date">微信支付</span>
      </li>
      <li class="am-g am-list-item-dated">
      
		  <div class="am-form-group">
		    <div class="am-u-sm-10">
		      <input type="hidden" id="doc-ipt-3" name="orderid" value="{id}">
		    </div>
		  </div>
		  <div class="am-form-group">
		    <div class="am-u-sm-10 am-u-sm-offset-2">
		    <button class="am-btn am-btn-secondary" type="button" id="getBrandWCPayRequest">确认支付</button>
		    </div>
		  </div>
	  </li>
      </ul>
  </div>
</div>
</div>

<!-- 
	<div data-am-widget="navbar" class="am-navbar am-cf am-navbar-default" id="">
	  <ul class="am-navbar-nav am-cf am-avg-sm-4">
	    <li>
	      <a href="<?=site_url('index/editprofile')?>" class="">
	        <span class="am-icon-location-arrow"></span>
	        <span class="am-navbar-label">修改资料</span>
	      </a>
	    </li>
	  </ul>
	</div>
	 -->
	{footer}
</body>
</html>
