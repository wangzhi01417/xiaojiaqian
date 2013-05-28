<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: Page.class.php 2712 2012-02-06 10:12:49Z liu21st $

class Page {
    // 分页栏每页显示的页数
    //public $rollPage = 5;
    public $rollPage = 1;
    // 页数跳转时要带的参数
    public $parameter  ;
    // 默认列表每页显示行数
    public $listRows = 20;
    // 起始行数
    public $firstRow	;
    // 分页总页面数
    protected $totalPages  ;
    // 总行数
    protected $totalRows  ;
    // 当前页数
    protected $nowPage    ;
    // 分页的栏的总页数
    protected $coolPages   ;
    // 分页显示定制
    //protected $config  =	array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'第一页','last'=>'最后一页','theme'=>' %totalRow% %header% %nowPage%/%totalPage% 页 %upPage% %downPage% %first%  %prePage%  %linkPage%  %nextPage% %end%');
    protected $config  =    array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'第一页','last'=>'最后一页','theme'=>'%upPage% %first%  %linkPage%  %end% %downPage%');
    // 默认分页变量名
    protected $varPage;

    /**
     +----------------------------------------------------------
     * 架构函数
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     +----------------------------------------------------------
     */
    public function __construct($totalRows,$listRows='',$parameter='') {
        $this->totalRows = $totalRows;
        $this->parameter = $parameter;
        $this->varPage = C('VAR_PAGE') ? C('VAR_PAGE') : 'p' ;
        if(!empty($listRows)) {
            $this->listRows = intval($listRows);
        }
        //$this->totalPages = ceil($this->totalRows/($this->listRows*5));     //总页数
        $this->totalPages = ceil($this->totalRows/($this->listRows*1));     //总页数
        $this->coolPages  = ceil($this->totalPages/$this->rollPage);
        $this->nowPage  = !empty($_GET[$this->varPage])?intval($_GET[$this->varPage]):1;
        if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
        $this->firstRow = $this->listRows*($this->nowPage-1);
    }

    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }

    /**
     +----------------------------------------------------------
     * 分页显示输出
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     */
    public function show() {
        if(0 == $this->totalRows) return '';
        $p = $this->varPage;
        $nowCoolPage      = ceil($this->nowPage/$this->rollPage);
        $url  =  $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?").$this->parameter;
        $parse = parse_url($url);
        if(isset($parse['query'])) {
            parse_str($parse['query'],$params);
            unset($params[$p]);
            $url   =  $parse['path'].'?'.http_build_query($params);
        }
        //上下翻页字符串
        $upRow   = $this->nowPage-1;
        $downRow = $this->nowPage+1;
        if ($upRow>0){
            $upPage="<a class='prev_page' href='".$url."&".$p."=$upRow'>".$this->config['prev']."</a>";
        }else{
            $upPage="";
        }

        if ($downRow <= $this->totalPages){
            $downPage="<a class='next_page' href='".$url."&".$p."=$downRow'>".$this->config['next']."</a>";
        }else{
            $downPage="";
        }
        // << < > >>
        if($nowCoolPage == 1){
            $theFirst = "";
            $prePage = "";
        }else{
            $preRow =  $this->nowPage-$this->rollPage;
            //$prePage = "<a href='".$url."&".$p."=$preRow' >上".$this->rollPage."页</a>";
            //$theFirst = "<a href='".$url."&".$p."=1' >".$this->config['first']."</a>";
        }
        if($nowCoolPage == $this->coolPages){
            $nextPage = "";
            $theEnd="";
        }else{
            $nextRow = $this->nowPage+$this->rollPage;
            $theEndRow = $this->totalPages;
            //$nextPage = "<a href='".$url."&".$p."=$nextRow' >下".$this->rollPage."页</a>";
            //$theEnd = "<a href='".$url."&".$p."=$theEndRow' >".$this->config['last']."</a>";
        }
        // 1 2 3 4 5
/*        $linkPage = "";
        for($i=1;$i<=$this->rollPage;$i++){
            $page=($nowCoolPage-1)*$this->rollPage+$i;
            if($page!=$this->nowPage){
                if($page<=$this->totalPages){
                    $linkPage .= "<a href='".$url."&".$p."=$page'>".$page."</a>";
                }else{
                    break;
                }
            }else{
                if($this->totalPages != 1){
                    $linkPage .= "<a class='current'>".$page."</a>";
                }
            }
        }*/

       // by motor
         $pageCnt = 2;
         $pageCnt2 = 4;

         if($this->nowPage!=1)
           $linkPage .= "<a href='".$url."&".$p."=1'>1</a>";


         if($this->nowPage-$pageCnt - 1 > $pageCnt2)
             $linkPage .= "<span>...</span>";
         else{
             for($i=1;$i<$this->nowPage-$pageCnt - 1;$i++){
                  $temp = 1+$i;
                  $linkPage .= "<a href='".$url."&".$p."=$temp'>".$temp."</a>";
             }
           
         }



         for($i = $pageCnt ; $i >= 1; $i--){
              $temp = $this->nowPage-$i;
              if($temp>1) 
              $linkPage .= "<a href='".$url."&".$p."=$temp'>".$temp."</a>";

         }

         $linkPage .= "<a class='current'>".$this->nowPage."</a>";
         $last = $this->nowPage;
  
         for($i=1;$i<=$pageCnt;$i++){
              $temp = $this->nowPage+$i;
              if($temp < $this->totalPages){
                 $linkPage .= "<a href='".$url."&".$p."=$temp'>".$temp."</a>";
                 $last = $temp;
              }

         }

         if($this->totalPages - $last > $pageCnt2)
           $linkPage .= "<span>...</span>";
         else{
             for($i=1;$i<$this->totalPages - $last;$i++){
                  $last += $i;
                  $linkPage .= "<a href='".$url."&".$p."=$last'>".$last."</a>";
             }
           
         }
         if($this->nowPage!=$this->totalPages)
            $linkPage .= "<a href='".$url."&".$p."=$this->totalPages'>".$this->totalPages."</a>";

        $pageStr	 =	 str_replace(
            array('%upPage%','%downPage%','%first%','%prePage%','%linkPage%','%nextPage%','%end%'),
            //array('%header%','%nowPage%','%totalRow%','%totalPage%','%first%','%upPage%','%linkPage%','%downPage%','%prePage%','%nextPage%','%end%'),
            array($upPage,$downPage,$theFirst,$prePage,$linkPage,$nextPage,$theEnd),$this->config['theme']);
            //array($this->config['header'],'<span class="nowPage">'.$this->nowPage.'</span>','<span class="totalRows">'.$this->totalRows.'</span>',$this->totalPages,$theFirst,$upPage,$linkPage,$downPage,$prePage,$nextPage,$theEnd),$this->config['theme']);
        return $pageStr;
    }
}