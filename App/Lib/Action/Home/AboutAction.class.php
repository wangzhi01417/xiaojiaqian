<?php
//关于我们
class AboutAction extends BaseAction {
	public function index(){
		$this->assign("sty",array('index','style1'));
		
		$seo ['title'] = "关于我们 - " . C ( "site_name" );
		$seo ['keys'] = C ( "site_name" ) . "关于我们，" . C ( "site_keyword" );
		$seo ['desc'] = C ( "site_name" ) . "关于我们，" . C ( "site_description" );
		$this->assign ( "seo", $seo );
		
		$this->display();
	}
	
	}