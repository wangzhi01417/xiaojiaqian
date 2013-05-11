<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /><title><?php echo ($seo["title"]); ?></title><meta name="keywords" content="<?php echo ($seo["keys"]); ?>" /><meta name="description" content="<?php echo ($seo["desc"]); ?>" /><script src="__PUBLIC__/statics/js/jquery/jquery-1.7.2.min.js"></script><script src="__PUBLIC__/statics/js/ThinkAjax.js"></script><script src="__TMPL__Public/js/common.js?1"></script><link href="__TMPL__Public/css/meta.css" type="text/css" rel="stylesheet"/><link href="__TMPL__Public/css/list.css" type="text/css" rel="stylesheet"/></head><script>$(document).ready(function(){
	//登录
	var id = $.cookie('id');
	var username =$.cookie('name');
	if(id > 0){
		$(".op .info_show").show();
		$(".op .login").hide();
		if(username != ''){
			$('#username').text(username);
		}
	}else{
		$(".op .info_show").hide();
		$(".op .login").show();
	}
	//搜索
	var web_path=$('#web_path').text();
	<?php if(isset($album)): ?>$('#album').addClass('cur').siblings().removeClass('cur');
		$(".selectbox .selected").text('搜专辑');
		$(".selectbox .selected").append('<em></em>');
		$("#search_form").attr('action',web_path+'index.php?a=album&m=Search&g=Home');
		$('#a').val('album');<?php endif; ?>	$(".selectbox").hover(
		function(){
			$(this).find(".selected").addClass('hover');
			$(".selectbox ol").show();
		},
		function(){
			$(this).find(".selected").removeClass('hover');
			$(".selectbox ol").hide();
		}
	)
	
	$(".se").click(function(){
		$(this).addClass('cur').siblings().removeClass('cur');
		var v = $(this).find("a").text();
		$(".selectbox .selected").text('搜'+v);
		$(".selectbox .selected").append('<em></em>');
		$(".selectbox ol").hide();
		var a = $(this).attr('id');
		$("#search_form").attr('action',web_path+'index.php?a='+a+'&m=Search&g=Home');
		$('#a').val(a);
	})
	
	$(".se").hover(function(){
		$(this).addClass('cur').siblings().removeClass('cur');
	})
	var key = $(".txt").attr('placeholder');
	
	$(".txt").focus(function(){
		if($(".txt").val() == key){
			$(this).val('');
		}
	});
	
	$(".txt").blur(function(){
		if($(".txt").val() == ''){
			$(this).val(key);
		}
	});
});
$(function(){
		var nav_top = $('.nav_offsetTop').offset().top; 
		$show_nav = function() {
		var st = $(document).scrollTop();
		if(st > nav_top){
			$("#header_fixed").show();
		}else{
			$("#header_fixed").hide();
		}
	};
	$(window).bind("scroll", $show_nav);
})
$(function(){
	var nav_top = $('.nav_offsetTop').offset().top; 
	var st = $(document).scrollTop();
	if(st > nav_top){
		$("#header_fixed").show();
	}else{
		$("#header_fixed").hide();
	}
})
</script><body id="index"><div id="web_path" style="display:none;"><?php echo C('web_path');?></div><div id="header_fixed"><div class="navWrap clearfix"><div id="nav"><ul class="nav_list clearfix"><li class="shopping"><a href="javascript:;">逛街啦</a></li><li><a class=<?php if('index' == $curpage): ?>cur<?php else: ?>split<?php endif; ?> href="<?php echo C('site_domain');?>">首页</a></li><li class=<?php if('album' == $curpage): ?>cur<?php else: ?>split<?php endif; ?>><a href="<?php echo get_url('index','','album');?>">专辑</a></li><?php if(is_array($p_cate_list)): $i = 0; $__LIST__ = $p_cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vop): $mod = ($i % 2 );++$i;?><li class=<?php if($vop['id'] == $id): ?>cur<?php else: ?>split<?php endif; ?>><a href="<?php echo get_url('index',$vop['id'],'cate');?>"><?php echo ($vop["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul><!-- Baidu Button BEGIN --><div id="bdshare" class="bdshare_b"><img src="__TMPL__Public/img/bdshare.png" width="96"/><a class="shareCount"></a></div><script type="text/javascript" id="bdshare_js" data="type=button" ></script><script type="text/javascript" id="bdshell_js"></script><script type="text/javascript">	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
</script><!-- Baidu Button END --></div></div></div><div id="header"><div class="toolsBar clearfix op"><ul class="info_show" style="display:none"><li class="uname"><a href="<?php echo get_url('index','','user');?>" class="item"><img class="mb_avt r3" onerror="this.src='__PUBLIC__/statics/images/avatar-60.png'" src=<?php if($nav_user_info['img'] == ''): ?>__PUBLIC__/statics/images/avatar-60.png<?php else: echo C('web_path');?>Uploads/avatar_small/<?php echo ($nav_user_info["img"]); endif; ?> /><b id="username"><?php echo ($nav_user_info["name"]); ?></b></a><span></span><p><a href="<?php echo get_url('account','','user');?>">个人设置</a><a href="<?php echo get_url('sns','','user');?>">账号绑定</a><a href="<?php echo get_url('logout','','user');?>">退出</a></p></li><li class="globe_publish"><a class="item" href="<?php echo get_url('release','','user');?>">发表</a></li><li class="myalbum" ><a class="item" href="<?php echo get_url('album','','user');?>">专辑</a></li><li class="myfavs"><a class="item" href="<?php echo get_url('like','','user');?>">喜欢</a></li></ul><ul class="login clearfix"><li class="ways"><a href="<?php echo get_url('register','','user');?>" class="mr5"><span>注册</span></a><a href="<?php echo get_url('login','','user');?>"><span>登录</span></a></li><li class="other_ways"><a href="<?php echo get_url('sinalogin','','user');?>" class="weibo_login">微博登录</a><a href="<?php echo get_url('qqlogin','','user');?>" class="qq_login">QQ登录</a><a href="<?php echo get_url('taobaologin','','user');?>" class="tb_login">淘宝登录</a></li></ul></div><div class="logo-search  clearfix"><h1 class="logo"><a href="<?php echo C('site_domain');?>" class="logo" ><img src="__TMPL__Public/img/logo.png" width="146" height="47" class="png_bg"/></a></h1><div id="searchBar"><div class="selectbox"><span class="selected">搜宝贝<em></em></span><ol><li class="se cur" id="index"><a href="javascript:;">宝贝</a></li><li class="se" id="album"><a href="javascript:;">专辑</a></li><li class="lastli"></li></ol></div><form target="_blank" action="<?php echo get_url('index','','search');?>" id="search_form"><input id="a" name="a" type="hidden" value="index"><input name="m" type="hidden" value="Search"><input name="g" type="hidden" value="Home"><input id="keywd" class="txt" name="keywords" type="text" value="<?php if(isset($keywords)): echo ($keywords); else: echo C('default_kw'); endif; ?>" placeholder="<?php echo C('default_kw');?>" autoComplete= "Off"/><input class="btn" type="submit" value=""/></form></div></div><div class="navWrap clearfix"><div id="nav" class="nav_offsetTop"><ul class="nav_list clearfix"><li class="shopping"><a href="javascript:;">逛街啦</a></li><li><a class=<?php if('index' == $curpage): ?>cur<?php else: ?>split<?php endif; ?> href="<?php echo C('site_domain');?>">首页</a></li><li class=<?php if('album' == $curpage): ?>cur<?php else: ?>split<?php endif; ?>><a href="<?php echo get_url('index','','album');?>">专辑</a></li><?php if(is_array($p_cate_list)): $i = 0; $__LIST__ = $p_cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vop): $mod = ($i % 2 );++$i;?><li class=<?php if($vop['id'] == $id): ?>cur<?php else: ?>split<?php endif; ?>><a href="<?php echo get_url('index',$vop['id'],'cate');?>"><?php echo ($vop["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul><!-- Baidu Button BEGIN --><div id="bdshare" class="bdshare_b"><img src="__TMPL__Public/img/bdshare.png" width="96"/><a class="shareCount"></a></div><script type="text/javascript" id="bdshare_js" data="type=button" ></script><script type="text/javascript" id="bdshell_js"></script><script type="text/javascript">	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
</script><!-- Baidu Button END --><?php if(('index' == $curpage) OR ($cate_name != '')): ?><!-- OR ('album' eq $curpage)--><div id="nav_sub"><ul class="album_new"><li><a class="clearfix" href="<?php echo get_url('index','','album');?>"><strong>最新专辑</strong><span></span></a></li></ul><ul class="items_num"><li><a class="clearfix" href="javascript:;"><strong>单品：<?php echo ($itemCount); ?></strong><em></em></a></li></ul><ul class="cate_show"><?php if(is_array($p_cate_list)): $i = 0; $__LIST__ = $p_cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vop): $mod = ($i % 2 );++$i;?><li class="<?php if($vop['id'] == $id): ?>curr<?php endif; ?>"><a class="clearfix" href="<?php echo get_url('index',$vop['id'],'cate');?>"><strong><img src="<?php echo C('web_path').ltrim($vop['img'],'/'); ?>" width="20" height="20"><?php echo ($vop["name"]); ?></strong><span></span></a><!-- <p><?php if(is_array($vop['tags'])): $i = 0; $__LIST__ = $vop['tags'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voTag): $mod = ($i % 2 );++$i;?><a href="<?php echo get_url('tag',$voTag['id'],'cate');?>" class="cate_word"><?php echo ($voTag["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?></p>--></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><?php endif; ?></div></div></div><div id="head_bottom"></div><div class="main"><div class="con_bannerWrap"><div class="radius-top"><span class="hl"></span><span class="hr"></span></div><div class="con_banner clearfix"><ul class="cate_cont_show"><?php if(is_array($snav)): $i = 0; $__LIST__ = $snav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vsn): $mod = ($i % 2 );++$i;?><li><h2><strong><?php echo ($vsn["name"]); ?></strong><img src="<?php echo C('web_path').ltrim($vsn['img'],'/'); ?>" title="<?php echo ($vsn["name"]); ?>" alt="<?php echo ($vsn["name"]); ?>"/></h2><p><?php if(is_array($vsn['tags'])): $i = 0; $__LIST__ = array_slice($vsn['tags'],0,12,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vsnt): $mod = ($i % 2 );++$i;?><a href="<?php echo get_url('tag',$vsnt['id'],'cate');?>" class="<?php if($vsnt['id'] == $tag_id): ?>c<?php elseif(($vsnt['id']%5) == '0'): ?>h<?php endif; ?>"><?php echo ($vsnt["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?></p></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><div class="radius-bottom"><span class="hl"></span><span class="hr"></span></div></div><?php if(get_ad(19) != ''): ?><center><div style="width:960px;height:90px;overflow:hidden;margin-top:15px;"><?php echo get_ad(19);?></div></center><?php endif; ?><div class="cate_tit"><div id="cate_name" style="display:none;"><?php echo ($cate_name); ?></div><div id="tag_name" style="display:none;"><?php echo ($tag_name); ?></div><h1><?php if(isset($tag_name)): echo ($tag_name); else: echo ($cate_name); endif; ?></h1><ul><li class="sort"><span>排序：</span><p  class="t_sortby"><a name="new" class="l <?php if($sortby == 'new'): ?>curr<?php endif; ?>" href="<?php echo get_url(ACTION_NAME,$id,'cate','new',$price);?>" rel="nofollow">最新</a><a name="hot" class="r <?php if($sortby == 'hot'): ?>curr<?php endif; ?>" href="<?php echo get_url(ACTION_NAME,$id,'cate','hot',$price);?>" rel="nofollow">最热</a></p></li><li class="sort"><span>价格：</span><p  class="t_price"><a name="0" class="l <?php if($price == '0'): ?>curr<?php endif; ?>" rel="nofollow" href="<?php echo get_url(ACTION_NAME,$id,'cate',$sortby,'0');?>">全部</a><a name="100" class="m <?php if($price == '100'): ?>curr<?php endif; ?>" rel="nofollow" href="<?php echo get_url(ACTION_NAME,$id,'cate',$sortby,'100');?>" title="100一下">100元</a><a name="200" class="m <?php if($price == '200'): ?>curr<?php endif; ?>" rel="nofollow" href="<?php echo get_url(ACTION_NAME,$id,'cate',$sortby,'200');?>" title="101-200元">200元</a><a name="500" class="m <?php if($price == '500'): ?>curr<?php endif; ?>" rel="nofollow" href="<?php echo get_url(ACTION_NAME,$id,'cate',$sortby,'500');?>" title="201-500元">500元</a><a name="501" class="r <?php if($price == '501'): ?>curr<?php endif; ?>" rel="nofollow" href="<?php echo get_url(ACTION_NAME,$id,'cate',$sortby,'501');?>" title="500以上">更高</a></p></li></ul></div><style>#spread div p a{
	color: #AAAAAA;
    font-style: normal;
    width: 175px;
}
</style><script type="text/javascript" src="__PUBLIC__/statics/js/jquery.masonry.min.js"></script><script type="text/javascript">$(document).ready(function(){
	/**
	 *推广商品替换
	 */
	//容器
	var $container = $('.content');
	//当前页数
	var nowPage = parseInt($(".nowPage").text());
	//获取推广状态
	var spread_status=$("#spread_status").text();
	//推广标识
	var sign = true;
	//不是第一页不推广
	if(nowPage > '1' || spread_status == '0'){
		sign = false;
	}
	if(sign == true){

		//获取图片高度
		$.each($(".pic"),function(){
			var imgl = new Image();
			imgl.src = $(this).find(".item_img").attr('src');

			var heightl;
			heightl = (225/imgl.width)*imgl.height;
			
			$(this).css('height',heightl);
			$(this).find('.item_img').attr('height',heightl);
		});
		
		//执行超时检查
        setTimeout(function(){
            checkajax();
        },100);

		//获取位置
		var spread_position=$("#spread_position").text();
		//插入推广商品
		var itemHTML='<div class="col co xiayijian" id="spread"></div>';
		if(nowPage){
			var s='.co:eq('+(spread_position-1)+')';
			var t=$(s);
			if(t[0]){
				$(s).before(itemHTML);
			}else{
				$container.append(itemHTML);
			}
		}else{
			$container.append(itemHTML);
		}
		var item_info=$("#spread_info").html();
		if(item_info.match('div') || item_info.match('DIV')){
			document.getElementById("spread").innerHTML=item_info;
		}else{
			$(".xiayijian").remove();
		}

		function checkajax(){
			//瀑布流布局	
			$container.masonry({
				itemSelector : '.col',
				columnWidth : 120
			});
        }
	}else{
		//获取图片高度
		$.each($(".pic"),function(){
			var imgl = new Image();
			imgl.src = $(this).find(".item_img").attr('src');

			var heightl;
			heightl = (225/imgl.width)*imgl.height;

			$(this).css('height',heightl);
			$(this).find('.item_img').attr('height',heightl);
		}); 
		//瀑布流布局
		$container.masonry({
			itemSelector : '.col',
			columnWidth : 120
		});
	}

	/**
	 *加载数据
	 */
	//锁定标识
	var key = true;
	//加载计数
	var i= 1;	
	//窗口绑定滚动事件
	$(window).bind("scroll",function() {
		//高度参数
		var l=$(document).scrollTop() + $(window).height();
		var h=$(document).height();
	    //判断窗口的滚动条是否接近页面底部，自定义500
	    if (l > h - 500 && l < h && key==true) {
	        key = false;
			//获取url
			var url = $("#url").text();
			if(!url){
				return false;
			}
			//获取id
			var id = $("#id").text();
			//获取排序
			var sortby = $(".t_sort .curr").attr('name');
			//获取价格
			var price = $(".t_price .curr").attr('name');
			//请求页数
			var p = (nowPage-1)*5+i+1;
			//总记录数
			var totalRows = parseInt($(".totalRows").text());
			if(totalRows <= ((nowPage-1)*100)+20 || !p){
				return false;
			}
	  		if (i < 5) {
	  			//显示加载图标，隐藏分页
				$(".loading").show();
				$(".page").hide();
	  			//如果存在的话，用ajax获取数据
	  			$.ajax({
	  				type: "get",
	  				url: url,
	  				data: {id:id, sortby:sortby, price:price, p:p},
	  				success: function(data) {
	  					//隐藏加载图标，显示分页
	  					$(".loading").hide();
	  					$(".page").show();
	  					key = true;
	  					//重新加载js
	  					$.ajax({
	  						url: "__TMPL__Public/js/common.js",
	  						dataType: "script",
	  						global: false
	  					});  					
	  					//获取总页数
	  					var totalPages = $(data).find(".totalPages").text();
	  					//将返回的数据进行处理，挑选出class是co的内容块
	  					var $res = $(data).find(".co");
	  					//获取图片高度
	  					$.each($res.find(".pic"),function(){
	  						var imgl = new Image();
	  						imgl.src = $(this).find(".item_img").attr('src');

	  						var heightl;
	  						heightl = (225/imgl.width)*imgl.height;

	  						$(this).css('height',heightl);
	  						$(this).find('.item_img').attr('height',heightl);
	  					});
						//替换图片src								
	  					$.each($res.find(".item_img"),function(){
		  					$(this).attr('src1',$(this).attr('src'));
		  					$(this).removeAttr('src');
	  					})	
	  					//结合masonry插件，将内容append进ID是content的内容块中
	  					$container.append($res.fadeIn()).masonry('appended', $res);
	  					//加载图片
	  					$.each($res.find(".item_img"),function(){
	  						$(this).attr('src',$(this).attr('src1'));
	  						$(this).removeAttr('src1');
	  					})
	  					//加载4页后显示分页
	  					if (((nowPage-1)*5+i+1) < totalPages) {
	  						i++;
	  					} else {
	  						i=5;
	  					}
	  				}
	  			})
	  		}
	    }
	});
});
</script><div id="spread_status" style="display:none;"><?php echo C('spread_status');?></div><div id="spread_position" style="display:none;"><?php echo C('spread_position');?></div><div id="spread_info" style="display:none;"><?php echo ($spread_info); ?></div><div class="content"><?php if((MODULE_NAME != 'Search') AND (MODULE_NAME != 'Shop')): if($shop_list): ?><div class="col" style="background:white"><h2 class="dianpuh2">推荐店铺</h2><ol class="brands_wrap"><?php if(is_array($shop_list)): $i = 0; $__LIST__ = array_slice($shop_list,0,12,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voShop): $mod = ($i % 2 );++$i;?><li class="magic_brand_list"><a title="<?php echo ($voShop["name"]); ?>" href="<?php echo get_url('index',$voShop['id'],'shop');?>"><img alt="<?php echo ($voShop["name"]); ?>" data-lazyload="<?php echo ($voShop["img"]); ?>" src=<?php if($voShop['img']): ?>"<?php echo ($voShop["img"]); ?>"<?php else: ?>__TMPL__Public/img/undefined.jpg<?php endif; ?>></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ol></div><?php endif; endif; if(is_array($items_list)): $i = 0; $__LIST__ = $items_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voItems): $mod = ($i % 2 );++$i;?><div class="col co"><div class="pic bgload"><a class="item_url" target="_blank" href="<?php echo get_url('index',$voItems['id'],'item');?>" title="<?php echo ($voItems["title"]); ?>"><img class="item_img" alt="<?php echo ($voItems["title"]); ?>" <?php if($voItems['img'] != ''): ?>src="<?php echo (get_img($voItems["img"],210)); ?>"<?php else: ?>src="__TMPL__Public/img/undefined.jpg"<?php endif; ?> width="225" /></a><a class="add_to_album" href="<?php echo get_url('addAlbum',$voItems['id'],'album');?>" target="_blank"><span class="add_to_album">加入专辑</span></a><span class="price item_price">￥<?php echo ($voItems["price"]); ?></span></div><p class="btn"><span class="favaImg"><em class="s1 <?php if($likes[$voItems['id']] == 1): ?>favored<?php endif; ?>" item_id="<?php echo ($voItems['id']); ?>"><?php if($likes[$voItems['id']] == 1): ?>已喜欢<?php else: ?>喜欢一下<?php endif; ?></em><a href="<?php echo get_url('index',$voItems['id'],'item');?>" target="_blank"><i class="l" id="<?php echo ($voItems['id']); ?>"><?php echo ($voItems["likes"]); ?></i><i class="r"></i></a></span><input type="hidden" name="" id="like_post_action" value="<?php echo get_url('createlike','','user');?>"><input type="hidden" name="" id="like_post_location" value="<?php echo get_url('login','','user');?>"><a class="creply" href="<?php echo get_url('index',$voItems['id'],'item');?>" target="_blank"><em>评论</em>(<i><?php echo ($voItems["comments"]); ?></i>)</a></p><p class="fava"><span><a class="avt" target="_blank" href="<?php echo get_url('index',$voItems['uid'],'user');?>"><img onerror="this.src='__PUBLIC__/statics/images/avatar-60.png'" src=<?php if($voItems['userimg'] != ''): ?>"<?php echo C('web_path');?>Uploads/avatar_small/<?php echo ($voItems["userimg"]); ?>"<?php else: ?>"__PUBLIC__/statics/images/avatar-60.png"<?php endif; ?> style="width:24px;height:24px;"/></a><em><a target="_blank" href="<?php echo get_url('index',$voItems['uid'],'user');?>" class="name"><?php echo ($voItems["username"]); ?></a>分享于<?php echo (date('Y年m月d日 H:i:s',$voItems["add_time"])); ?></em></span><?php if(isset($voItems['ablum_info'])): ?><span><a class="avt" target="_blank" href="<?php echo get_url('index',$voItems['ablum_info']['uid'],'user');?>"><img onerror="this.src='__PUBLIC__/statics/images/avatar-60.png'" src=<?php if($voItems['ablum_info']['img'] != ''): ?>"<?php echo C('web_path');?>Uploads/avatar_small/<?php echo ($voItems["ablum_info"]["img"]); ?>"<?php else: ?>"__PUBLIC__/statics/images/avatar-60.png"<?php endif; ?> style="width:24px;height:24px;"/></a><em><a target="_blank" href="<?php echo get_url('index',$voItems['ablum_info']['uid'],'user');?>" class="name"><?php echo ($voItems["ablum_info"]["uname"]); ?></a>加入<a href="<?php echo get_url('albumDetail',$voItems['ablum_info']['id'],'user');?>" target="_blank" class="clrff8"><?php echo ($voItems["ablum_info"]["title"]); ?></a></em></span><?php endif; if(isset($voItems['commnets_info'])): ?><span><a class="avt" target="_blank" href="<?php echo get_url('index',$voItems['commnets_info']['uid'],'user');?>"><img onerror="this.src='__PUBLIC__/statics/images/avatar-60.png'" src=<?php if($voItems['commnets_info']['img'] != ''): ?>"<?php echo C('web_path');?>Uploads/avatar_small/<?php echo ($voItems["commnets_info"]["img"]); ?>"<?php else: ?>"__PUBLIC__/statics/images/avatar-60.png"<?php endif; ?> style="width:24px;height:24px;"/></a><em><a target="_blank" href="<?php echo get_url('index',$voItems['commnets_info']['uid'],'user');?>" class="name"><?php echo ($voItems["commnets_info"]["name"]); ?>：</a><?php echo ($voItems["commnets_info"]["info"]); ?></em></span><?php endif; ?></p><i class="shadow"></i></div><?php endforeach; endif; else: echo "" ;endif; ?></div><div class="loading" style="width:32px;height:32px;margin:0 auto;display:none;"><img src="__PUBLIC__/statics/images/loading_d.gif"></div><div class="page"><?php echo ($page); ?></div></div><?php if(get_ad(20) != ''): ?><br><center><div style="width:960px;height:90px;overflow:hidden;"><?php echo get_ad(20);?></div></center><?php endif; ?><div id='url' style="display:none;"><?php echo C('web_path');?>index.php?a=<?php echo ACTION_NAME;?>&m=Public&g=Home</div><div id='id' style="display:none;"><?php echo ($_GET['id']); ?></div></div><div class="footerWrap"><div class="radius-top"><span class="hl"></span><span class="hr"></span></div><div id="footer"><div class="fl"><dl style="margin-left:30px;"><dt>网站</dt><dd><ul><?php if(is_array($p_cate_list)): $i = 0; $__LIST__ = $p_cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cval): $mod = ($i % 2 );++$i;?><li>·<a href="<?php echo get_url('index',$cval['id'],'cate');?>" target="_blank"><?php echo ($cval["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></dd></dl><dl><dt>网站相关</dt><dd style="margin-bottom: 18px;"><ul><dd><a href="__PUBLIC__/statics/sitemap.html" target="_blank">网站地图</a></dd><dd><a href="__PUBLIC__/statics/sitemap.xml" target="_blank">sitemap</a></dd><dd><?php echo strclean(C('site_icp')); ?></dd><dd><?php echo strclean(C('statistics_code')); ?></dd></ul></dd></dl></div><div class="fr"><dl class="followus"><dt>关注我们</dt><dd><ul><dd><?php echo strclean(C('follow_us')); ?></dd><dd><?php echo strclean(C('follow_us2')); ?></dd><dd><?php echo strclean(C('follow_us3')); ?></dd><dd><?php echo strclean(C('follow_us4')); ?></dd><dd><?php echo strclean(C('follow_us5')); ?></dd><dd><?php echo strclean(C('follow_us6')); ?></dd></ul></dd></dl><dl><dt>友情链接</dt><dd><ul><?php if(is_array($linkList)): $i = 0; $__LIST__ = $linkList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li>·<a href="<?php echo ($val["url"]); ?>" target="_blank"><?php echo ($val["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></dd></dl></div><p class="cr"><?php echo strclean(C('record')); ?></p></div><div class="radius-bottom"><span class="hl"></span><span class="hr"></span></div></div><div class="back2top"><a href="javascript:;" title="返回顶部"></a></div></body></html><script>/*返回顶部*/
$(function() {
		$(".back2top").click(function() {
			$("html, body").animate({ scrollTop: 0 }, 120);
	}), $backToTopFun = function() {
		var st = $(document).scrollTop(), winh = $(window).height();
		(st > 0)? $(".back2top").show(): $(".back2top").hide();    
		//IE6下的定位
		if (!window.XMLHttpRequest) {
			$(".back2top").css("top", st + winh - 166);    
		}
	};
	$(window).bind("scroll", $backToTopFun);
	$(function() { $backToTopFun(); });
});
$(function(){
	$(".info_show .uname").hover(function(){
		$(".info_show .uname p").show();
	},function(){
		$(".info_show .uname p").hide();
	})
	$(".info_show .msg_notice").hover(function(){
		$(".info_show .msg_notice p").show();
	},function(){
		$(".info_show .msg_notice p").hide();
	})
/*	$("#searchBar .selectbox").hover(function(){
		$("#searchBar .selectbox ol").show();
	},function(){
		$("#searchBar .selectbox ol").hide();
	})*/
})
</script>