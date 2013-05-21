<?php
//联系我们
class AnliAction extends BaseAction {
	public function index(){
		$this->assign("sty",array('index','style1'));
		
		$seo ['title'] = "联系我们 - " . C ( "site_name" );
		$seo ['keys'] = C ( "site_name" ) . "联系我们，" . C ( "site_keyword" );
		$seo ['desc'] = C ( "site_name" ) . "联系我们，" . C ( "site_description" );
		$this->assign ( "seo", $seo );
		
		$this->display();
	}
	
	}