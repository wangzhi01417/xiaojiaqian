<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /><title><?php echo ($seo["title"]); ?></title><meta name="keywords" content="<?php echo ($seo["keys"]); ?>" /><meta name="description" content="<?php echo ($seo["desc"]); ?>" /><script src="__PUBLIC__/statics/js/jquery/jquery-1.7.2.min.js"></script><script src="__PUBLIC__/statics/js/ThinkAjax.js"></script><script src="__TMPL__Public/js/common.js?1"></script><link href="__TMPL__Public/css/meta.css" type="text/css" rel="stylesheet"/><link href="__TMPL__Public/css/index.css" type="text/css" rel="stylesheet"/></head><script>$(document).ready(function(){
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
</script><!-- Baidu Button END --><?php if(('index' == $curpage) OR ($cate_name != '')): ?><!-- OR ('album' eq $curpage)--><div id="nav_sub"><ul class="album_new"><li><a class="clearfix" href="<?php echo get_url('index','','album');?>"><strong>最新专辑</strong><span></span></a></li></ul><ul class="items_num"><li><a class="clearfix" href="javascript:;"><strong>单品：<?php echo ($itemCount); ?></strong><em></em></a></li></ul><ul class="cate_show"><?php if(is_array($p_cate_list)): $i = 0; $__LIST__ = $p_cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vop): $mod = ($i % 2 );++$i;?><li class="<?php if($vop['id'] == $id): ?>curr<?php endif; ?>"><a class="clearfix" href="<?php echo get_url('index',$vop['id'],'cate');?>"><strong><img src="<?php echo C('web_path').ltrim($vop['img'],'/'); ?>" width="20" height="20"><?php echo ($vop["name"]); ?></strong><span></span></a><!-- <p><?php if(is_array($vop['tags'])): $i = 0; $__LIST__ = $vop['tags'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voTag): $mod = ($i % 2 );++$i;?><a href="<?php echo get_url('tag',$voTag['id'],'cate');?>" class="cate_word"><?php echo ($voTag["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?></p>--></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div><?php endif; ?></div></div></div><div id="head_bottom"></div><div class="main"><div class="con_bannerWrap"><div class="radius-top"><span class="hl"></span><span class="hr"></span></div><div class="con_banner clearfix"><div id="slide_img"><ul class="bgload"><?php if(is_array($index_share_item)): $i = 0; $__LIST__ = $index_share_item;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valsi): $mod = ($i % 2 );++$i;?><li style="display:block"><!--style="display:block"--><a target="_blank" href="<?php echo get_url('index',$valsi['id'],'item');?>" title="<?php echo ($valsi["title"]); ?>"><img src=<?php if($valsi['remark1'] != ''): ?>"<?php echo ($valsi["remark1"]); ?>"<?php else: ?>"<?php echo (get_img($valsi["img"],500)); ?>"<?php endif; ?>/></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul><ol><?php if(is_array($index_share_item)): $i = 0; $__LIST__ = $index_share_item;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valsi): $mod = ($i % 2 );++$i;?><li><a target="_blank" href="<?php echo get_url('index',$valsi['uid'],'user');?>"><img onerror="this.src='__PUBLIC__/statics/images/avatar-60.png'" src=<?php if($valsi['uimg'] == ''): ?>__PUBLIC__/statics/images/avatar-60.png<?php else: echo C('web_path');?>Uploads/avatar_small/<?php echo ($valsi["uimg"]); endif; ?>  alt="<?php echo ($valsi["name"]); ?>"/><span><?php echo ($valsi["name"]); ?></span></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ol></div><div id="user_active"><!-- 登录后 --><?php if(isset($uid)): ?><div class="user_info"><a class="avatar" href="<?php echo get_url('index','','user');?>" target="_blank"><img class="r3" onerror="this.src='__PUBLIC__/statics/images/avatar-60.png'" src=<?php if($nav_user_info['img'] == ''): ?>__PUBLIC__/statics/images/avatar-60.png<?php else: echo C('web_path');?>Uploads/avatar_small/<?php echo ($nav_user_info["img"]); endif; ?> alt="<?php echo ($nav_user_info["name"]); ?>"/></a><p><a class="username" href="<?php echo get_url('index','','user');?>" target="_blank"><?php echo ($nav_user_info["name"]); ?></a><span class="feed_link"><?php echo ($nav_user_info["address"]); ?><!--<a href="/molishe/me?f=cn20121018modouSY" target="_blank" class="modou pr5">0</a>--></span><span class="feed_link">欢迎回来<?php echo C("site_name"); if($nav_user_info['img'] == ''): ?>，先<a href="<?php echo get_url('img','','user');?>" target="_blank">设置个漂亮头像</a>吧。<?php endif; ?></span></p></div><ul class="user_record"><li class="clearfix"><a href="<?php echo get_url('index','','user');?>" target="_blank" class="top_active_btn"><em>我的首页</em></a></li><li class="clearfix"><a href="<?php echo get_url('share','','user');?>" target="_blank" class="top_active_btn"><em>我的分享</em></a></li><li class="clearfix"><a href="<?php echo get_url('like','','user');?>" target="_blank" class="top_active_btn"><em>我的喜欢</em></a></li><li class="clearfix"><a href="<?php echo get_url('album','','user');?>" target="_blank" class="top_active_btn"><em>我的专辑</em></a></li></ul><?php else: ?><!-- 登录前 --><div class="user_login"><a href="<?php echo get_url('register','','user');?>" class="register_btn" title="立即注册">立即注册</a><a href="<?php echo get_url('sinalogin','','user');?>" class="login_sina_btn" title="使用sina微博登录">使用sina微博登录</a><a href="<?php echo get_url('qqlogin','','user');?>" class="login_qq_btn" title="使用qq登录">使用qq登录</a><a href="<?php echo get_url('taobaologin','','user');?>" class="login_taobao_btn" title="使用淘宝登录">使用淘宝登录</a></div><?php if(($article_list) AND (C('article_show') == '1')): ?><ul class="article"><?php if(is_array($article_list)): $i = 0; $__LIST__ = $article_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voArt): $mod = ($i % 2 );++$i;?><li class="clearfix"><a class="img" href=<?php if($voArt['url']): echo ($voArt["url"]); else: ?>"<?php echo get_url('detail',$voArt['id'],'article');?>"<?php endif; ?> target="_blank"><?php echo (msubstr($voArt["title"],0,15,'utf-8',false)); ?></a><span class="top_active_btn">[<?php echo (date('Y-m-d',$voArt["add_time"])); ?>]</span></li><?php endforeach; endif; else: echo "" ;endif; ?></ul><?php else: ?><form id="index_login"><fieldset class="l"><input  type="text" value="请输入用户名" placeholder="请输入用户名" class="txt" id="indexUname"/><input type="password" class="txt" id="indexPwd"/></fieldset><fieldset class="r"><p class="sub"><input type="button" id="indexlLoginBtn" style="cursor:pointer" loginBtn_post_action="<?php echo get_url('loginAction','','user');?>" loginBtn_post_location="<?php echo get_url('index','','user');?>" location_login="<?php echo get_url('index','','user');?>"/></p><label for="remember">记住我</label><input id="remember" type="checkbox"/></fieldset><p class="tips">					我们每天都在为您精挑细选
				</p></form><?php endif; endif; if(get_ad(25) != ''): echo get_ad(25); endif; ?></div></div><div class="radius-bottom"><span class="hl"></span><span class="hr"></span></div></div><?php if(get_ad(17) != ''): ?><div class="ad_banner"><?php echo get_ad(17);?></div><?php endif; ?><div class="showWrap"><?php if(isset($album_list)): ?><div class="radius-top"><span class="hl"></span><span class="hr"></span></div><div id="show"><h2 class="clearfix"><strong>菇凉们的专辑</strong><span><a href="<?php echo get_url('index','','album');?>" target="_blank">全部专辑</a></span></h2><ul class="clearfix"><li class="comm"><?php if(is_array($album_list)): $i = 0; $__LIST__ = array_slice($album_list,0,4,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voAlbum): $mod = ($i % 2 );++$i;?><p class="bgload"><a href="<?php echo get_url('albumDetail',$voAlbum['id'],'user');?>" target="_blank" title="<?php echo ($voAlbum["title"]); ?>"><img style="margin-left:-30px;" class="dr" src=<?php if($voAlbum['items_img'] != ''): ?>"<?php echo (get_img($voAlbum["items_img"],210)); ?>"<?php else: ?>__TMPL__Public/img/undefined.jpg<?php endif; ?> alt="<?php echo ($voAlbum["title"]); ?>"/></a><span><a class="n" href="<?php echo get_url('albumDetail',$voAlbum['id'],'user');?>" target="_blank"><?php echo (msubstr($voAlbum["title"],0,10,'utf-8',false)); ?></a></span></p><?php endforeach; endif; else: echo "" ;endif; ?></li><li class="big"><?php if(is_array($album_list)): $i = 0; $__LIST__ = array_slice($album_list,4,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voAlbum): $mod = ($i % 2 );++$i;?><p class="bgload"><a href="<?php echo get_url('albumDetail',$voAlbum['id'],'user');?>" target="_blank"><img src=<?php if($voAlbum['items_img'] != ''): ?>"<?php echo (get_img($voAlbum["items_img"],350)); ?>"<?php else: ?>__TMPL__Public/img/undefined.jpg<?php endif; ?> alt="<?php echo ($voAlbum["title"]); ?>"/></a><span><a class="n" target="_blank" href="<?php echo get_url('albumDetail',$voAlbum['id'],'user');?>" title="<?php echo ($voAlbum["title"]); ?>"><?php echo (msubstr($voAlbum["title"],0,10,'utf-8',false)); ?></a></span></p><?php endforeach; endif; else: echo "" ;endif; ?></li><li class="comm"><?php if(is_array($album_list)): $i = 0; $__LIST__ = array_slice($album_list,5,4,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voAlbum): $mod = ($i % 2 );++$i;?><p class="bgload"><a href="<?php echo get_url('albumDetail',$voAlbum['id'],'user');?>" target="_blank" title="<?php echo ($voAlbum["title"]); ?>"><img style="margin-left:-30px;" src=<?php if($voAlbum['items_img'] != ''): ?>"<?php echo (get_img($voAlbum["items_img"],210)); ?>"<?php else: ?>__TMPL__Public/img/undefined.jpg<?php endif; ?> alt="<?php echo ($voAlbum["title"]); ?>"/></a><span><a class="n" href="<?php echo get_url('albumDetail',$voAlbum['id'],'user');?>" target="_blank"><?php echo (msubstr($voAlbum["title"],0,10,'utf-8',false)); ?></a></span></p><?php endforeach; endif; else: echo "" ;endif; ?></li></ul></div><div class="radius-bottom"><span class="hl"></span><span class="hr"></span></div><?php endif; ?></div><?php if(is_array($index_group_cates)): $i = 0; $__LIST__ = $index_group_cates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><div class="piece_bdWrap"><div class="radius-top"><span class="hl"></span><span class="hr"></span></div><div class="piece_bd clearfix"><h2><strong>菇凉们喜欢的<a href="<?php echo get_url('index',$val['id'],'cate');?>"><?php echo ($val["name"]); ?></a></strong></h2><ul class="goods_list clear_in"><?php if(is_array($val['s_items'])): $i = 0; $__LIST__ = array_slice($val['s_items'],0,6,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo_s_items): $mod = ($i % 2 );++$i;?><li  style="width:150px;height:170px;overflow:hidden" class="bgload"><?php if(is_array($vo_s_items['t_items'])): $i = 0; $__LIST__ = array_slice($vo_s_items['t_items'],0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo_t_items): $mod = ($i % 2 );++$i;?><a target="_blank" href="<?php echo get_url('tag',$vo_t_items['tid'],'cate');?>" title="<?php echo ($vo_t_items["name"]); ?>"><img style="margin-left:-30px;" src=<?php if($vo_t_items['img'] != ''): ?>"<?php echo (get_img($vo_t_items["img"],210)); ?>"<?php else: ?>"__TMPL__Public/img/undefined.jpg"<?php endif; ?> alt="<?php echo ($vo_t_items["title"]); ?>" /><span><?php echo (msubstr($vo_t_items["name"],0,6,'utf-8',false)); ?></span></a><?php endforeach; endif; else: echo "" ;endif; ?></li><?php endforeach; endif; else: echo "" ;endif; ?></ul><div class="more_goods"><?php if(is_array($val['scate'])): $i = 0; $__LIST__ = $val['scate'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voScate): $mod = ($i % 2 );++$i;?><dl class="clear_in"><dt><a href="javascript:void(0)"><?php echo (msubstr($voScate["name"],0,2,'utf-8',false)); ?></a></dt><dd <?php if($voScate['key'] == '0'): ?>style="width:216px"<?php endif; ?>><?php if(is_array($voScate['scate_tags'])): $i = 0; $__LIST__ = $voScate['scate_tags'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voSt): $mod = ($i % 2 );++$i;?><a href="<?php echo get_url('tag',$voSt['id'],'cate');?>" class="<?php echo ($voSt["class"]); ?>"  target="_blank"><?php echo ($voSt["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?></dd></dl><?php endforeach; endif; else: echo "" ;endif; ?><a class="more_goods_all" href="<?php echo get_url('index',$val['id'],'cate');?>" target="_blank">全部...</a></div></div><div class="radius-bottom"><span class="hl"></span><span class="hr"></span></div></div><?php endforeach; endif; else: echo "" ;endif; if($shop_list): ?><div class="piece_bdWrap"><!--店铺信息--><div class="radius-top"><span class="hl"></span><span class="hr"></span></div><div style="padding-right:0px;" class="piece_bd clearfix "><h2><strong>菇凉们喜欢的<a href="javascript:void(0)">店铺</a></strong></h2><div class="brand_list"><ol class="brands_wrap"><?php if(is_array($shop_list)): $i = 0; $__LIST__ = array_slice($shop_list,0,18,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voShop): $mod = ($i % 2 );++$i;?><li class="magic_brand_list"><a title="<?php echo ($voShop["name"]); ?>" href="<?php echo get_url('index',$voShop['id'],'shop');?>"><img alt="<?php echo ($voShop["name"]); ?>" data-lazyload="<?php echo ($voShop["img"]); ?>" src=<?php if($voShop['img']): ?>"<?php echo ($voShop["img"]); ?>"<?php else: ?>__TMPL__Public/img/undefined.jpg<?php endif; ?>></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ol></div></div><div class="radius-bottom"><span class="hl"></span><span class="hr"></span></div></div><?php endif; ?></div><?php if(get_ad(18) != ''): ?><div  class="ad_banner"><?php echo get_ad(18);?></div><?php endif; ?><script>$(document).ready(function(){
	$.getJSON("<?php echo C('official_website');?>push/pv?path=<?php echo C('web_path');?>&callback=?");
});
</script><script>(function(){
$("#slide_img ol li:eq(0)").addClass("cur");
	var currentindex=0;
	var timerID = null;
	function changeflash(i) {	
			currentindex=i;
			$("#slide_img ul li:eq("+i+")").fadeIn("fast").siblings().hide();
			$("#slide_img ol li:eq("+i+")").addClass("cur").siblings().removeClass("cur");
	}
	function startAm(){
		if(timerID){
			return;
		}
		timerID = setInterval(timer_tick,3000);
	}
	function stopAm(){
		if(timerID){
			clearInterval(timerID);
			timerID = null;
		}
	}
	function timer_tick(){
		var totalNum=$("#slide_img ol li").length;
		currentindex=currentindex<totalNum ? currentindex+1 : 0;
		changeflash(currentindex);
	}
	startAm();
	$("#slide_img ol>li").hover(function(){stopAm();},function(){startAm();});
	$("#slide_img li").hover(function(){var num=$(this).index();changeflash(num);stopAm();},function(){startAm();})
})()
</script><div class="footerWrap"><div class="radius-top"><span class="hl"></span><span class="hr"></span></div><div id="footer"><div class="fl"><dl style="margin-left:30px;"><dt>网站</dt><dd><ul><?php if(is_array($p_cate_list)): $i = 0; $__LIST__ = $p_cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cval): $mod = ($i % 2 );++$i;?><li>·<a href="<?php echo get_url('index',$cval['id'],'cate');?>" target="_blank"><?php echo ($cval["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></dd></dl><dl><dt>网站相关</dt><dd style="margin-bottom: 18px;"><ul><dd><a href="__PUBLIC__/statics/sitemap.html" target="_blank">网站地图</a></dd><dd><a href="__PUBLIC__/statics/sitemap.xml" target="_blank">sitemap</a></dd><dd><?php echo strclean(C('site_icp')); ?></dd><dd><?php echo strclean(C('statistics_code')); ?></dd></ul></dd></dl></div><div class="fr"><dl class="followus"><dt>关注我们</dt><dd><ul><dd><?php echo strclean(C('follow_us')); ?></dd><dd><?php echo strclean(C('follow_us2')); ?></dd><dd><?php echo strclean(C('follow_us3')); ?></dd><dd><?php echo strclean(C('follow_us4')); ?></dd><dd><?php echo strclean(C('follow_us5')); ?></dd><dd><?php echo strclean(C('follow_us6')); ?></dd></ul></dd></dl><dl><dt>友情链接</dt><dd><ul><?php if(is_array($linkList)): $i = 0; $__LIST__ = $linkList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li>·<a href="<?php echo ($val["url"]); ?>" target="_blank"><?php echo ($val["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></dd></dl></div><p class="cr"><?php echo strclean(C('record')); ?></p></div><div class="radius-bottom"><span class="hl"></span><span class="hr"></span></div></div><div class="back2top"><a href="javascript:;" title="返回顶部"></a></div></body></html><script>/*返回顶部*/
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