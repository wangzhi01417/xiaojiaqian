<?php
//我要爆料
class RevealAction extends BaseAction {
	public function index(){
		$this->assign("sty",array('index','style1'));
		
		$seo ['title'] = "我要爆料 - " . C ( "site_name" );
		$seo ['keys'] = C ( "site_name" ) . "我要爆料" . C ( "site_keyword" );
		$seo ['desc'] = C ( "site_name" ) . "我要爆料" . C ( "site_description" );
		$this->assign ( "seo", $seo );
		
		$this->display();
	}
	
	}