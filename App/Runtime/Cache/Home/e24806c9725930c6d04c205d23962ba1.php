<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"><title><?php echo ($seo["title"]); ?></title><meta http-equiv="x-ua-compatible" content="ie=7" /><meta name="keywords" content="<?php echo ($seo["keys"]); ?>" /><meta name="description" content="<?php echo ($seo["desc"]); ?>" /><?php if(is_array($sty)): $i = 0; $__LIST__ = $sty;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$styshow): $mod = ($i % 2 );++$i;?><link href="__TMPL__Public/css/<?php echo ($styshow); ?>.css" type="text/css" rel="stylesheet" /><?php endforeach; endif; else: echo "" ;endif; ?><script src="__PUBLIC__/statics/js/jquery/jquery-1.7.2.min.js"></script><script src="__PUBLIC__/statics/js/ThinkAjax.js"></script><script src="__TMPL__Public/js/index.js?1"></script><style type="text/css">.op .in{display:none}
.op .out{display:none}
</style><script>$(document).ready(function(){
	//登录
	var id = $.cookie('id');
	var username =$.cookie('name');
	if(id > 0){
		$(".op .in").show();
		if(username != ''){
			$('#username').text(username);
		}
	}else{
		$(".op .out").show();
	}
	//搜索
	var web_path=$('#web_path').text();
	<?php if(isset($album)): ?>$('.search #album').addClass('cur').siblings().removeClass('cur');
		$(".search form").attr('action',web_path+'index.php?a=album&m=Search&g=Home');
		$('#a').val('album');<?php endif; ?>	$(".search li").click(function(){
		$(this).addClass('cur').siblings().removeClass('cur');
		var a = $(this).attr('id');
		$(".search form").attr('action',web_path+'index.php?a='+a+'&m=Search&g=Home');
		$('#a').val(a);
	})

	var key = $(".btn_txt").attr('placeholder');
	
	$(".search_btn_txt").focus(function(){
		if($(".search_btn_txt").val() == key){
			$(this).val('');
		}
	});
	
	$(".search_btn_txt").blur(function(){
		if($(".search_btn_txt").val() == ''){
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
</script></head><body><div id="web_path" style="display:none;"><?php echo C('web_path');?></div><div class="nav_main" id="header_fixed"><div class="fm970"><ul class="fl cl"><li class=<?php if('index' == $curpage): ?>cur<?php endif; ?>><a href="<?php echo C('site_domain');?>">首页</a></li><li class=<?php if('album' == $curpage): ?>cur<?php endif; ?>><a href="<?php echo get_url('index','','album');?>">专辑</a></li><?php if(is_array($p_cate_list)): $i = 0; $__LIST__ = $p_cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vop): $mod = ($i % 2 );++$i;?><li class=<?php if($vop['id'] == $id): ?>cur<?php endif; ?>><a href="<?php echo get_url('index',$vop['id'],'cate');?>"><?php echo ($vop["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul><ul class="op"><li class="out"><a href="<?php echo get_url('register','','user');?>"><b>注册</b></a>|<a href="<?php echo get_url('login','','user');?>"><b>登录</b></a></li><li class="out"><a class="t_sina" href="<?php echo get_url('sinalogin','','user');?>" target="_blank"><i>微博登录</i></a></li><li class="out"><a class="t_qz" href="<?php echo get_url('qqlogin','','user');?>" target="_blank"><i>QQ登录</i></a></li><li class="out"><a class="t_tb" href="<?php echo get_url('taobaologin','','user');?>" target="_blank"><i>淘宝登录</i></a></li><li class="in">欢迎您<a href="<?php echo get_url('index','','user');?>"><b id="username"><?php echo ($nav_user_info["name"]); ?></b></a></li><li class="in"><a href="<?php echo get_url('release','','user');?>"><i>发布分享</i></a></li><li class="in"><a href="<?php echo get_url('account','','user');?>">个人设置</a></li><li class="in" ><a href="<?php echo get_url('logout','','user');?>">退出</a></li></ul></div><div class="clear"></div></div><div class="header"><div class="info_bar"><div class="fm970"><h1 class="logo"></h1><div class="search"><ul><li class="cur" id="index">单品</li><li class="" id="album">专辑</li></ul><div class="data s_item"><form action="<?php echo get_url('index','','search');?>" method="get"><input id="a" name="a" type="hidden" value="index"><input name="m" type="hidden" value="Search"><input name="g" type="hidden" value="Home"><input type="text" name="keywords" class="btn_txt search_btn_txt" id="keywd" value="<?php if(isset($keywords)): echo ($keywords); else: echo C('default_kw'); endif; ?>" placeholder="<?php echo C('default_kw');?>" autoComplete= "Off"/><input type="image" src="__TMPL__Public/img/btn_search.gif"/></form></div></div><div class="au_box"><div class="nav_sina_fo_btn fl"><!-- Baidu Button BEGIN --><div id="bdshare" class="bdshare_b" style="line-height: 12px;"><img src="http://share.baidu.com/static/images/type-button-5.jpg" /><a class="shareCount"></a></div><script type="text/javascript" id="bdshare_js" data="type=button" ></script><script type="text/javascript" id="bdshell_js"></script><script type="text/javascript">	document.getElementById("bdshell_js").src = "http://share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
</script><!-- Baidu Button END --></div></div></div></div><div class="nav_main nav_offsetTop"><div class="fm970"><ul class="fl cl"><li class=<?php if('index' == $curpage): ?>cur<?php endif; ?>><a href="<?php echo C('site_domain');?>">首页</a></li><li class=<?php if('album' == $curpage): ?>cur<?php endif; ?>><a href="<?php echo get_url('index','','album');?>">专辑</a></li><?php if(is_array($p_cate_list)): $i = 0; $__LIST__ = $p_cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vop): $mod = ($i % 2 );++$i;?><li class=<?php if($vop['id'] == $id): ?>cur<?php endif; ?>><a href="<?php echo get_url('index',$vop['id'],'cate');?>"><?php echo ($vop["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul><ul class="op"><li class="out"><a href="<?php echo get_url('register','','user');?>"><b>注册</b></a>|<a href="<?php echo get_url('login','','user');?>"><b>登录</b></a></li><li class="out"><a class="t_sina" href="<?php echo get_url('sinalogin','','user');?>" target="_blank"><i>微博登录</i></a></li><li class="out"><a class="t_qz" href="<?php echo get_url('qqlogin','','user');?>" target="_blank"><i>QQ登录</i></a></li><li class="out"><a class="t_tb" href="<?php echo get_url('taobaologin','','user');?>" target="_blank"><i>淘宝登录</i></a></li><li class="in">欢迎您<a href="<?php echo get_url('index','','user');?>"><b id="username"><?php echo ($nav_user_info["name"]); ?></b></a></li><li class="in"><a href="<?php echo get_url('release','','user');?>"><i>发布分享</i></a></li><li class="in"><a href="<?php echo get_url('account','','user');?>">个人设置</a></li><li class="in" ><a href="<?php echo get_url('logout','','user');?>">退出</a></li></ul></div><div class="clear"></div></div></div><div class="wrap"><div class="welcome"><ul><li class="fx"><strong>发现时尚，与惊喜不期而遇</strong><br><em>　Discover&Recommend </em></li><li class="sc"><strong>收集宝贝，建立购物档案</strong><br><em>　collection lovely things </em></li><li class="sh"><strong>分享美丽，认识趣味相投的朋友</strong><br><em>　share your style & get friends</em></li></ul><a class="close" href="javascript:void(0);"><img src="<?php echo C('web_path');?>App/Tpl/Home/default/Public/img/close.gif" /></a></div><div class="buynews clearfix"><div class="fl"><div class="gw_daren"><div class="box"><div class="inner"><ul><li><div class="ds"><ul class="focus" focusid="<?php echo ($focus["id"]); ?>"><li class="bgload"><a href="<?php echo get_url('index',$focus['id'],'item');?>"><?php if($focus['remark1'] != ''): ?><img src="<?php echo ($focus["remark1"]); ?>" alt="<?php echo ($focus["title"]); ?>" /><?php else: ?><img src="<?php echo (get_img($focus["img"],350)); ?>" /><?php endif; ?></a><div class="ds"><p><a href="<?php echo get_url('index',$focus['id'],'item');?>" title="<?php echo ($focus["title"]); ?>"><?php echo (msubstr($focus["title"],0,28,'utf-8',false)); ?></a></p></div></li></ul></div></li></ul></div></div></div><div class="gw_shuo"><ul><?php if(is_array($index_share_item)): $i = 0; $__LIST__ = $index_share_item;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valsi): $mod = ($i % 2 );++$i;?><li class="focus_li" id="<?php echo ($valsi["id"]); ?>" focus_title="<?php echo (msubstr($valsi["title"],0,28,'utf-8',false)); ?>" focus_link="<?php echo get_url('index',$valsi['id'],'item');?>" <?php if($valsi['remark1'] != ''): ?>focus_img="<?php echo ($valsi["remark1"]); ?>"<?php else: ?>focus_img="<?php echo (get_img($valsi["img"],350)); ?>"<?php endif; ?>><a href="<?php echo get_url('index',$valsi['uid'],'user');?>"><img class="avt r3" width="35" alt="<?php echo ($valsi["title"]); ?>" onerror="this.src='__PUBLIC__/statics/images/avatar-60.png'" src=<?php if($valsi['uimg'] == ''): ?>__PUBLIC__/statics/images/avatar-60.png<?php else: echo C('web_path');?>Uploads/avatar_small/<?php echo ($valsi["uimg"]); endif; ?> /></a><div class="tk"><a href="<?php echo get_url('index',$valsi['uid'],'user');?>"><em><?php echo ($valsi["name"]); ?></em></a> 刚刚分享：
              <p><a href="<?php echo get_url('index',$valsi['id'],'item');?>" class='share_item_title' title="<?php echo ($valsi["title"]); ?>"><?php echo ($valsi["title"]); ?></a></p></div></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></div></div><div class="fr"><div class="loginbox"><?php if(isset($uid)): ?><div class="aur_info"><dl><dt><a href="<?php echo get_url('index','','user');?>"><img width="64" onerror="this.src='__PUBLIC__/statics/images/avatar-60.png'" src=<?php if($nav_user_info['img'] == ''): ?>__PUBLIC__/statics/images/avatar-60.png<?php else: echo C('web_path');?>Uploads/avatar_small/<?php echo ($nav_user_info["img"]); endif; ?> /></a></dt><dd><em><a href="<?php echo get_url('index','','user');?>" class="hc"><?php echo ($nav_user_info["name"]); ?></a></em><em><?php if($nav_user_info['sex'] == 0): ?>女<?php else: ?>男<?php endif; if($nav_user_info['age'] == 80): ?>80后<?php elseif($nav_user_info['age'] == 70): ?>70后<?php else: ?>60后<?php endif; ?></em><em><?php echo ($nav_user_info["address"]); ?></em></dd></dl></div><div class="uc_nav"><ul><li><a class="s1" href="<?php echo get_url('index','','user');?>">我的首页</a></li><li><a class="s2" href="<?php echo get_url('share','','user');?>">我的分享</a></li><li><a class="s5" href="<?php echo get_url('like','','user');?>">我的喜欢</a></li><li><a class="s6" href="<?php echo get_url('album','','user');?>">我的专辑</a></li></ul></div><?php else: ?><div class="logo"><img src="<?php echo C('web_path');?>App/Tpl/Home/default/Public/img/log1.gif" /></div><div class="nextprice">" <?php echo C("site_name");?> " 有效单品统计： <strong><em><?php echo ($itemCount); ?></em></strong><span class="gx">我们每天都在为您精挑细选</span></div><div class="login_info"><div id="loginError"></div><table cellpadding="0" cellspacing="0" width="250"><?php if(($article_list) AND (C('article_show') == '1')): ?><tr><td><ul><?php if(is_array($article_list)): $i = 0; $__LIST__ = $article_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voArt): $mod = ($i % 2 );++$i;?><!--<?php echo get_url('index',$voArt['id'],'article');?>--><li><span style="float:right;color:#ccc">[<?php echo (date('Y-m-d',$voArt["add_time"])); ?>]</span><a href=<?php if($voArt['url']): echo ($voArt["url"]); else: ?>"<?php echo get_url('detail',$voArt['id'],'article');?>"<?php endif; ?> target="_blank"><?php echo (msubstr($voArt["title"],0,12,'utf-8',false)); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ul></td></tr><?php else: ?><tr><td><label><input style="border: solid 1px #DBDCDA;" type="text" class="btn_txt" id="uname" value="输入用户名" /></label><label><input style="border: solid 1px #DBDCDA;" type="password" class="btn_txt" id="pwd"/></label></td><td align="center"><input class="sub" type="button" id="indexLoginBtn" name="submit" value="登录" style="cursor:pointer" loginBtn_post_action="<?php echo get_url('loginAction','','user');?>" loginBtn_post_location="<?php echo get_url('index','','user');?>" location_login="<?php echo get_url('index','','user');?>"/><div id="loading" style="display:none;"><img src="__PUBLIC__/statics/images/loading_d.gif"></div><label><input type="checkbox" id="autologin_checkBox" />	                记住我</label></td></tr><?php endif; ?></table></div><?php endif; ?></div></div></div><?php if(get_ad(1) != ''): ?><center><div style="width:970px;height:90px;overflow:hidden;margin-bottom:15px;"><?php echo get_ad(1);?></div></center><?php endif; ?><div class="wrap_bt"><?php if(is_array($index_group_cates)): $i = 0; $__LIST__ = $index_group_cates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><div class="box1" <?php if(($key == $index_gropu_count) and (!$shop_list)): ?>style="border:0px"<?php endif; ?>><div class="tit_share"><strong>发现<em><?php echo ($val["name"]); ?></em></strong><span class="key"><?php if(is_array($val['s'])): $i = 0; $__LIST__ = array_slice($val['s'],0,10,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vals): $mod = ($i % 2 );++$i;?><a href="<?php echo get_url('tag',$vals['id'],'cate');?>" title="<?php echo ($vals["name"]); ?>"><?php echo ($vals["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?><a href="<?php echo get_url('index',$val['id'],'cate');?>" title="<?php echo ($val["name"]); ?>">全部</a></span></div><div class="share_items" style="height:302px; overflow:hidden;"><?php if(is_array($val['s_items'])): $i = 0; $__LIST__ = $val['s_items'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo_s_items): $mod = ($i % 2 );++$i;?><div class="<?php echo ($vo_s_items["class"]); ?> bgload" style="<?php echo ($vo_s_items["style"]); ?>"><?php if(is_array($vo_s_items['t_items'])): $i = 0; $__LIST__ = array_slice($vo_s_items['t_items'],0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo_t_items): $mod = ($i % 2 );++$i;?><a class="au" href="<?php echo get_url('tag',$vo_t_items['tid'],'cate');?>" title="<?php echo ($vo_t_items['name']); ?>"><?php if($vo_t_items['img'] != ''): if($vo_s_items['class'] == t1): ?><img src="<?php echo (get_img($vo_t_items["img"],100)); ?>" width="100" alt="<?php echo ($vo_t_items['name']); ?>"><?php else: ?><img src="<?php echo (get_img($vo_t_items["img"],210)); ?>" width="200" alt="<?php echo ($vo_t_items['name']); ?>"><?php endif; else: ?><img src="__TMPL__Public/img/undefined.jpg" /><?php endif; ?><div class="ds"><div class="<?php if($vo_t_items['name'] != ''): ?>au<?php endif; ?>"><span><?php echo (msubstr($vo_t_items["name"],0,6,'utf-8',false)); ?></span><i></i></div></div></a></a><?php endforeach; endif; else: echo "" ;endif; ?></div><?php endforeach; endif; else: echo "" ;endif; ?></div><div class="share_who">她们在分享<?php echo ($val["name"]); ?> :
	      <?php if(is_array($val['user'])): $i = 0; $__LIST__ = $val['user'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$valu): $mod = ($i % 2 );++$i;?><a href="<?php echo get_url('index',$valu['uid'],'user');?>"><?php if($valu['uimg'] != ''): ?><img alt="<?php echo ($valu["name"]); ?>" width="45" onerror="this.src='__PUBLIC__/statics/images/avatar-60.png'" src="<?php echo C('web_path');?>Uploads/avatar_small/<?php echo ($valu["uimg"]); ?>"/><?php endif; ?></a><?php endforeach; endif; else: echo "" ;endif; ?></div></div><?php endforeach; endif; else: echo "" ;endif; if($shop_list): ?><div class="box1" style="border:0px"><div class="tit_share"><strong>发现<em>店铺</em></strong></div><div class="groups"><?php if(is_array($shop_list)): $i = 0; $__LIST__ = array_slice($shop_list,0,11,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voShop): $mod = ($i % 2 );++$i;?><dl><dt><a href="<?php echo get_url('index',$voShop['id'],'shop');?>"><img title="<?php echo ($voShop["name"]); ?>" src=<?php if($voShop['img']): ?>"<?php echo ($voShop["img"]); ?>"<?php else: ?>__TMPL__Public/img/undefined.jpg<?php endif; ?> title="<?php echo ($voShop["name"]); ?>" alt="<?php echo ($voShop["name"]); ?>" /></a></dt></dl><?php endforeach; endif; else: echo "" ;endif; ?></div></div><?php endif; ?></div></div><?php if(get_ad(2) != ''): ?><center><div class="ad" style="width:970px;height:90px;overflow:hidden;margin-bottom:15px;"><?php echo get_ad(2);?></div></center><?php endif; ?><script>$(document).ready(function(){
	$.getJSON("<?php echo C('official_website');?>push/pv?path=<?php echo C('web_path');?>&callback=?");
});
</script><script>	$(function(){
		//首页焦点图
		var f_id=$(".focus").attr("focusid");
		$(".gw_shuo #"+f_id).css("background-color","#E6E6E6");
		var currentindex=0;
		var timerID = null;
		function changeflash(i) {	
			currentindex=i;
			$(".gw_shuo ul li:eq("+i+")").css("background-color","#E6E6E6").siblings().css("background-color","#FFFFFF");
			var focus_img=$(".gw_shuo ul li:eq("+i+")").attr("focus_img");
			var focus_title=$(".gw_shuo ul li:eq("+i+")").attr("focus_title");
			var focus_link=$(".gw_shuo ul li:eq("+i+")").attr("focus_link");
			$(".focus p a").html(focus_title);
			$(".focus a").attr("href",focus_link);
			$(".focus img").attr("src",focus_img);
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
			var totalNum=$(".gw_shuo ul li").length;
			currentindex=currentindex<totalNum ? currentindex+1 : 0;
			changeflash(currentindex);
		}
		startAm();
		$(".gw_shuo ul>li").hover(function(){stopAm();},function(){startAm();});
		$(".gw_shuo li").hover(function(){var num=$(this).index();changeflash(num);stopAm();},function(){startAm();});
	})
</script><div class="sitemap"><dl><dt>网站地图</dt><?php if(is_array($p_cate_list)): $i = 0; $__LIST__ = $p_cate_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cval): $mod = ($i % 2 );++$i;?><dd><a href="<?php echo get_url('index',$cval['id'],'cate');?>">发现<?php echo ($cval["name"]); ?></a></dd><?php endforeach; endif; else: echo "" ;endif; ?></dl><dl><dt>关注我们</dt><dd><?php echo strclean(C('follow_us')); ?></dd><dd><?php echo strclean(C('follow_us2')); ?></dd><dd><?php echo strclean(C('follow_us3')); ?></dd><dd><?php echo strclean(C('follow_us4')); ?></dd><dd><?php echo strclean(C('follow_us5')); ?></dd><dd><?php echo strclean(C('follow_us6')); ?></dd></dl><dl><dt></dt><dd><a href="<?php echo C('site_domain');?>"><img src="__PUBLIC__/statics/images/logo_bot.gif" width="120"></a></dd></dl><dl><dt>网站相关</dt><dd><a href="__PUBLIC__/statics/sitemap.html" target="_blank">网站地图</a></dd><dd><a href="__PUBLIC__/statics/sitemap.xml" target="_blank">sitemap</a></dd><dd><?php echo strclean(C('site_icp')); ?></dd><dd><?php echo strclean(C('statistics_code')); ?></dd></dl><dl><dt>友情链接</dt><?php if(is_array($linkList)): $i = 0; $__LIST__ = $linkList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><dd><a href="<?php echo ($val["url"]); ?>" target="_blank"><?php echo ($val["name"]); ?></a></dd><?php endforeach; endif; else: echo "" ;endif; ?></dl></div><div style="display:none;" id="gotopbtn" class="back2top"><a href="javascript:void(0);"></a></div><script type="text/javascript">$(function() {
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
</script><!--[if lte IE 6]><script src="__TMPL__Public/js/DD_belatedPNG_0.0.8a-min.js"></script><script>DD_belatedPNG.fix('div.au span,div.au i,span.au span,span.au i,h1.logo');</script><![endif]--></body></html>