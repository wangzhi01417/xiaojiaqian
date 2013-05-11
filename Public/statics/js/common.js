
$(document).ready(function(){	
	//分类节点	
	$('.expandable').toggle(
		function(){
			$('.sub_'+$(this).attr('id')).hide();
			$(this).attr('src','./PUBLIC/statics/images/tv-expandable.gif');
		},
		function(){
			$('.sub_'+$(this).attr('id')).show();
			$(this).attr('src','./PUBLIC/statics/images/tv-collapsable.gif');
		}
	);

	//全反选
	$("#checkall").click(function(){
		$("input[name='id[]']").each(function(){
			if(this.checked == false){
				this.checked = true;
			}
			else{
				this.checked = false;
			}			
		});
	});
	
	//jquery cookie
	jQuery.cookie = function(name, value, options) {
	    if (typeof value != 'undefined') { // name and value given, set cookie
	        options = options || {};
	        if (value === null) {
	            value = '';
	            options.expires = -1;
	        }
	        var expires = '';
	        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
	            var date;
	            if (typeof options.expires == 'number') {
	                date = new Date();
	                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
	            } else {
	                date = options.expires;
	            }
	            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
	        }
	        var path = options.path ? '; path=' + options.path : '';
	        var domain = options.domain ? '; domain=' + options.domain : '';
	        var secure = options.secure ? '; secure' : '';
	        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
	    } else { // only name given, get cookie
	        var cookieValue = null;
	        if (document.cookie && document.cookie != '') {
	            var cookies = document.cookie.split(';');
	            for (var i = 0; i < cookies.length; i++) {
	                var cookie = jQuery.trim(cookies[i]);
	                // Does this cookie string begin with the name we want?
	                if (cookie.substring(0, name.length + 1) == (name + '=')) {
	                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
	                    break;
	                }
	            }
	        }
	        return cookieValue;
	    }
	};
});


//切换
function SwapTab(name,cls_show,cls_hide,cnt,cur){
    for(var i=1;i<=cnt;i++){
		if(i==cur){
			 $('#div_'+name+'_'+i).show();
			 $('#tab_'+name+'_'+i).attr('class',cls_show);
		}else{
			 $('#div_'+name+'_'+i).hide();
			 $('#tab_'+name+'_'+i).attr('class',cls_hide);
		}
	}
}

//删除操作
function check(){
	var sucin = 0;
	$("input[name='id[]']:checked").each(function(i, n){
		sucin = 1;
	});
	if(sucin == 0){
		alert("请选择要删除的ID");
		return false;
	}else{
		return confirm('确认删除？');
		return true;		
	}
}

//滚动条
$(function(){
	$(":text").addClass('input-text');
});

/**
 * 全选checkbox,注意：标识checkbox id固定为为check_box
 * @param string name 列表check名称,如 uid[]
 */
function selectall(name) {
	if ($("#check_box").attr("checked")==false) {
		$("input[name='"+name+"']").each(function() {
			this.checked=false;
		});
	} else {
		$("input[name='"+name+"']").each(function() {
			this.checked=true;
		});
	}
}

//左侧导航
function left(url){
	leftfra.show(url);
}
function show(url){
	location.href = url;
}
//左侧导航缩放
function showHide(objname){
	$(objname).toggleClass("none"); 
}


