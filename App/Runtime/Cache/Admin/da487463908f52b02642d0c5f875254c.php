<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><title><?php echo C('site_name');?></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=7" /><link rel="stylesheet" type="text/css" href="__PUBLIC__/statics/css/style.css"/><link rel="stylesheet" type="text/css" href="__PUBLIC__/statics/js/calendar/calendar-blue.css"/><script type="text/javascript" src="__PUBLIC__/statics/js/jquery/jquery-1.4.2.min.js"></script><script type="text/javascript" src="__PUBLIC__/statics/js/jquery/plugins/formvalidator.js"></script><script type="text/javascript" src="__PUBLIC__/statics/js/jquery/plugins/formvalidatorregex.js"></script><script type="text/javascript" src="__PUBLIC__/statics/js/jquery/plugins/jquery.imagePreview.js"></script><script type="text/javascript" src="__PUBLIC__/statics/js/kindeditor/kindeditor-min.js"></script><script type="text/javascript" src="__PUBLIC__/statics/js/calendar/calendar.js"></script><script type="text/javascript" src="__PUBLIC__/statics/js/common.js"></script><style type="text/css">#img_list img{
border: 1px solid rgb(35, 159, 227);
margin-right:5px;
cursor: pointer;

}
#img_list img:hover{
border: 1px solid rgb(0, 102, 153);

}
#img_list input{

  position: relative;
  top:90px;
  left:-30px;
}

}
</style><script type="text/javascript">	$(document).ready(function(){

		$("#collect_item").click(function(){

			var url = $("#collect_url").val();

		  $.post("<?php echo u('Items/collect');?>", { url: url }, function(data){

          // 首先隐藏错误信息
		    	$("#error_msg").val('该商品不存在').hide();

		    	if(data.data == false){
		    		$("#error_msg").val('该商品不存在').show();
		    	}else{
		    		$("#seller_id").val(data.data.seller_id);
		    		$("#title").val(data.data.title);
					$("#url").val(data.data.url);
					$("#tags").val(data.data.tags);
					$("#price").val(data.data.price);
          $("#remark1").val(data.data.remark1);
					$("#item_key").val(data.data.item_key);
					//$("#img").val(data.data.img);
          //**********add by motor start************
          $("#img_list")[0].innerHTML = "";
          var imgs="";
          for(var i=0;i<data.data.img.length;i++){
            $("#img_list")[0].innerHTML += "<img id=\"img_show\" src=\""+data.data.img[i]+"\" width=\"210px\" height=\"210px\"/>";
/*              if(i==0)
                 imgs += data.data.img[i];
              else
                 imgs += “,”data.data.img[i];
              $("#remark2").val(imgs);*/

          }
          var first = $("#img_list").find("img").first();
          first.attr("style","border:2px solid red");
          $("#img").val(first.attr("src"));
          var curObj = first;
          $("#img_list").find("img").each(function(){

            $(this).bind("click",function(){  
               
               if($(this)!=curObj){
                  curObj.removeAttr("style");
                  $(this).attr("style","border:2px solid red");
                  curObj = $(this);

                  $("#img").val($(this).attr("src"));
                }
                else
                  $(this).removeAttr("style");
               
 
          });
          });

          //**********add by motor end************
					$("#author").val(data.data.alias);
					$("#sid option[alias='"+data.data.alias+"']").attr('selected',true);
					//$("#img_show").attr('src', data.data.img).show();
		    	}
		    },"json");
		});	

		$("#loading").ajaxStart(function(){
			$(this).show();
			$("#collect_item").hide();
			$("#submit").hide();
		});
	
		$("#loading").ajaxStop(function(){
			$(this).hide();
			$("#collect_item").show();
			$("#submit").show();
		});
		
		$("#collect_url").change(function(){
			var url = $(this).val();
			$("#url").val(url);
		});
		
		$("#submit").click(function(){
		
			if($("#title").val()==0){
			  	alert('请填写商品名称');
			   	return false;
			}
			if($("#cid").val()==0){
			  	alert('请选择所属分类');
			   	return false;
			}
			if($("#url").val()==0){
			  	alert('请填写链接地址');
			   	return false;
			}
			if($("#price").val()==0){
			  	alert('请填写商品价格');
			   	return false;
			}
			if ($("#info").val().length > 140) {
				alert('长度不得大于140个字符');
			   	return false;
			}
		});	
		//编辑器
		// KE.show({
		// 	id : 'info',
		// 	imageUploadJson : '__PUBLIC__/statics/js/kindeditor/php/upload_json.php',
		// 	fileManagerJson : '__PUBLIC__/statics/js/kindeditor/php/file_manager_json.php',
		// 	allowFileManager : true,
		// 	afterCreate : function(id) {
		// 		KE.event.ctrl(document, 13, function() {
		// 			KE.util.setData(id);
		// 			document.forms['myform'].submit();
		// 		});
		// 		KE.event.ctrl(KE.g[id].iframeDoc, 13, function() {
		// 			KE.util.setData(id);
		// 			document.forms['myform'].submit();
		// 		});
		// 	}
		// });
	});
</script></head><body><form action="<?php echo U('Items/add');?>" method="post" name="myform" id="myform"  enctype="multipart/form-data" style="margin-top:10px;"><div class="pad-10"><div class="col-tab"><ul class="tabBut cu-li"><li id="tab_setting_1" class="on" onclick="SwapTab('setting','on','',3,1);">基本信息</li><li id="tab_setting_2" onclick="SwapTab('setting','on','',3,2);">SEO设置</li><li id="tab_setting_3" onclick="SwapTab('setting','on','',3,3);">其他信息</li></ul><div id="div_setting_1" class="contentList pad-10"><table width="95%" cellspacing="0" class="search-form" align="center"><tbody><tr><td><div class="explain-col">					&nbsp;&nbsp;&nbsp;&nbsp;注：只需要输入商品的详细链接地址即可,如：<font color=red><b>http://detail.tmall.com/item.htm?spm=a1z10.1.3-17827210533.2.nVbrh7&id=13045523063&</b></font></div></td></tr></tbody></table><div name="error_msg" id="error_msg" style="margin:0px 300px;color:red;display:none;"><b>该商品不存在</b></div><table width="100%" cellpadding="2" cellspacing="1" class="table_form"><tr><th width="100">商品地址 :</th><td><input type="text" name="collect_url" id="collect_url" class="input-text" size="60" /><input type="button" name="collect_item" value="获取" class="button" id="collect_item" /><img id="loading" src="__PUBLIC__/statics/images/ajax_loading.gif" style="display:none;"/></td></tr><tbody id="item_body"><tr><th width="100">商品名称 :</th><td><input type="text" name="title" id="title" class="input-text not_null" maxlength="140" size="60" /><b style="padding-left:10px;color:red;">*</b></td></tr><tr><th>所属分类 :</th><td><select name="cid" id="cid" ><option value="0">--选择分类--</option><?php if(is_array($cate_list['parent'])): $i = 0; $__LIST__ = $cate_list['parent'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>" pid="0" ><?php echo ($val["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select><b style="padding-left:10px;color:red;">*</b></td></tr><tr><th>商品图片 :</th><td><div name="img_list" id="img_list"><!-- <img id="img_show" src="" width="210px" height="210px"/> --></div><br /><br/><input type="file" name="upload_img" id="upload_img" class="input-text" size=21 style="height:25px;"/></td></tr><tr><th>来源 :</th><td><select name="sid" id="sid"><option value="0" selected="selected">--选择来源--</option><?php if(is_array($site_list)): $i = 0; $__LIST__ = $site_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>" alias="<?php echo ($val["alias"]); ?>"><?php echo ($val["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?></select></td></tr><tr><th>链接地址 :</th><td><input type="text" name="url" id="url" class="input-text" size="60" /><b style="padding-left:10px;color:red;">*</b></td></tr><tr><th>标签 :</th><td><input type="text" name="tags" id="tags" class="input-text" size="60" /></td></tr><tr><th>价格 :</th><td><input type="text" name="price" id="price" class="input-text" size="20" /><b style="padding-left:10px;color:red;">*</b></td></tr><tr><th>原价格 :</th><td><input type="text" name="remark1" id="remark1" class="input-text" size="20" /><b style="padding-left:10px;color:red;">*</b></td></tr></tbody></table></div><div id="div_setting_2" class="contentList pad-10 hidden"><table width="100%" cellpadding="2" cellspacing="1" class="table_form"><tr><th width="100">Title :</th><td><input type="text" name="seo_title" id="seo_title" class="input-text" size="60"></td></tr><tr><th>Keywords :</th><td><input type="text" name="seo_keys" id="seo_keys" class="input-text" size="60"></td></tr><tr><th>Description :</th><td><textarea name="seo_desc" id="seo_desc" cols="80" rows="8"></textarea></td></tr></table></div><div id="div_setting_3" class="contentList pad-10 hidden"><table width="100%" cellpadding="2" cellspacing="1" class="table_form"><tr><th>分享介绍 :</th><td><textarea style="width:70%;height:200px;visibility:hidden;" id="info" class="input-text" name="info"><?php echo ($items["info"]); ?></textarea></td></tr><tr><th width="100">点击 :</th><td><input type="text" name="hits" id="hits" class="input-text" size="10"></td></tr><tr><th>喜欢 :</th><td><input type="text" name="likes" id="likes" class="input-text" size="10"></td></tr><tr><th>是否焦点 :</th><td><input type="radio" name="is_focus" id="is_focus" class="radio_style" value="1" > &nbsp;是&nbsp;&nbsp;&nbsp;
        		<input type="radio" name="is_focus" id="is_focus" class="radio_style" value="0" checked="checked"> &nbsp;否
             </td></tr></table></div><div class="bk15"><input type="hidden" name="seller_id" id="seller_id" value="" /><input type="hidden" name="item_key" id="item_key" value="" /><input type="hidden" name="img" id="img" value="" /><input type="hidden" name="alias" id="alias" value="" /><!--   <input type="hidden" name="remark2" id="remark2" value="" /> --></div><div class="btn"><input type="submit" value="提交" name="submit" class="button" id="submit"></div></div></div></form></body></html>