<?php
class LoginAction extends Action{

	public function login(){
		$type =  $_REQUEST['type'];
		empty($type) && $this->error('参数错误');

		//加载ThinkOauth类并实例化一个对象
		import("ORG.ThinkSDK.ThinkOauth");
		$sns  = ThinkOauth::getInstance($type);

		//跳转到授权页面
		redirect($sns->getRequestCodeURL());
	}

	//授权回调地址
	public function callback($type = null, $code = null){
		$type = $_REQUEST['type'];
		$code = $_REQUEST['code'];

		(empty($type) || empty($code)) && $this->error('参数错误');
		
		//加载ThinkOauth类并实例化一个对象
		import("ORG.ThinkSDK.ThinkOauth");
		$sns  = ThinkOauth::getInstance($type);

		//腾讯微博需传递的额外参数
		$extend = null;
		if($type == 'tencent'){
			$extend = array('openid' => $this->_get('openid'), 'openkey' => $this->_get('openkey'));
		}

		//请妥善保管这里获取到的Token信息，方便以后API调用
		//调用方法，实例化SDK对象的时候直接作为构造函数的第二个参数传入
		//如： $qq = ThinkOauth::getInstance('qq', $token);
		$token = $sns->getAccessToken($code , $extend);

		//获取当前登录用户信息
		if(is_array($token)){
			$user_info = A('Home/Login');
			$user_info = $user_info->$type($token);

			// 存入session
			
			$_SESSION ['token'] = $token;
			$_SESSION ['openid'] = $token ['openid'];
			$_SESSION ['access_token'] = $token ['access_token'];

			// 查找OpenId ，是否已经注册过
			$user_openid_mod = M("user_openid");
			$condition = array(
				"openid" => $token['openid'] ,
				"type" => $type
			);
			$user_openid = $user_openid_mod->where($condition)->find();

			if ($user_openid) {
				// 已绑定
				$logined = false;
				
				$user_mod = M("User");

				// 是否已经登录
				$uid = $_COOKIE['id'];
				if($uid){
					$user_info = $user_mod->where("id=$uid")->find();
					if($user_info){
						$logined = true;
					}
				}


				if ($logedin) {
					if (! $user_openid ['uid'] == $uid) {
						$this->error ( "该微博账号已经绑定其他站内账号，请绑定其他微博，或直接使用微博登陆。", get_url ( 'sns', '', 'user' ) );
					}
				} else {
					
					echo "id='" . $user_openid ['uid'] . "'" . " and is_del=0";

					$user_info = $user_mod->where ( "id='" . $user_openid ['uid'] . "'" . " and is_del=0" )->find ();
					setcookie ( 'login_type', 'sina', time () + 3600 * 24 * 7, '/' );
					setcookie ( 'id', $user_openid ['uid'], time () + 3600 * 24 * 7, '/' );
					setcookie ( 'name', $user_info ['name'], time () + 3600 * 24 * 7, '/' );
					
					// 更新用户最后登录时间和最后登录的ip
					$user ['last_ip'] = getClientIp ();
					$user ['last_time'] = time ();
					$user_mod->where ( "id='" . $user_openid ['uid'] . "'" )->save ( $user );
					header ( 'Location:' . get_url ( 'index', '', 'user' ) );
				}
			}
			else{
				// 未绑定
				$_SESSION ['user_openid_info'] = $user_info;
				header ( 'Location:' . U('Home/Login/sign') );
			}
		}

		if (! $token) {
			$this->error ( '登录失败！', get_url('login','','user') );
			exit ();
		}
	}

	public function qq($token){
		//import("ORG.ThinkSDK.ThinkOauth");
		$qq   = ThinkOauth::getInstance('qq', $token);
		$data = $qq->call('user/get_user_info');

		if($data['ret'] == 0){
			$userInfo['type'] = 'QQ';
			$userInfo['name'] = $data['nickname'];
			$userInfo['nick'] = $data['nickname'];
			$userInfo['head'] = $data['figureurl_2'];
			return $userInfo;
		} else {
			throw_exception("获取腾讯QQ用户信息失败：{$data['msg']}");
		}
	}

	//登录成功，获取腾讯微博用户信息
	public function tencent($token){
		//import("ORG.ThinkSDK.ThinkOauth");
		$tencent = ThinkOauth::getInstance('tencent', $token);
		$data    = $tencent->call('user/info');

		if($data['ret'] == 0){
			$userInfo['type'] = 'TENCENT';
			$userInfo['name'] = $data['data']['name'];
			$userInfo['nick'] = $data['data']['nick'];
			$userInfo['head'] = $data['data']['head'];
			return $userInfo;
		} else {
			throw_exception("获取腾讯微博用户信息失败：{$data['msg']}");
		}
	}

	//登录成功，获取新浪微博用户信息
	public function sina($token){
		$sina = ThinkOauth::getInstance('sina', $token);
		$data = $sina->call('users/show', "uid={$sina->openid()}");

		if($data['error_code'] == 0){
			$userInfo['type'] = 'SINA';
			$userInfo['name'] = $data['name'];
			$userInfo['nick'] = $data['screen_name'];
			$userInfo['head'] = $data['avatar_large'];
			return $userInfo;
		} else {
			throw_exception("获取新浪微博用户信息失败：{$data['error']}");
		}
	}

	//登录成功，获取网易微博用户信息
	public function t163($token){
		$t163 = ThinkOauth::getInstance('t163', $token);
		$data = $t163->call('users/show');

		if($data['error_code'] == 0){
			$userInfo['type'] = 'T163';
			$userInfo['name'] = $data['name'];
			$userInfo['nick'] = $data['screen_name'];
			$userInfo['head'] = str_replace('w=48&h=48', 'w=180&h=180', $data['profile_image_url']);
			return $userInfo;
		} else {
			throw_exception("获取网易微博用户信息失败：{$data['error']}");
		}
	}

	//登录成功，获取人人网用户信息
	public function renren($token){
		$renren = ThinkOauth::getInstance('renren', $token);
		$data   = $renren->call('users.getInfo');

		if(!isset($data['error_code'])){
			$userInfo['type'] = 'RENREN';
			$userInfo['name'] = $data[0]['name'];
			$userInfo['nick'] = $data[0]['name'];
			$userInfo['head'] = $data[0]['headurl'];
			return $userInfo;
		} else {
			throw_exception("获取人人网用户信息失败：{$data['error_msg']}");
		}
	}

	//登录成功，获取360用户信息
	public function x360($token){
		$x360 = ThinkOauth::getInstance('x360', $token);
		$data = $x360->call('user/me');

		if($data['error_code'] == 0){
			$userInfo['type'] = 'X360';
			$userInfo['name'] = $data['name'];
			$userInfo['nick'] = $data['name'];
			$userInfo['head'] = $data['avatar'];
			return $userInfo;
		} else {
			throw_exception("获取360用户信息失败：{$data['error']}");
		}
	}

	//登录成功，获取豆瓣用户信息
	public function douban($token){
		$douban = ThinkOauth::getInstance('douban', $token);
		$data   = $douban->call('user/~me');

		if(empty($data['code'])){
			$userInfo['type'] = 'DOUBAN';
			$userInfo['name'] = $data['name'];
			$userInfo['nick'] = $data['name'];
			$userInfo['head'] = $data['avatar'];
			return $userInfo;
		} else {
			throw_exception("获取豆瓣用户信息失败：{$data['msg']}");
		}
	}

	//登录成功，获取Github用户信息
	public function github($token){
		$github = ThinkOauth::getInstance('github', $token);
		$data   = $github->call('user');

		if(empty($data['code'])){
			$userInfo['type'] = 'GITHUB';
			$userInfo['name'] = $data['login'];
			$userInfo['nick'] = $data['name'];
			$userInfo['head'] = $data['avatar_url'];
			return $userInfo;
		} else {
			throw_exception("获取Github用户信息失败：{$data}");
		}
	}

	//登录成功，获取Google用户信息
	public function google($token){
		$google = ThinkOauth::getInstance('google', $token);
		$data   = $google->call('userinfo');

		if(!empty($data['id'])){
			$userInfo['type'] = 'GOOGLE';
			$userInfo['name'] = $data['name'];
			$userInfo['nick'] = $data['name'];
			$userInfo['head'] = $data['picture'];
			return $userInfo;
		} else {
			throw_exception("获取Google用户信息失败：{$data}");
		}
	}

	//登录成功，获取Google用户信息
	public function msn($token){
		$msn  = ThinkOauth::getInstance('msn', $token);
		$data = $msn->call('me');

		if(!empty($data['id'])){
			$userInfo['type'] = 'MSN';
			$userInfo['name'] = $data['name'];
			$userInfo['nick'] = $data['name'];
			$userInfo['head'] = '微软暂未提供头像URL，请通过 me/picture 接口下载';
			return $userInfo;
		} else {
			throw_exception("获取msn用户信息失败：{$data}");
		}
	}

	//登录成功，获取点点用户信息
	public function diandian($token){
		$diandian  = ThinkOauth::getInstance('diandian', $token);
		$data      = $diandian->call('user/info');

		if(!empty($data['meta']['status']) && $data['meta']['status'] == 200){
			$userInfo['type'] = 'DIANDIAN';
			$userInfo['name'] = $data['response']['name'];
			$userInfo['nick'] = $data['response']['name'];
			$userInfo['head'] = "https://api.diandian.com/v1/blog/{$data['response']['blogs'][0]['blogUuid']}/avatar/144";
			return $userInfo;
		} else {
			throw_exception("获取点点用户信息失败：{$data}");
		}
	}

	//登录成功，获取淘宝网用户信息
	public function taobao($token){
		$taobao = ThinkOauth::getInstance('taobao', $token);
		$fields = 'user_id,nick,sex,buyer_credit,avatar,has_shop,vip_info';
		$data   = $taobao->call('taobao.user.buyer.get', "fields={$fields}");
		
		if(!empty($data['user_buyer_get_response']['user'])){
			$user = $data['user_buyer_get_response']['user'];
			$userInfo['type'] = 'TAOBAO';
			$userInfo['name'] = $user['user_id'];
			$userInfo['nick'] = $user['nick'];
			$userInfo['head'] = $user['avatar'];
			return $userInfo;
		} else {
			throw_exception("获取淘宝网用户信息失败：{$data['error_response']['msg']}");
		}
	}
	
	//登录成功，获取百度用户信息
	public function baidu($token){
		$baidu = ThinkOauth::getInstance('baidu', $token);
		$data  = $baidu->call('passport/users/getLoggedInUser');
		
		if(!empty($data['uid'])){
			$userInfo['type'] = 'BAIDU';
			$userInfo['name'] = $data['uid'];
			$userInfo['nick'] = $data['uname'];
			$userInfo['head'] = "http://tb.himg.baidu.com/sys/portrait/item/{$data['portrait']}";
			return $userInfo;
		} else {
			throw_exception("获取百度用户信息失败：{$data['error_msg']}");
		}
	}

	//登录成功，获取开心网用户信息
	public function kaixin($token){
		$kaixin = ThinkOauth::getInstance('kaixin', $token);
		$data   = $kaixin->call('users/me');
		
		if(!empty($data['uid'])){
			$userInfo['type'] = 'KAIXIN';
			$userInfo['name'] = $data['uid'];
			$userInfo['nick'] = $data['name'];
			$userInfo['head'] = $data['logo50'];
			return $userInfo;
		} else {
			throw_exception("获取开心网用户信息失败：{$data['error']}");
		}
	}

	//登录成功，获取搜狐用户信息
	public function sohu($token){
		$sohu = ThinkOauth::getInstance('sohu', $token);
		$data = $sohu->call('i/prv/1/user/get-basic-info');
		
		if('success' == $data['message'] && !empty($data['data'])){
			$userInfo['type'] = 'SOHU';
			$userInfo['name'] = $data['data']['open_id'];
			$userInfo['nick'] = $data['data']['nick'];
			$userInfo['head'] = $data['data']['icon'];
			return $userInfo;
		} else {
			throw_exception("获取搜狐用户信息失败：{$data['message']}");
		}
	}

	public function sign() {
		$this->assign ( "sty", array (
				'index',
				'usercenter' 
		) );
		$user_mod = M ( "User" );
		$user_openid_mod = M ( "user_openid" );
		if (! empty ( $_POST )) {
			$count = $user_mod->where ( "name='" . trim ( $_POST ['username'] ) . "'" )->count ();
			if ($count) {
				$this->error ( '请填写相关信息' );
			}
			
			$data ['name'] = $_POST ['username'];
			$data ['passwd'] = md5 ( $_POST ['pswd'] );
			$data ['img'] = $_POST ['img'];
			$data ['email'] = $_POST ['email'];
			$data ['add_time'] = time ();
			$data ['last_ip'] = getClientIp ();
			$data ['ip'] = getClientIp ();
			
			$user_id = $user_mod->add ( $data );
			
			$data = array (
					'type' => $_SESSION ['user_openid_info'] ['type'],
					'uid' => $user_id,
					'openid' => $_SESSION ['openid']
			);
			$user_openid_mod->add ( $data );
			
			$user_info = $user_mod->where ( "id=" . $user_id . " and is_del=0" )->find ();
			
			setcookie ( 'login_type', $_SESSION ['user_openid_info'] ['type'], time () + 3600 * 24 * 7, '/' );
			setcookie ( 'id', $user_info ['id'], time () + 3600 * 24 * 7, '/' );
			setcookie ( 'name', $user_info ['name'], time () + 3600 * 24 * 7, '/' );
			
			// 更新用户最后登录时间和最后登录的ip
			$user ['last_ip'] = getClientIp ();
			$user ['last_time'] = time ();
			$user_mod->where ( "id='" . $user_id . "'" )->save ( $user );
			
			// echo($user_openid_mod->getlastsql());
			$this->success ( "绑定成功", get_url ( 'index', '', 'user' ) );
			
		} else {
			// print_r($_SESSION);
			$user_info = array (
					"name" => $_SESSION ['user_openid_info'] ['name'] ,
					"hd" => $_SESSION ['user_openid_info'] ['head'] 
			);
			$this->assign ( "user_info", $user_info );
			$this->display ();
		}
	}

	public function check_uname_email() {
		$user_mod = M ( "User" );

		$uname = $_POST ['name'];
		$email = $_POST ['email'];
		
		if($uname){
			$name_existed = $user_mod->where ( "name='$uname' and is_del=0" )->getField ( "name" );
			if($name_existed){
				$arr = array ('success'=>false, 'message'=>'用户名已经存在');
			}
			else{
				$arr = array ('success'=>true);
			}
		}

		if($email){
			$email_existed = $user_mod->where ( "is_del=0 and email='$email'" )->getField ( "email" );
			if($email_existed){
				$arr = array ('success'=>false, 'message'=>'邮箱已经存在');
			}
			else{
				$arr = array ('success'=>true);
			}
		}

		echo urldecode(json_encode($arr));
	}
}