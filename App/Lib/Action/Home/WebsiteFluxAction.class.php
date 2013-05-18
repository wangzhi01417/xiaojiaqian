<?php
//首页
class WebsiteFluxAction extends BaseAction {
	//客户端IP
	private $cIP;
	
	//ref页
	private $ref;

	function __construct()
	{
		parent::__construct();

		//代理端IP
		$cIP1 = getenv('HTTP_X_FORWARDED_FOR');
		//用户IP
		$cIP2 = getenv('HTTP_CLIENT_IP');

		$this->cIP = getenv('REMOTE_ADDR');		
		$cIP1 ? $this->cIP = $cIP1 : null;
		$cIP2 ? $this->cIP = $cIP2 : null;
		
		//ref页
		$this->ref = $_SERVER['HTTP_REFERER'];
	}

	function setPV(){
		$this->setCookie();
		
		$pv_mod = M("pv");
		$data['ref_url']=$this->ref;
		$data['ip']=$this->cIP;

		$pv_mod->add($data);
	}

	function setUV(){ 
		if(!cookie('UVcookie')){
			$uv_mod = M("uv");

			$data['ref_url']=$this->ref;
			$data['ip']=$this->cIP;

			$uv_mod->add($data);
		}		
	}

	function setCookie(){
		if(!isset(cookie('UVcookie'))){
			$dead_time = strtotime(date("Y-m-d",strtotime("+1 day")));
			// if(empty($domain))
			//  $domain = '.'.$_SERVER['HTTP_HOST'];
			cookie('UVcookie', true,$dead_time);
		}
	}
}
?>
