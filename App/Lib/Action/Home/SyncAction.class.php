<?php

class SyncAction extends BaseAction {

// 更新一个宝贝信息。
//	输入：$item - 本地宝贝信息
//  返回：TRUE - 更新了宝贝, FALSE - 没有更新宝贝
public function sync_item_data($item) {
	import("@.ORG.Taobao");
	$taobao=new Taobao();

	$firephp = get_fire_php();

	$item_id = $item['id'];
	$item_key = $item['item_key'];		// such as : taobao_16554250670
	$item_price = $item['price'];

	echo "Sync data for item with id=$item_id<br>";

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

	//$firephp->log($new_price, "latest price=");

	// 获取宝贝状态：在售？下架？
	$active = $taobao->match_status( $item_html );

	if (!$active)
		//$firephp->log($active ? "##ACTIVE##" : "##INACTIVE##", "item with id='$item_id' status=");
		echo "Item with id=$item_id status=INACTIVE<br>";

	if ($active) {
		$items = M('items');

		//$firephp->log($item_price, "our price=");

		// $new_price maybe like '8.91-9.90'.
		if (strpos($new_price, '-')){
			//$firephp->log($item_price, "item_price=");

			$min_max_prices = explode("-", $new_price);
			$min_price = $min_max_prices[0];
			$max_price = $min_max_prices[1];

			//$firephp->log("min=$min_price, max=$max_price", "");
			echo "min=$min_price, max=$max_price<br>";

			$new_price = $min_price;
		}

		//$firephp->log($item_price, "our price=");

		if ($new_price > $item_price) {
			// 如果商品的最新价格>9.9，下架！
			if ($new_price > 10) {
				$data['status']=3;
				$where['id']=$item_id;
				$items->where($where)->save($data);
				//$firephp->log("Item with id='$item_id' price is too high (cur=$new_price, prev=$item_price), make it as inactive", "");
				echo "Item with id='$item_id' price is too high (cur=$new_price, prev=$item_price), change its status to 3<br>";
				return true;
			}

			// 更新商品价格
			$data['price']=$new_price;
			$items->where($where)->save($data);
			return true;
		}

	}
	else {
		// Inactive, update the item status to "inactive".
		$items = M('items');
		$where['id']=$item_id;
		$data['status']=2;
		$items->where($where)->save($data);

		//$firephp->log(array(
		//	"Update item to inactive with id=" => $item_id));
		echo "Item with id=$item_id has been sold out on taobao.com, update item's status to 2 <br>";
	}

	return true;
}


	public function index(){

		ini_set("max_execution_time", 0);

		//$firephp = get_fire_php();

		$items_mod=M("Items");
		$items_list = $items_mod->where('status = 1')->order("add_time desc")->select();

		foreach($items_list as $item) {

			$this->sync_item_data($item);
		}
		
		$this->display();
	}


	
}