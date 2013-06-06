<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><title><?php echo C('site_name');?></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=7" /><link rel="stylesheet" type="text/css" href="__PUBLIC__/statics/css/style.css"/><link rel="stylesheet" type="text/css" href="__PUBLIC__/statics/js/calendar/calendar-blue.css"/><script type="text/javascript" src="__PUBLIC__/statics/js/jquery/jquery-1.4.2.min.js"></script><script type="text/javascript" src="__PUBLIC__/statics/js/jquery/plugins/formvalidator.js"></script><script type="text/javascript" src="__PUBLIC__/statics/js/jquery/plugins/formvalidatorregex.js"></script><script type="text/javascript" src="__PUBLIC__/statics/js/jquery/plugins/jquery.imagePreview.js"></script><script type="text/javascript" src="__PUBLIC__/statics/js/kindeditor/kindeditor-min.js"></script><script type="text/javascript" src="__PUBLIC__/statics/js/calendar/calendar.js"></script><script type="text/javascript" src="__PUBLIC__/statics/js/common.js"></script><script type="text/javascript">	$(document).ready(function(){

		$("#sync_item").click(function(){

            $(this).val("正在同步...");
            $("#error_msg").hide();

		    $.post("<?php echo u('Items/sync');?>", function(data){
				    	$("#error_msg").val('同步失败！！！').hide();
				    	if(data.data == false){
				    		$("#error_msg").val('同步失败！！！').show();
				    	}else{

		                    $("#error_msg")[0].innerHTML = "<b>更新完成，共更新了"+data.data.count+"件商品！</b><div>"+data.data.log+"</div>";
				    		$("#error_msg").show();

		                 }

		        },"json");

		    $(this).attr("disabled","disabled");

		    
		});

		$("#loading").ajaxStart(function(){
			$(this).show();
		});
	
		$("#loading").ajaxStop(function(){
			$(this).hide();
			$("#sync_item").val("开始同步");
			$("#sync_item").removeAttr('disabled');
		});

	});

</script></head><body><br><table><tr><td width=100></td><td><input type="button" name="sync_item" value="开始同步" class="button" id="sync_item" /><img id="loading" src="__PUBLIC__/statics/images/ajax_loading.gif" style="display:none;"/><span name="error_msg" id="error_msg" style="margin:0px 0px;color:red;display:none;"><b>同步失败！！</b></span></td></tr></table></body></html>