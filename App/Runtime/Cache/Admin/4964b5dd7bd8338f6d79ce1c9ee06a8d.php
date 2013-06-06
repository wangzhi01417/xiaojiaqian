<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><title>后台管理_<?php echo C('site_name');?></title><META content="text/html; charset=utf-8" http-equiv=Content-Type><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /><script language="javascript" type="text/javascript" src="__PUBLIC__/statics/js/jquery/jquery-1.4.2.min.js"></script><script type="text/javascript" src="__PUBLIC__/statics/js/common.js"></script><link rel='stylesheet' type='text/css' href='__PUBLIC__/statics/css/admin_style.css'><style>td{ height:22px; line-height:22px}
</style></head><body><div style="float:left;width:49%;"><div  class="cms_info" style="padding:10px 10px;"><table border="0" width="100%" cellpadding="4" cellspacing="1" class="table"><tr class="table_title ver"></tr><?php if(is_array($server_info)): $i = 0; $__LIST__ = $server_info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="ji"><td width="200"><?php echo ($key); ?>：</td><td ><?php echo ($vo); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?></table></div></div><div style="float:left;width:49%;"><div class="cms_info" style="padding:10px 10px;"><table border="0" width="100%" cellpadding="4" cellspacing="1" class="table" id="union_info"><tr class="table_title"><td colspan="2">推广联盟个人信息</td></tr></table></div></div></div><div style="float:left;width:49%;"><div class="news" style="padding:2px 2px;height:300px;"><iframe src="http://www.jdcms.com/push/outsms?&ver=<?php echo C('cms_versions');?>&site=<?php echo C('cms_domain');?>" frameborder="0" scrolling="no"  style="border:none" width="100%" height="100%" ></iframe></div></div><script type="text/javascript">$(document).ready(function(){
	$.post("<?php echo u('Ad/sinfo');?>",function(jsondata){
		var user = jsondata.data.name;
		var site = jsondata.data.domain;
		var versions = jsondata.data.versions;

		$.getJSON("<?php echo C('official_website');?>push/index?union=1&user="+user+"&site="+site+"&ver="+versions+"&callback=?");
		
		$.getJSON("<?php echo C('official_website');?>push/cmsversion?&callback=?",function(data){
			var u = '<td colspan="2">系统环境检测：检测到有最新版本'+data+'，可进行升级&nbsp;&nbsp;<a href="<?php echo U('Index/upgrade');?>">现在升级</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo U('Index/update_database');?>">执行jdcmsV1.3.sql文件</a></td>';
			var d = '<td colspan="2">系统环境检测：您现在使用的是最新版本！<a href="<?php echo U('Index/update_database');?>">执行jdcmsV1.3.sql文件</a></td>';
			if(versions == data){			
				$("body tr.ver").append(d);
			}else{
				$("body tr.ver").append(u);
			}
		},"json");
		
		$.getJSON("<?php echo C('official_website');?>push/union?&callback=?",{user:user,site:site},function(data){
			$.each(data,function(k,v){
				var infoHTML='<tr class="ji"><td width="200">'+k+'：</td><td>'+v+'</td></tr>';			
				$("#union_info").append(infoHTML);
			});
		},"json");
	},"json");
});
</script></body></html>