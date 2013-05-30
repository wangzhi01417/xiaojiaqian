<?php
class ItemsAction extends BaseAction{

	//分页显示所有商品
	public function index(){

		$items = M('Items');
		$items_cate = M('ItemsCate');
		$items_site = M('ItemsSite');
		
		//搜索功能
		$where = 'is_del=0';
		$keyword = isset($_GET['keyword']) && trim($_GET['keyword']) ? trim($_GET['keyword']) : '';
		$cate_id = isset($_GET['cate_id']) && intval($_GET['cate_id']) ? intval($_GET['cate_id']) : '';
		$time_start = isset($_GET['time_start']) && trim($_GET['time_start']) ? trim($_GET['time_start']) : '';
		$time_end = isset($_GET['time_end']) && trim($_GET['time_end']) ? trim($_GET['time_end']) : '';
		$is_index = isset($_GET['is_index']) ? intval($_GET['is_index']) : '-1';
		$status = isset($_GET['status']) ? intval($_GET['status']) : '-1';
		$order = isset($_GET['order']) && trim($_GET['order']) ? trim($_GET['order']) : '';
		$sort = isset($_GET['sort']) && trim($_GET['sort']) ? trim($_GET['sort']) : 'asc';
		if ($keyword) {
			$where .= " AND title LIKE '%" . $keyword . "%'";
			$this->assign('keyword', $keyword);
		}
		if ($cate_id) {
			$where .= " AND cid=" . $cate_id;
			$this->assign('cate_id', $cate_id);
		}
		if ($time_start) {
			$time_start_int = strtotime($time_start);
			$where .= " AND add_time>='" . $time_start_int . "'";
			$this->assign('time_start', $time_start);
		}
		if ($time_end) {
			$time_end_int = strtotime($time_end);
			$where .= " AND add_time<='" . $time_end_int . "'";
			$this->assign('time_end', $time_end);
		}

		$is_index >= 0 && $where .= " AND is_index=" . $is_index;
		$status >= 0 && $where .= " AND status=" . $status;
		$status < 0 && $where .= " AND status !=2";
		$this->assign('is_index', $is_index);
		$this->assign('status', $status);
		
		//排序功能
		if ($sort=='desc'){
			$sort='asc';
		}elseif ($sort=='asc'){
			$sort='desc';
		}
		$this->assign('order',$order);
		$this->assign('sort', $sort);
		$order_str = 'ord desc,add_time desc'; //默认排序
		if ($order) {
			$order_str = 'ord desc,'.$order . ' ' . $sort;
		}
		
		//分类循环
		$result = $items_cate->where('is_del = 0')->order('ord desc')->select();
		$cate_list = array();
		foreach ($result as $val) {
			if ($val['pid'] == 0) {
				$cate_list['parent'][$val['id']] = $val;
// 			} else {
// 				$cate_list['sub'][$val['pid']][] = $val;
			}
		}
		
		import("ORG.Util.Page");
		$count=$items->where($where)->count();
		$page=new Page($count,20);
		$show=$page->show();
		$list=$items->where($where)->order($order_str)->limit($page->firstRow.','.$page->listRows)->select();

		foreach ($list as $key=>$val){
			$data['id']=$val['cid'];
			$data['is_del']=0;
			$cate=$items_cate->field('name')->where($data)->find();
			$list[$key]['cname']=$cate['name'];
			$site=$items_site->field('site_logo')->where("id='".$val['sid']."'")->find();
			$list[$key]['site_logo']=$site['site_logo'];
			$list[$key]['key']= ++$page->firstRow;
		}
		$this->assign('is_index',$is_index);
		$this->assign('status',$status);
		$this->assign('cate_list', $cate_list);
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->display();
	}

	//同步商品状态
	public function update(){

		$this->display();

    }

    public function sync(){

		ini_set("max_execution_time", 0);

		//$this->display();
		header("Content-type: text/xml; charset=utf-8");

		$items_mod=M("Items");
		$items_list = $items_mod->where('status = 1')->order("add_time desc")->select();
        $cnt = 0;
        $loginfo = "";
		foreach($items_list as $item) {

			$result = $this->sync_item_data($item);
			if($result!=""){
				$cnt++;
				$loginfo .= $result;
			}
		}
		//Ajax返回数据
        $data['count'] = $cnt;
        $data['log'] = $loginfo;
        $this->ajaxReturn($data);

	}

	// 更新一个宝贝信息。
	//	输入：$item - 本地宝贝信息
	//  返回：TRUE - 更新了宝贝, FALSE - 没有更新宝贝
	public function sync_item_data($item) {
		import("@.ORG.Taobao");
		$taobao=new Taobao();

		//$firephp = get_fire_php();

		$item_id = $item['id'];
		$item_key = $item['item_key'];		// such as : taobao_16554250670
		$item_price = $item['price'];
		$item_oldprice = $item['remark1'];
		$item_status = $item['status'];

		$updated = false;
		$log = "";

		//echo "Sync data for item with id=$item_id<br>";

		list($site_alias, $taobao_item_id) = split('[_]', $item_key);

		if ($site_alias == "taobao")
			$domain = "taobao.com";
		else if ($site_alias == "tmall")
			$domain = "tmall.com";
		else
			return false;

		$m_url = 'http://a.m.'.$domain.'/i'.$taobao_item_id.'.htm';

		//$firephp->log($url, "url=");

		// $firephp->log(array(
		// 	"site_alias" => $site_alias,
		// 	"item_id" => $item_id,
		// 	"url" => $url));

		// 获取淘宝宝贝网页html.
		$item_html = file_get_contents( $m_url );

		//$firephp->log($item_html, "item_html=");

		// 获取宝贝标题
		$new_title=$taobao->match_title( $item_html );

		//$firephp->log($title, "title=");

		// 获取宝贝图片地址
		$new_img=$taobao->match_image( $item_html );

		//$firephp->log($img, "img=");

		// 获取宝贝价格
		$new_price=$taobao->match_price( $item_html );

		//获得商品原价格
		$old_price=$taobao->match_price_origin( $item_html );
		if(strpos($old_price, '-'))
			$old_price = end(explode('-', $old_price));

		//$firephp->log($new_price, "latest price=");

		// 获取宝贝状态：在售？下架？
		$active = $taobao->match_status( $item_html );

		//if (!$active)
			//$firephp->log($active ? "##ACTIVE##" : "##INACTIVE##", "item with id='$item_id' status=");
			//echo "Item with id=$item_id status=INACTIVE<br>";
        $items = M('items');

		if ($active) {

			//$firephp->log($item_price, "our price=");

			// $new_price maybe like '8.91-9.90'.
			if (strpos($new_price, '-')){
				//$firephp->log($item_price, "item_price=");

				$min_max_prices = explode("-", $new_price);
				$min_price = $min_max_prices[0];
				$max_price = $min_max_prices[1];

				//$firephp->log("min=$min_price, max=$max_price", "");
				//echo "min=$min_price, max=$max_price<br>";

				$new_price = $min_price;
			}

			//$firephp->log($item_price, "our price=");

			if ($new_price != $item_price) {
				// 如果商品的最新价格>9.9，下架！
				if ($new_price > 10) {
					if($item_status != 3){
						$data['status']=3;
						$where['id']=$item_id;
						$items->where($where)->save($data);
						//$firephp->log("Item with id='$item_id' price is too high (cur=$new_price, prev=$item_price), make it as inactive", "");
						//echo "Item with id='$item_id' price is too high (cur=$new_price, prev=$item_price), change its status to 3<br>";
						$updated = true;
						$log .= "Item with id=".$item_id."价格为".$new_price.",大于10块，活动结束<br>";
					}

				}
				else{

				    // 更新商品价格
					$data['price']=$new_price;
					$where['id']=$item_id;
					$items->where($where)->save($data);
					$updated = true;
					$log .= "Item with id=".$item_id." 价格调为".$new_price."<br>";
				}

			}

           if ($old_price != $item_oldprice) {
				    //更新商品原价
		        $where['id']=$item_id;
				$data['remark1']=$old_price;
				$items->where($where)->save($data);
				$updated = true;
				$log .= "Item with id=".$item_id." 原价格调为".$old_price."<br>";

		    }

		}
		else {
			// Inactive, update the item status to "inactive".
			//$items = M('items');
			if($item_status != 2){

				$where['id']=$item_id;
				$data['status']=2;
				$items->where($where)->save($data);
				$updated = true;
				$log .= "Item with id=".$item_id." 该商品已经下架<br>";

			}
	
			//$firephp->log(array(
			//	"Update item to inactive with id=" => $item_id));
			//echo "Item with id=$item_id has been sold out on taobao.com, update item's status to 2 <br>";
		}


		return $log;
	}


	public function escape($str) { 
	    preg_match_all("/[\x80-\xff].|[\x01-\x7f]+/",$str,$r); 
	    $ar = $r[0]; 
	    foreach($ar as $k=>$v) { 
	        if(ord($v[0]) < 128) 
	            $ar[$k] = rawurlencode($v); 
	        else 
	            $ar[$k] = "%u".bin2hex(iconv("GB2312","UCS-2",$v)); 
	        } 
	    return join("",$ar); 
	} 

	public function unescape($str) { 
	    $str = rawurldecode($str); 
	    preg_match_all("/(?:%u.{4})|.+/",$str,$r); 
	    $ar = $r[0]; 
	    foreach($ar as $k=>$v) { 
	        if(substr($v,0,2) == "%u" && strlen($v) == 6) 
	        $ar[$k] = iconv("UCS-2","GB2312",pack("H4",substr($v,-4))); 
	    } 
	    return join("",$ar); 
	} 

	// 通过九块邮url获得九块邮淘宝客url
	//  http://ju.jiukuaiyou.com/jump/1121ep
	//      ==>
	//  http://s.click.taobao.com/t?e=m%3D2%26s%3D2S6vduMZ8V4cQipKwQzePOeEDrYVVa64yK8Cckff7TVRAdhuF14FMTKps9mP2Yfh5x%2BIUlGKNpX6KEOZrBczXtQRGlh44dSUtIeQcAzHZya4DhHU0zfJfZV%2FuXncgIhTNYaCXdjmmr10unyvB%2BGhTZjIENIzVq%2FX&spm=2014.12057478.1.0&u=108kh5101010101010T0
	public function get_taobaoke_url($jiukuaiyou_url) {
	    $ch = curl_init(); 

	    //set url 
	    curl_setopt($ch, CURLOPT_URL, $jiukuaiyou_url); 

	    //return the transfer as a string 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

	    $result = curl_exec($ch); 
	    //var_dump($result);
	    $pattern = "/<a href=\'(.*?)\' display=\'none\'/si";
	    preg_match($pattern, $result, $matches);

	    //var_dump($matches[1]);

	    curl_close($ch);      

	    return $matches[1];
	}

	// Apparently 'redirect_url' is not available on all curl-versions
	// so we fetch the location header ourselves
	function get_redirect_url($url) {
    	$headers = @get_headers($url);
    	$pattern = '/Location\s*:\s*(https?:[^;\s\n\r]+)/i';
    	if ($locations = preg_grep($pattern, $headers))
    	{
        	preg_match($pattern, end($locations), $redirect);
        	return $redirect[1];
    	}
    	return $url;
	}

	// 不要用我！！！早期curl版本不支持‘redirect_url’！！！
	// 通过淘宝客url获取淘宝中间形式url: tu url
	//  http://s.click.taobao.com/t?e=m%3D2%26s%3D2S6vduMZ8V4cQipKwQzePOeEDrYVVa64yK8Cckff7TVRAdhuF14FMTKps9mP2Yfh5x%2BIUlGKNpX6KEOZrBczXtQRGlh44dSUtIeQcAzHZya4DhHU0zfJfZV%2FuXncgIhTNYaCXdjmmr10unyvB%2BGhTZjIENIzVq%2FX&spm=2014.12057478.1.0&u=108kh5101010101010T0
	//      ==>
	//  http://s.click.taobao.com/t_js?tu=http%3A%2F%2Fs.click.taobao.com%2Ft%3Fe%3Dm%253D2%2526s%253D2S6vduMZ8V4cQipKwQzePOeEDrYVVa64yK8Cckff7TVRAdhuF14FMTKps9mP2Yfh5x%252BIUlGKNpX6KEOZrBczXtQRGlh44dSUtIeQcAzHZya4DhHU0zfJfZV%252FuXncgIhTNYaCXdjmmr10unyvB%252BGhTZjIENIzVq%252FX%26spm%3D2014.12057478.1.0%26u%3D108kh5101010101010T0%26ref%3D%26et%3DjFBC5nUWBRTjTg%253D%253D
	public function get_taobaoke_tu_url($taobaoke_url) {
	    //var_dump($taobaoke_url);

	    $ch = curl_init(); 

	    curl_setopt($ch, CURLOPT_URL, $taobaoke_url); 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

	    curl_exec($ch);

	    $info = curl_getinfo($ch);
	    //var_dump($info);

	    $tu_url = $info['redirect_url'];

	    curl_close($ch);      

	    return $tu_url;
	}

	// 获取淘宝宝贝真实地址
	// http://s.click.taobao.com/t_js?tu=http%3A%2F%2Fs.click.taobao.com%2Ft%3Fe%3Dm%253D2%2526s%253D2S6vduMZ8V4cQipKwQzePOeEDrYVVa64yK8Cckff7TVRAdhuF14FMTKps9mP2Yfh5x%252BIUlGKNpX6KEOZrBczXtQRGlh44dSUtIeQcAzHZya4DhHU0zfJfZV%252FuXncgIhTNYaCXdjmmr10unyvB%252BGhTZjIENIzVq%252FX%26spm%3D2014.12057478.1.0%26u%3D108kh5101010101010T0%26ref%3D%26et%3DjFBC5nUWBRTjTg%253D%253D
	//  ==>
	//  http://detail.tmall.com/item.htm?id=24278460596
	public function get_taobao_item_url($taobao_tu_url) {
	    $ch = curl_init(); 

	    $unescaped_tu_url = $this->unescape($taobao_tu_url);

	    $split_unescaped_tu_url = preg_split('/tu=/', $unescaped_tu_url);

	    curl_setopt($ch, CURLOPT_REFERER, $taobao_tu_url);
	    curl_setopt($ch, CURLOPT_URL, $split_unescaped_tu_url[1]); 
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

	    curl_exec($ch);

	    $info = curl_getinfo($ch);
	    // var_dump($info);

	    //$redirect_url = $info['redirect_url'];
	    $redirect_url = $info['url'];

	    curl_close($ch);

	    $split_parts = preg_split("/&ali_trackid/", $redirect_url);
	    return $split_parts[0];
	}

	// 根据九块邮url获取淘宝url.
	//
	public function get_jiukuaiyou_item_taobao_url($jiukuaiyou_url) {
	    $taobaoke_url = $this->get_taobaoke_url($jiukuaiyou_url);
	    //var_dump("<br>taobaoke_url=".$taobaoke_url);

	    // taobaoke_url可能已经是taobao/tmall宝贝地址
	    if (preg_match('/.*item.taobao.com.*/si', $taobaoke_url) ||
	    	preg_match('/.*detail.tmall.com.*/si', $taobaoke_url)) {
	    	//var_dump("<br>taobaoke_url可能已经是taobao/tmall宝贝地址".$taobaoke_url);
	        return $taobaoke_url;
		}

	    $taobaoke_tu_url = $this->get_redirect_url($taobaoke_url);
	    //var_dump("<br>taobaoke_tu_url=".$taobaoke_tu_url);

	    $taobao_item_url = $this->get_taobao_item_url($taobaoke_tu_url);
	    //var_dump("<br>taobao_item_url=".$taobao_item_url);
	    return $taobao_item_url;
	}

	// 采集一个淘宝宝贝
	//	如果宝贝已经存在系统中，则忽略。
	//	如果宝贝已经下架，则根据输入参数处理。
	//	如果宝贝价格>10，根据输入参数处理。
	//
	//	$data = array (
	//		"seller_id" => "",
	//		"cid" => "3",
	//		"title" => "xxxxx",
	//		"img" => "xxx.jpg",
	//		"url" => "",
	//		"item_key" => "taobao_xxxxx",
	//		"sid" => "1",
	//		"hits" => "",
	//		"likes" => "",
	//		"seo_title" => "",
	//		"seo_desc" => "",
	//		"is_focus" => "",
	//		"remark1" => "39.60 - 70.00");
	public function collect_one_taobao_item($category_name, $taobao_url, $collect_inactive, $collect_higher_price) {
		import("@.ORG.Taobao");
		$taobao=new Taobao();

		//var_dump($taobao_url);

		// 调用taobao api获取商品信息
		$item = $taobao->item($taobao_url);


		//var_dump($item);
		
		// 保存宝贝到数据库，注意我们或许已经添加了该宝物
		$items = M('Items');
		$items_site = M('ItemsSite');
		$items_tags = M('ItemsTags');
		$items_tags_item = M('ItemsTagsItem');
		$items_cate = M('ItemsCate');

		$data=$items->create();

		if (!$item['active'])
			$data['status'] = 2;

		if ($item['price'] > 10)
			$data['status'] = 3;

		// 标题
		$data['title'] = strip_tags($item['title']);

		$title_temp = $data['title'];
		if (preg_match('/【九块邮独享】(.*)/si', $title_temp, $matches) && isset($matches)) {
			$data['title']  = $matches[1];
		}

		$title_temp = $data['title'];
		if (preg_match('/【九快邮独享】(.*)/si', $title_temp, $matches) && isset($matches)) {
			$data['title']  = $matches[1];
		}

		$title_temp = $data['title'];
		if (preg_match('/【九元购独享】(.*)/si', $title_temp, $matches) && isset($matches)) {
			$data['title']  = $matches[1];
		}

		// 添加时间
		$data['add_time']=time();

		// 暂时不管uid
		$data['uid']=0;

		//审核状态，默认为0
		$data['status']=0;

		$data['info']= "";

		$data['item_key'] = $item['item_key'];
		$data['img'] = $item['img'][0];
		$data['url'] = $item['url'];
		$data['remark1'] = $item['remark1'];

		$data['cid'] = 34;
		$data['sid'] = $item['sid'];

		$data['price'] = $item['price'];

		switch ($category_name) {
			case 'fushi':
				$data['cid'] = 1;
				break;
			case 'shixiang':
				$data['cid'] = 2;
				break;
			case 'xiebao':
				$data['cid'] = 3;
				break;
			case 'meishi':
				$data['cid'] = 6;
				break;
			case 'jujia':
				$data['cid'] = 32;
			case 'qita':
				$data['cid'] = 34;
				break;
		}

		//var_dump($data);


		if ($item['title']=='') {
			//var_dump($item);
			echo "商品为空，不用惊慌。<br>";
			var_dump($taobao_url);
			//$this->error('标题不能为空！');
			//return false;
		}

		// 判断数据库中是否已经存在此数据。
		if($item['item_key'] != ''){
			$where['item_key']  = array('eq',$item['item_key']);
		}else {
			$where['url']  = array('eq',$item['url']);
		}

		$where['is_del']  = array('eq',0);

		//如果添加的商品存在，获得商品的id、cid
		//	id -商品id
		//	cid - 商品类别id
		$existed_item = $items->field('id,cid')->where($where)->find();

		//商品存在则将分类中item_nums减1，不存在则添加，新的分类item_nums加1
		if ($existed_item){
			$items_cate->where("id='".$existed_item['cid']."'")->setDec('item_nums');
			$result1 = $items->where($where)->save($data);
			$new_item_id=$existed_item['id'];
		}else {
			$new_item_id=$result2=$items->add($data);
		}

		$items_cate->where("id='".$data['cid']."'")->setInc('item_nums');

				
		//处理标签
		//	我们暂时不管标签
		// if ($existed_item){						
		// 	//已存在商品，先将标签中item_nums减1,删除旧的标签和商品关系
		// 	$old_tag=$items_tags_item->field('tag_id')->where("item_id='".$existed_item['id']."'")->select();
		// 	foreach ($old_tag as $tag){
		// 		$items_tags->where("id='".$tag['tag_id']."'")->setDec('item_nums'); 
		// 	}							
		// 	$items_tags_item->where("item_id='".$add_item['id']."'")->delete();//删除标签和商品关系	
		// }
		
		// $tags = isset($_POST['tags']) && trim($_POST['tags']) ? trim($_POST['tags']) : '';	
		// if ($tags) {				
		// 	//标签不存在则添加，更新标签和商品关系
		// 	$tags_arr = explode(' ', $tags);
		// 	$tags_arr = array_unique($tags_arr);
		// 	foreach ($tags_arr as $tag) {
		// 		$isset_id = $items_tags->field('id')->where("name='".$tag."' and pid='".$data['cid']."'")->find();
		// 		if ($isset_id) {
		// 			$items_tags_item->add(array(
		// 					'item_id' => $new_item_id,
		// 					'tag_id' => $isset_id['id'],
		// 			));
		// 			$items_tags->where("id='".$isset_id['id']."'")->setInc('item_nums'); //标签item_nums加1
		// 		} else {
		// 			$tag_id = $items_tags->add(array('name' => $tag,'pid' => $data['cid'],));
		// 			$items_tags_item->add(array(
		// 					'item_id' => $new_item_id,
		// 					'tag_id' => $tag_id,
		// 			));
		// 			$items_tags->where("id='".$tag_id."'")->setInc('item_nums'); //标签item_nums加1
		// 		}
		// 	}
		// } // if($tags)


		// 添加成功
		return true;
	}

	public function day_less_than($first, $second) {
		$first_day = (int)($first / 86400);
		$second_day = (int)($second / 86400);

		// var_dump($first_day);
		// var_dump($second_day);

		return $first_day < $second_day;
	}

	public function day_equal_to($first, $second) {
		$first_day = (int)($first / 86400);
		$second_day = (int)($second / 86400);

		return $first_day == $second_day;
	}

	public function day_greater_than($first, $second) {
		$first_day = (int)($first / 86400);
		$second_day = (int)($second / 86400);

		//var_dump($first_day);
		//var_dump($second_day);

		return $first_day > $second_day;
	}

	// 获取一个九块邮商品的时间
	//	输入，类似 5月29日10时00分
	public function get_jiukuaiyou_time($timestamp) {
		if ($timestamp=='')
			return null;

		preg_match('/(\d{1,2})月(\d{1,2})日(\d{1,2})时(\d{1,2})分/', $timestamp, $matches);
		$date = mktime($matches[3], $matches[4], 0, $matches[1], $matches[2], 2013);

		return $date;
	}

    function url_exists($url){
        $url = str_replace("http://", "", $url);
        if (strstr($url, "/")) {
            $url = explode("/", $url, 2);
            $url[1] = "/".$url[1];
        } else {
            $url = array($url, "/");
        }

        $fh = fsockopen($url[0], 80);
        if ($fh) {
            fputs($fh,"GET ".$url[1]." HTTP/1.1\nHost:".$url[0]."\n\n");
            if (fread($fh, 22) == "HTTP/1.1 404 Not Found") { return FALSE; }
            else { return TRUE;    }

        } else { return FALSE;}
    }

	// 采集九块邮数据
	// $collect_categories - 需要采集的类别
	// $ start_end_date - 采集的开始结束时间
	public function collect_jiukuaiyou_items($collect_categories, $start_end_date) {
		if ($start_end_date && isset($start_end_date)) {
			$start_time = $start_end_date['start_time'];
			$end_time = $start_end_date['end_time'];
		}
		else {
			$start_time = time();
			$end_time = time();
		}

		// var_dump($start_time);
		// var_dump($end_time);

		// var_dump($collect_categories);

		foreach ($collect_categories as $category_name => $category_val) {
			// var_dump("<br>name=".$category_name);
			// var_dump("<br>val=".$category_val);

			if ($category_val==false)
				continue;	// 我们不采集此种类型的商品

			// $url = "http://ju.jiukuaiyou.com/jiu/fushi/whole/new/all/1";
			$url_template= "http://ju.jiukuaiyou.com/jiu/".$category_name."/whole/new/all/";

			$finished = false;

			// 我们最多找5页
			for ($page_index = 1; $page_index < 5; $page_index ++) {

				if ($finished)
					break;

				$url = $url_template.$page_index;

				//var_dump($url);

				// 网页不存在，完成！
				if (!$this->url_exists($url)){
					echo "网页".$url."不存在<br>";
					break;
				}

				//var_dump($url);

				$html = file_get_contents($url);

				$pattern = "/<span class=\"begin_time\">开始：(.*?)<\/span>.*?<div class=\"buy_content\".*?<a target=\"_blank\" href=\"(.*?)\" class=\"buy_action clearfix\">/si";

				preg_match_all($pattern, $html, $matches);

				//var_dump($matches);

				for ($index = 0; $index < count($matches[2]) && !$finished; $index++) {
        			$item_url = $matches[2][$index];
        			$time_stamp = $matches[1][$index];

        			$date = $this->get_jiukuaiyou_time($time_stamp);

        			// var_dump("<br>date=".$date);
        			// var_dump("<br>start_time=".$start_time);
        			// var_dump("<br>end_time=".$end_time);

        			if ($this->day_less_than($date, $start_time)) {
        				var_dump("date less than start_time, finishing...");
        				$finished = true;

        				var_dump("<br>date=".$date);
        				var_dump("<br>start_time=".$start_time);
        				var_dump("<br>end_time=".$end_time);
        				break;
        			}

        			if ($this->day_greater_than($date, $end_time)) {
        				var_dump("date greater than end_time");
        				var_dump("<br>date=".$date);
        				var_dump("<br>start_time=".$start_time);
        				var_dump("<br>end_time=".$end_time);
        				continue;
        			}

        			
        			// 采集此商品

        			$taobao_url = $this->get_jiukuaiyou_item_taobao_url($item_url);

        			if ($taobao_url=='') {
        				echo "获取淘宝宝贝地址失败<br>".$item_url."<br>";
        				continue;
        				//$finished = true;
        				//break;
        			}

        			echo "准备从".$taobao_url."采集商品数据<br/>";
        			$this->collect_one_taobao_item($category_name, $taobao_url, /*collect_inactive*/true, /*collect_higher_price*/true);
        			//$finished = true;
   				} 

			} 
		} // foreach category
	}	// collect_jiukuaiyou_items

	// 采集指定时间内的九块邮商品
	//		如果未指定时间，则采集当天商品
	public function collect_jiukuaiyou_between_specific_times() {

		if (!isset($_POST['submit']))
			return;

		// 这个函数的执行可能需要很长时间 :)
		set_time_limit(0);

		// 用户选择采集哪些类别？
		$fushi=trim($_POST['fushi']);
		$shishang = trim($_POST['shishang']);
		$xiebao = trim($_POST['xiebao']);
		$meishi = trim($_POST['meishi']);
		$jujia = trim($_POST['jujia']);
		$qita = trim($_POST['qita']);

		// 用户至少选择一种采集类别
		if ($fushi == false && $shishang==false && $xiebao ==false && $meishi==false && $jujia==false && $qita==false)
			$this->error("没有选中任何类别");

		// 把等待采集类别放到一个array里面
		$collect_categories = array("fushi" => $fushi,
			"shishang" => $shishang,
			"xiebao" => $xiebao,
			"meishi" => $meishi,
			"jujia" => $jujia,
			"qita" => $qita);

		//var_dump($collect_categories);

		$time_start = isset($_POST['time_start']) && trim($_POST['time_start']) ? trim($_POST['time_start']) : '';
		$time_end = isset($_POST['time_end']) && trim($_POST['time_end']) ? trim($_POST['time_end']) : '';

		if ($time_start =='' || $time_end =='') {
			$time_start_int = time();
			$time_end_int = time();
		}
		else {
			$time_start_int = strtotime($time_start);
			$time_end_int = strtotime($time_end);
		}
		// var_dump($time_start_int);
		// var_dump($time_end_int);

		// 开始采集
		 $this->collect_jiukuaiyou_items($collect_categories, array("start_time"=>$time_start_int,
   			"end_time" => $time_end_int));

   		//$this->success('采集九块邮商品成功',U('Items/collect_jiukuaiyou'));
	}	// collect_jiukuaiyou_between_specific_times


	// 采集九块邮当天商品
	//		http://ju.jiukuaiyou.com/jiu/fushi/whole/new/all/1
	public function collect_jiukuaiyou_today() {

		// 这个函数的执行可能需要很长时间 :)
		set_time_limit(0);

		$fushi=trim($_POST['fushi']);
		$shishang = trim($_POST['shishang']);
		$xiebao = trim($_POST['xiebao']);
		$meishi = trim($_POST['meishi']);
		$jujia = trim($_POST['jujia']);
		$qita = trim($_POST['qita']);

		$collect_categories = array("fushi" => $fushi,
			"shishang" => $shishang,
			"xiebao" => $xiebao,
			"meishi" => $meishi,
			"jujia" => $jujia,
			"qita" => $qita);

		//var_dump($collect_categories);

		$time_start = isset($_POST['time_start']) && trim($_POST['time_start']) ? trim($_POST['time_start']) : '';
		$time_end = isset($_POST['time_end']) && trim($_POST['time_end']) ? trim($_POST['time_end']) : '';

		// var_dump($time_start);
		// var_dump($time_end);

		if ($time_start)
			$time_start_int = strtotime($time_start);

		if ($time_end)
			$time_end_int = strtotime($time_end);

   		$this->collect_jiukuaiyou_items($collect_categories, array("start_time"=>$time_start_int,
   			"end_time" => $time_end_int));

   		$this->ajaxReturn($item);
	}

	//收集商品信息
	public function collect(){
		
		$items = M('Items');
		$items_cate = M('ItemsCate');
		$items_site = M('ItemsSite');
		$items_tags = M('ItemsTags');
		$items_tags_item = M('ItemsTagsItem');
		
		if (isset($_POST['url'])){
			
			header("Content-type: text/xml; charset=utf-8");
			
			//获取商品URL
			$url=trim($_POST['url']);
			$url=match_url($url);
			$fp = fopen($url, 'r');
			if (!$fp){
				$this->ajaxReturn(false);
			}
			
			//获得商品来源
			$domain=gain_domain($url);
			$site = $items_site->field('id,alias')->where("site_domain='".$domain."'")->find();

			if ($site['alias'] == 'taobao' || $site['alias'] == 'tmall'){
				import("@.ORG.Taobao");
				$taobao=new Taobao();
				$this->ajaxReturn($taobao->item($url));
			}elseif ($site['alias'] == 'paipai'){
				import("@.ORG.Paipai");
				$paipai=new Paipai();
				$this->ajaxReturn($paipai->item($url));
			}elseif ($site['alias'] == 'dangdang'){
				import("@.ORG.Dangdang");
				$dangdang=new Dangdang();
				$this->ajaxReturn($dangdang->item($url));
			}elseif ($site['alias'] == 'vancl'){
				import("@.ORG.Vancl");
				$vancl=new Vancl();
				$this->ajaxReturn($vancl->item($url));
			}elseif ($site['alias'] == '360buy'){
				import("@.ORG.Jingdong");
				$jingdong=new Jingdong();
				$this->ajaxReturn($jingdong->item($url));
			}elseif ($site['alias'] == 'caomeipai'){
				import("@.ORG.Caomeipai");
				$caomeipai=new Caomeipai();
				$this->ajaxReturn($caomeipai->item($url));
			}elseif ($site['alias'] == 'mbaobao'){
				import("@.ORG.Mbaobao");
				$mbaobao=new Mbaobao();
				$this->ajaxReturn($mbaobao->item($url));
			}elseif ($site['alias'] == 'nala'){
				import("@.ORG.Nala");
				$nala=new Nala();
				$this->ajaxReturn($nala->item($url));
			}
		}else {
			
			//分类循环
			$result = $items_cate->where('is_del = 0')->order('ord desc')->select();
			$cate_list = array();
			foreach ($result as $val) {
				if ($val['pid'] == 0) {
					$cate_list['parent'][$val['id']] = $val;
				} else {
					$cate_list['sub'][$val['pid']][] = $val;
				}
			}
			
			//获得来源
			$site_list = $items_site->field('id,name,alias')->select();
			$this->assign('site_list',$site_list);
			$this->assign('cate_list',$cate_list);
			$this->display();
		}

	}
	
	
	//添加商品
	public function add(){
		set_time_limit(0);
		if (isset($_POST['submit'])){

			$items = M('Items');
			$items_cate = M('ItemsCate');
			$items_site = M('ItemsSite');
			$items_tags = M('ItemsTags');
			$items_tags_item = M('ItemsTagsItem');
			$user = M('User');

			if ($_POST['title']==''){
				$this->error('标题不能为空！');
			}
			
			$data=$items->create();
			if (!$data){
				$this->error($items->getError());
			}

			//var_dump($data);

			//	$data = array (
			//		"seller_id" => "",
			//		"cid" => "3",
			//		"title" => "xxxxx",
			//		"img" => "xxx.jpg",
			//		"url" => "",
			//		"item_key" => "taobao_xxxxx",
			//		"sid" => "1",
			//		"hits" => "",
			//		"likes" => "",
			//		"seo_title" => "",
			//		"seo_desc" => "",
			//		"is_focus" => "",
			//		"remark1" => "39.60 - 70.00");
						
			//去除标题标签
			$data['title']=strip_tags($data['title']);		

			//下载远程图片
			//	默认的配置down_status为0
			if (C('down_status')==1){
				// 例子：$type = "jpg"
				$type = end(explode( '.', $data['img'] ));
				// 如果下载成功，则放到C:\xampp\htdocs\xiaojiaqian\Uploads\LocalItems目录：
				//	down_item返回此图片路径
				$data['img']=$this->down_item($data['img'], $data['item_key'].'.'.$type);
			}
			
			//保存上传图片
			if ($_FILES['upload_img']['name'] != '') {
				$dir=date("Ymd");
				mkdir('./Uploads/LocalItems/'.$dir);
				$upload_info = $this->upload('./Uploads/LocalItems/'.$dir.'/');
				$this->upload_item($upload_info[0]['savepath'].$upload_info[0]['savename'], $upload_info[0]['savename']);
				$data['img'] = C('web_path').'Uploads/LocalItems/'.$dir.'/'.$upload_info['0']['savename'];
			}		
			
			//添加商品时间
			$data['add_time']=time();
			
			//添加随机uid
			//	我们暂时不需要uid
			$user_info=$user->field(id)->where('is_sys=1')->order('rand()')->find();
			$data['uid']=$user_info['id'];
			
			//审核状态
			//	默认配置item_status是0，故默认status为1，即已审核
			$data['status']=(C('items_status')+1)%2;
			
			//分享介绍关键词过滤
			$data['info']=$this->filter($data['info']);
			
			// 判断数据库中是否已经存在此数据。
			if($data['item_key'] != ''){
				$where['item_key']  = array('eq',$data['item_key']);
			}else {
				$where['url']  = array('eq',$data['url']);
			}

			$where['is_del']  = array('eq',0);

			//如果添加的商品存在，获得商品的id、cid
			//	id -商品id
			//	cid - 商品类别id
			$add_item = $items->field('id,cid')->where($where)->find();

			//商品存在则将分类中item_nums减1，不存在则添加，新的分类item_nums加1
			if ($add_item){
				$items_cate->where("id='".$add_item['cid']."'")->setDec('item_nums');
				$result1=$items->where($where)->save($data);
				$new_item_id=$add_item['id'];
			}else {
				$new_item_id=$result2=$items->add($data);
			}

			$items_cate->where("id='".$data['cid']."'")->setInc('item_nums');
			
			//处理标签
			//	我们暂时不管标签
			if ($add_item){						
				//已存在商品，先将标签中item_nums减1,删除旧的标签和商品关系
				$old_tag=$items_tags_item->field('tag_id')->where("item_id='".$add_item['id']."'")->select();
				foreach ($old_tag as $tag){
					$items_tags->where("id='".$tag['tag_id']."'")->setDec('item_nums'); 
				}							
				$items_tags_item->where("item_id='".$add_item['id']."'")->delete();//删除标签和商品关系	
			}
			
			$tags = isset($_POST['tags']) && trim($_POST['tags']) ? trim($_POST['tags']) : '';	
			if ($tags) {				
				//标签不存在则添加，更新标签和商品关系
				$tags_arr = explode(' ', $tags);
				$tags_arr = array_unique($tags_arr);
				foreach ($tags_arr as $tag) {
					$isset_id = $items_tags->field('id')->where("name='".$tag."' and pid='".$data['cid']."'")->find();
					if ($isset_id) {
						$items_tags_item->add(array(
								'item_id' => $new_item_id,
								'tag_id' => $isset_id['id'],
						));
						$items_tags->where("id='".$isset_id['id']."'")->setInc('item_nums'); //标签item_nums加1
					} else {
						$tag_id = $items_tags->add(array('name' => $tag,'pid' => $data['cid'],));
						$items_tags_item->add(array(
								'item_id' => $new_item_id,
								'tag_id' => $tag_id,
						));
						$items_tags->where("id='".$tag_id."'")->setInc('item_nums'); //标签item_nums加1
					}
				}
			}
			if ($result1){
				$this->success('修改成功',U('Items/index'));
			}elseif($result2){
				$this->success('添加成功',U('Items/index'));
			}else {
				$this->error('添加失败');
			}
		}
	}

	
	//编辑商品信息
	public function edit(){
	
		$items = M('Items');
		$items_cate = M('ItemsCate');
		$items_site = M('ItemsSite');
		$items_tags = M('ItemsTags');
		$items_tags_item = M('ItemsTagsItem');
		$id=isset($_REQUEST['id'])?$_REQUEST['id']:'';
	
		//点击提交
		if (isset($_POST['submit']) && isset($_POST['id'])){
			if (!isset($_POST['title'])){
				$this->error('标题不能为空！');
			}
			$data=$items->create();
			if ($data===false){
				$this->error($items->getError());
			}

			//保存上传图片
			if ($_FILES['upload_img']['name'] != '') {
				unset($_FILES['focus_img']);
				$dir=date("Ymd");
				mkdir('./Uploads/LocalItems/'.$dir);
				$upload_info = $this->upload('./Uploads/LocalItems/'.$dir.'/');
				$this->upload_item($upload_info[0]['savepath'].$upload_info[0]['savename'], $upload_info[0]['savename']);
				$data['img'] = C('web_path').'Uploads/LocalItems/'.$dir.'/'.$upload_info['0']['savename'];
			}			

			//保存上传焦点图片
			if ($_FILES['focus_img']['name'] != '') {
				mkdir('./Uploads/LocalItems/focus');
				$upload_info = $this->upload('./Uploads/LocalItems/focus/');
				$data['remark1'] = C('web_path').'Uploads/LocalItems/focus/'.$upload_info['0']['savename'];
			}

			//更新商品图片 by motor

				
			//获得商品的cid
			$edit_item = $items->field('cid')->where("id='".$id."'")->find();
			//将分类中item_nums减1，新的分类item_nums加1
			$items_cate->where("id='".$edit_item['cid']."'")->setDec('item_nums'); //旧的分类item_nums减1
			$items_cate->where("id='".$data['cid']."'")->setInc('item_nums'); //新的分类item_nums加1
	
			//处理标签
			$old_tag=$items_tags_item->field('tag_id')->where("item_id='".$id."'")->select();
			foreach ($old_tag as $tag){
				$items_tags->where("id='".$tag['tag_id']."'")->setDec('item_nums'); //旧的标签中item_nums减1
			}
			$items_tags_item->where("item_id='".$id."'")->delete(); //删除标签和商品关系
				
			$tags = isset($_POST['tags']) && trim($_POST['tags']) ? trim($_POST['tags']) : '';
			if ($tags) {
				//标签不存在则添加
				$tags_arr = explode(' ', $_POST['tags']);
				$tags_arr = array_unique($tags_arr);
				foreach ($tags_arr as $tag) {
					$isset_id = $items_tags->field('id')->where("name='".$tag."' and pid='".$data['cid']."' and is_del=0")->find();
					if ($isset_id) {
						$items_tags_item->add(array(
								'item_id' => $id,
								'tag_id' => $isset_id['id'],
						));
						$items_tags->where("id='".$isset_id['id']."'")->setInc('item_nums'); //标签item_nums加1
					} else {
						$tag_id = $items_tags->add(array('name' => $tag));
						$items_tags_item->add(array(
								'item_id' => $id,
								'tag_id' => $tag_id
						));
						$items_tags->where("id='".$tag_id."'")->setInc('item_nums'); //标签item_nums加1
					}
				}
			}
			
			//更新商品信息
			$result=$items->where("id='".$id."'")->save($data);
			if ($result){
				$this->success('修改成功！',U('Items/index'));
			}else {
				$this->error('商品信息没有变化！',U('Items/index'));
			}
		}else {
				
			if (!isset($_GET['id'])){
				$this->error('请选择商品！');
			}
			//获得分类
			$result = $items_cate->where('is_del=0')->order('ord desc')->select();
			$cate_list = array();
			foreach ($result as $val) {
				if ($val['pid'] == 0) {
					$cate_list['parent'][$val['id']] = $val;
				} else {
					$cate_list['sub'][$val['pid']][] = $val;
				}
			}
			//获得来源
			$site_list = $items_site->field('id,name,alias')->select();
			//获得商品信息
			$items_info = $items->where("id='".$_GET['id']."'")->find();
			$tag_arr=$items_tags_item->field('tag_id')->where("item_id='".$_GET['id']."'")->select();
			foreach ($tag_arr as $tag) {
				$tag_id[] .= $tag['tag_id'];
			}
			$map['id'] = array('in',$tag_id);
			$tag_name=$items_tags->field('name')->where($map)->select();
			foreach ($tag_name as $tag){
				$tags[] .=$tag['name'];
			}
			$items_info['tags'] = implode(' ', $tags);


		    import("@.ORG.Taobao");
			$taobao=new Taobao();
			$data = $taobao->item($items_info['url']);
			$img_list = $data['img'];
            $this->assign('img_list', $img_list);


			//赋值变量，输出模板
			$this->assign('cate_list', $cate_list);
			$this->assign('site_list', $site_list);
			$this->assign('items', $items_info);
			$this->display();
		}
	}

	
	//删除商品
	public function delete(){
		if (!isset($_POST['id'])){
			$this->error('请选择要删除的商品！');
		}
		$del_id = $_POST['id'];
		foreach ($del_id as $id){
			$this->delete_item($id);
		}
		$this->success('删除成功！');	
	}
	
	
	//批量添加商品
	public function betchadd(){
		set_time_limit(0);
		$items = M('Items');
		$items_cate = M('ItemsCate');
		$items_site = M('ItemsSite');
		$items_tags = M('ItemsTags');
		$items_tags_item = M('ItemsTagsItem');
		
		if (isset($_POST['urls'])){
			
			//记录操作信息
			$success_update_list=array();
			$success_insert_list=array();
					
			$cid=$_POST['cid'];
			$url=trim($_POST['urls']);
			$seller_id=$_POST['seller_id'];

			//获取商品URL
			$url=trim($url);
			$url=match_url($url);

			//获得商品来源
			$domain=gain_domain($url);
			$site = $items_site->field('id,alias')->where("site_domain='".$domain."'")->find();

			if ($site['alias'] == 'taobao' || $site['alias'] == 'tmall'){
				import("@.ORG.Taobao");
				$taobao=new taobao();
				$result=$taobao->betchitem($url,$cid,$seller_id);
			}elseif ($site['alias'] == 'paipai'){
				import("@.ORG.Paipai");
				$paipai=new Paipai();
				$result=$paipai->betchitem($url,$cid);
			}elseif ($site['alias'] == 'dangdang'){
				import("@.ORG.Dangdang");
				$dangdang=new Dangdang();
				$result=$dangdang->betchitem($url,$cid);
			}elseif ($site['alias'] == 'vancl'){
				import("@.ORG.Vancl");
				$vancl=new Vancl();
				$result=$vancl->betchitem($url,$cid);
			}elseif ($site['alias'] == '360buy'){
				import("@.ORG.Jingdong");
				$jingdong=new Jingdong();
				$result=$jingdong->betchitem($url,$cid);
			}elseif ($site['alias'] == 'caomeipai'){
				import("@.ORG.Caomeipai");
				$caomeipai=new Caomeipai();
				$result=$caomeipai->betchitem($url,$cid);
			}elseif ($site['alias'] == 'mbaobao'){
				import("@.ORG.Mbaobao");
				$mbaobao=new Mbaobao();
				$result=$mbaobao->betchitem($url,$cid);
			}elseif ($site['alias'] == 'nala'){
				import("@.ORG.Nala");
				$nala=new Nala();
				$result=$nala->betchitem($url,$cid);
			}
			$this->ajaxReturn($result);
		}else {
			
			//分类循环
			$result = $items_cate->where('is_del = 0')->order('ord desc')->select();
			$cate_list = array();
			foreach ($result as $val) {
				if ($val['pid'] == 0) {
					$cate_list['parent'][$val['id']] = $val;
				} else {
					$cate_list['sub'][$val['pid']][] = $val;
				}
			}

			$this->assign('cate_list',$cate_list);
			$this->display();
		}				
	}
	
	
	//按关键字添加
	public function addbykey(){
		set_time_limit(0);
		$items = M('Items');
		$items_cate = M('ItemsCate');
		$items_site = M('ItemsSite');
		$items_tags = M('ItemsTags');
		$items_tags_item = M('ItemsTagsItem');
		$user = M('User');
		
		if (isset($_POST['keyword'])){
			$sid=$_POST['sid'];
			$cid=$_POST['cid'];
			$condition['keyword']=$_POST['keyword'];
			$condition['cid']=$_POST['tid'];
			$condition['start_price']=$_POST['start_price'];
			$condition['end_price']=$_POST['end_price'];
			$condition['start_credit']=$_POST['start_credit'];
			$condition['end_credit']=$_POST['end_credit'];
			$condition['sort']=$_POST['sort'];
			$condition['guarantee']=$_POST['guarantee'];
			$condition['start_commissionRate']=$_POST['start_commissionRate']*100;
			$condition['end_commissionRate']=$_POST['end_commissionRate']*100;
			$condition['start_commissionNum']=$_POST['start_commissionNum'];
			$condition['end_commissionNum']=$_POST['end_commissionNum'];
			$condition['start_totalnum']=$_POST['start_totalnum'];
			$condition['end_totalnum']=$_POST['end_totalnum'];
			$condition['cash_coupon']=$_POST['cash_coupon'];
			$condition['sevendays_return']=$_POST['sevendays_return'];
			$condition['real_describe']=$_POST['real_describe'];
			$condition['cash_ondelivery']=$_POST['cash_ondelivery'];
			$condition['mall_item']=$_POST['mall_item'];
			$condition['page_no']=$_POST['page_no'];

			//获得商品来源
			$site = $items_site->field('alias')->where('id='.$sid)->find();
			
			if ($site['alias'] == 'taobao' || $site['alias'] == 'tmall'){
				import('@.ORG.Taobao');
				$taobao=new Taobao();
				$item_info=array();
				$result=$taobao->taobaokeKeyword($condition);
				if ($result == false || $result['total_results'] == 0){
					$this->ajaxReturn(0);
				}
				$item_info = $result['taobaoke_items']['taobaoke_item'];
			}
			
			if ($item_info){
				$nums=0;
				foreach ($item_info as $item){
					
//					卖家id
// 					$url = 'http://a.m.tmall.com/i'.$item['num_iid'].'.htm';
// 					$content = file_get_contents($url);
// 					preg_match('/<div class="left-margin-5">(.*?)进入店铺/si',$content,$result);
// 					preg_match('/href="(.*)">/si',$result[1],$re);
// 					isset($re) ? $shop_url = $re[1] : $shop_url = '';
// 					if ($shop_url){
// 						unset($content);
// 						unset($result);
// 						$content = file_get_contents($shop_url);
// 						preg_match('/userId (\d+)/si',$content,$result);
// 						isset($result) ? $seller_id = $result[1] : $seller_id = '';
// 					}else {
// 						$seller_id = '';
// 					}
					
//					网页端抓去卖家id，已受限制
// 					$url = 'http://detail.tmall.com/item.htm?id='.$item['num_iid'];
// 					$content = file_get_contents($url);
// 					preg_match('/userid=(\d+)?/si',$content,$result);
// 					isset($result) ? $seller_id = $result[1] : $seller_id = '';
					
					if (strlen($item['click_url']) < 10){
						continue;
					}
					//格式化标题
					$title=strip_tags($item['title']);
					
					//获得标签
					$tags=$this->get_tags($title);
					
					//获取图片
					$img=$item['pic_url'];
					
					//商品添加时间
					$add_time=time();
					
					//获得item_key
					$item_key=$site['alias'].'_'.$item['num_iid'];
					
					//下载远程图片
					if (C('down_status')==1){
						$type = end(explode( '.', $img ));
						$img=$this->down_item($img, $item_key.'.'.$type);
					}
					
					//获取随机uid
					$user_info=$user->field(id)->where('is_sys=1')->order('rand()')->find();
					
					//审核状态
					$status=(C('items_status')+1)%2;
					
					//数据
					$data['seller_id']='';
					$data['title']=strip_tags($title);
					$data['url']=$item['click_url'];
					$data['tag']=$tags;
					$data['price']=$item['price'];
					$data['item_key']=$item_key;
					$data['sid']=$sid;
					$data['cid']=$cid;
					$data['img']=$img;
					$data['add_time']=$add_time;
					$data['uid']=$user_info['id'];
					$data['status']=$status;
					
					if($data['item_key'] != ''){
						$where['item_key']  = array('eq',$data['item_key']);
					}else {
						$where['url']  = array('eq',$data['url']);
					}
					$where['is_del']  = array('eq',0);
					//如果添加的商品存在，获得商品的id、cid
					$add_item = $items->field('id,cid')->where($where)->find();
						
					//商品存在则将分类中item_nums减1，不存在则添加，新的分类item_nums加1
					if ($add_item){
						$items_cate->where("id='".$add_item['cid']."'")->setDec('item_nums');
						$items->where($where)->save($data);
						$new_item_id=$add_item['id'];
					}else{
						$new_item_id=$items->add($data);
					}
					if ($new_item_id){
						$nums++;
					}else {
						continue;
					}
					$items_cate->where("id='".$data['cid']."'")->setInc('item_nums'); //分类item_nums加1
					
					//处理标签
					if ($add_item){
						//已存在商品，先将标签中item_nums减1,删除旧的标签和商品关系，添加新的标签和商品关系
						$old_tag=$items_tags_item->field('tag_id')->where("item_id='".$add_item['id']."'")->select();
						foreach ($old_tag as $tag){
							$items_tags->where("id='".$tag['tag_id']."'")->setDec('item_nums');
						}
						//删除标签和商品关系
						$items_tags_item->where("item_id='".$add_item['id']."'")->delete();
					}
					
					if ($tags) {
						//标签不存在则添加
						foreach ($tags as $tag) {
							$isset_id = $items_tags->field('id')->where("name='".$tag."' and pid='".$cid."'")->find();
							if ($isset_id) {
								$items_tags_item->add(array(
										'item_id' => $new_item_id,
										'tag_id' => $isset_id['id'],
								));
								$items_tags->where("id='".$isset_id['id']."'")->setInc('item_nums'); //标签item_nums加1
							} else {
								$tag_id = $items_tags->add(array('name' => $tag,'pid' => $cid));
								$items_tags_item->add(array(
										'item_id' => $new_item_id,
										'tag_id' => $tag_id,
								));
								$items_tags->where("id='".$tag_id."'")->setInc('item_nums'); //标签item_nums加1
							}
						}
					}
				}
				$this->ajaxReturn($nums);
			}			
		}else {
			
			//淘宝分类循环		
			import("@.ORG.Taobao");
			$taobao=new Taobao();
			$cid='0';
			$taobao_cate_list=$taobao->taobaoCateInfo($cid);
			$taobao_cate_info=$taobao_cate_list['item_cats']['item_cat'];
			
			//分类循环
			$result = $items_cate->where('is_del = 0')->order('ord desc')->select();
			$cate_list = array();
			foreach ($result as $val) {
				if ($val['pid'] == 0) {
					$cate_list['parent'][$val['id']] = $val;
				} else {
					$cate_list['sub'][$val['pid']][] = $val;
				}
			}

			$where['alias']='taobao';
			//获得来源
			$site_list = $items_site->field('id,name,alias')->where($where)->select();
			
			//获取标签
			$map['sid']=array('neq',0);
			$map['is_index']=1;
			$map['is_del']=0;
			$tags = $items_tags->field('id,pid,name')->where($map)->select();
			foreach ($tags as $val) {				
				$tag_list[$val['pid']][] = $val;
			}
			
			$this->assign('taobao_cate_info',$taobao_cate_info);
			$this->assign('tag_list',$tag_list);					
			$this->assign('site_list',$site_list);			
			$this->assign('cate_list',$cate_list);
			$this->display();
		}
		
	}
	
	//获取淘宝分类
	public function get_taobao_cate(){
		$cid=$_POST['tid'];	
		import("@.ORG.Taobao");
		$taobao=new Taobao();
		$taobao_cate_list=$taobao->taobaoCateInfo($cid);
		$data=$taobao_cate_list['item_cats']['item_cat'];
		if ($data){
			$this->ajaxReturn($data);
		}else {
			$this->ajaxReturn(false);
		}
	}
			
	//排序
	public function order(){
	
		if ($_POST['order']){
			$items = M('Items');
			foreach ($_POST['orders'] as $id => $ord) {
				$data['ord'] = $ord;
				$items->where('id='.$id)->save($data);
			}
			$this->success('修改成功！');
		}
	}
	
	//修改状态
	public function status() {
		$id = $_GET['id'];
		$type = $_GET['type'];
		$items = M('items');
		$data['id']=$id;
		$set[$type]=array('exp',"($type+1)%2");
		$items->where($data)->save($set);
		$val=$items->field($type)->where($data)->find();
		$this->ajaxReturn($val[$type]);
	}
	
	//更新taobao、tmall商品卖家id
	public function update_seller_id(){
		set_time_limit(0);
		$items = M('items');
		$item_list=$items->field('id,item_key')->where('seller_id=0')->select();
		foreach ($item_list as $item){
			$result=explode('_', $item['item_key']);
			if ($result[0] == 'taobao' || $result[0] == 'tmall'){
				$url = 'http://a.m.tmall.com/i'.$result[1].'.htm';
				$content = file_get_contents($url);
				import("@.ORG.Taobao");
				$taobao=new taobao();
				unset($result);
				//获得商品图片
				$seller_id=$taobao->match_seller_id($content);
				unset($content);
				$where['id']=$item['id'];
				$data['seller_id']=$seller_id;
				$items->where($where)->save($data);
			}
		}
		$this->success('更新卖家id完成！',U('Items/index'));
	}
	
	//更新商品图片
	public function update_img(){
		set_time_limit(0);
		$items = M('items');
		$item_list=$items->field('id,img,item_key')->where('is_del=0')->select();
		dump($item_list);exit();
		foreach ($item_list as $item){
			preg_match('/^(http:\/\/)/si',$item['img'],$re);
			if ($re){
				continue;
			}
			unset($re);
			$result=explode('_', $item['item_key']);
			$url = 'http://a.m.tmall.com/i'.$result[1].'.htm';
			$content = file_get_contents($url);
			if ($result[0] == 'taobao' || $result[0] == 'tmall'){
				import("@.ORG.Taobao");
				$fp=new taobao();
			}elseif ($result[0] == 'paipai'){
				import("@.ORG.Paipai");
				$fp=new Paipai();
			}elseif ($result[0] == 'dangdang'){
				import("@.ORG.Dangdang");
				$fp=new Dangdang();
			}elseif ($result[0] == 'vancl'){
				import("@.ORG.Vancl");
				$fp=new Vancl();
			}elseif ($result[0] == '360buy'){
				import("@.ORG.Jingdong");
				$fp=new Jingdong();
			}elseif ($result[0] == 'caomeipai'){
				import("@.ORG.Caomeipai");
				$fp=new Caomeipai();
			}elseif ($result[0] == 'mbaobao'){
				import("@.ORG.Mbaobao");
				$fp=new Mbaobao();
			}elseif ($result[0] == 'nala'){
				import("@.ORG.Nala");
				$fp=new Nala();
			}
			unset($result);
			//获得商品图片
			if ($fp){
				$img=$fp->match_image($content);
				$type = end(explode( '.', $img ));
				$image = explode( '.'.$type, $img );
				$img=$image[0].'.'.$type;
				unset($content);
								
				$where['id']=$item['id'];
				$data['img']=$img;
				$items->where($where)->save($data);
			}

		}
		$this->success('更新商品图片完成！',U('Items/index'));
	}
	
	//更新taobao、tmall商品链接
	public function update_url(){
		set_time_limit(0);
		$items = M('items');
		$item_list=$items->field('id,item_key')->where('is_del=0')->select();
		foreach ($item_list as $item){
			$result=explode('_', $item['item_key']);
			if ($result[0] == 'taobao' || $result[0] == 'tmall'){
				import("@.ORG.Taobao");
				$taobao=new taobao();
				//获得淘宝客跳转链接
				$url = $taobao->gain_url($result[0], $result[1]);
				if (!$url){
					$url='http://detail.tmall.com/item.htm?id='.$result[1];
				}
				unset($result);
				$where['id']=$item['id'];
				$data['url']=$url;
				$items->where($where)->save($data);
			}
		}
		$this->success('更新商品链接完成！',U('Items/index'));
	}

	//删除商品方法
	public function delete_item($id){
	
		$items = M('Items');
		$items_cate = M('ItemsCate');
		$items_site = M('ItemsSite');
		$items_tags = M('ItemsTags');
		$items_tags_item = M('ItemsTagsItem');
	
		//分类中item_nums减1
		$cid=$items->field('cid')->where("id='".$id."'")->find();
		$items_cate->where("id='".$cid['cid']."'")->setDec('item_nums');
		//标签中item_nums减1
		$data['item_id']=$id;
		$old_tag=$items_tags_item->field('tag_id')->where($data)->select();
		foreach ($old_tag as $tag){
			$items_tags->where("id='".$tag['tag_id']."'")->setDec('item_nums');
		}
		//用户的likes_num减1，删除山品和用户喜欢关系
		$user_mod=M("User");
		$itemslikes_mod=M("ItemsLikes");
		$items_likes_list=$itemslikes_mod->field("uid")->where("items_id=$id")->select();
		$itemslikes_mod->where("items_id=$id")->delete();
		foreach($items_likes_list as $val){
			$uid=$val['uid'];
			$user_mod->where("id=$uid and is_del=0")->setDec("likes_num");
		}
		//删除商品信息及商品和标签关系
		$save['is_del']=1;
		$row = $items->where("id='".$id."'")->save($save);
		$items_tags_item->where($data)->delete();
		//删除用户评论信息
		$itemscommengs=M('ItemsComments');
		$itemscommengs->where("items_id=$id and is_del=0")->setField("is_del",1);	
		//删除商品和专辑关系
		$albumitems=M('AlbumItems');
		$albumitems->where("items_id=$id")->delete();
		if (!$row){
			$this->error('删除失败！');
			exit();
		}
	}
}

