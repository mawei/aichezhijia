<!doctype html>
<html class="no-js">
{head}
<body>
{header}

	<div id="widget-list">
		<ul
			style="transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1); transition-duration: 0ms; transform: translate(0px, 0px) translateZ(0px);"
			class="am-list m-widget-list">
			<li><a href="<?php echo site_url('index/profile') ?>" data-rel="accordion"><img
					class="widget-icon"
					src="http://amazeui.b0.upaiyun.com/src/2.2/widget/accordion/src/accordion.png"
					alt="Accordion"> <span class="widget-name">我的资料</span></a></li>
			<li><a href="<?=site_url('index/insurancelist')?>" data-rel="divider"><img
					class="widget-icon"
					src="http://amazeui.b0.upaiyun.com/src/2.2/widget/accordion/src/accordion.png"
					alt="Divider"> <span class="widget-name">我的保险</span></a></li>
			<li><a href="<?=site_url('index/weihulist')?>" data-rel="duoshuo"><img
					class="widget-icon"
					src="http://amazeui.b0.upaiyun.com/src/2.2/widget/accordion/src/accordion.png"
					alt="Duoshuo"> <span class="widget-name">我的保养</span></a></li>
					
			<li><a href="<?=site_url('index/suggest')?>" data-rel="duoshuo"><img
					class="widget-icon"
					src="http://amazeui.b0.upaiyun.com/src/2.2/widget/accordion/src/accordion.png"
					alt="Duoshuo"> <span class="widget-name">建议意见</span></a></li>
					
					
			<li><a href="<?php echo site_url('index/loginout') ?>" data-rel="figure"><img
					class="widget-icon"
					src="http://amazeui.b0.upaiyun.com/src/2.2/widget/accordion/src/accordion.png"
					alt="Figure"> <span class="widget-name">退出</span></a></li>
			
		</ul>
	</div>
	
{footer}
</body>
</html>


