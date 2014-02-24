<?php

class Admin_ThisinhController extends App_Controller_AdminController {

    public function init() {
        parent::init();
    }

    public function indexAction() {
    	$facebook = new Ishali_Facebook();  
	 	$this->view->fbuserid = $facebook->getuserfbid();
	 	
	 	$request = $this->getRequest();
        $this->view->curr_page = $request->getParam('search_page', 1);
        $this->view->count = 15;
	 	
	 	
		if(isset($_GET['pageid']) && $_GET['pageid']>0)
		{
			$this->view->pageid = $_GET['pageid'];
			$this->view->page_name = $_GET['pagename'];
			$this->view->list_pages = App_Models_PagesModel::getInstance()->listSelectPages($this->view->fbuserid);

			
			
			$result = App_Models_ImageInfoModel::getInstance()->getListByFbPage_admin($this->view->pageid, $this->view->curr_page, $this->view->count);
	    	$this->view->total = $result['total'];
	        $this->view->listThisinh = $result['data'];
	        $paging = array();
	        $paging['totalRecord'] = $result['total'];
	        $paging['currentPage'] = $this->view->curr_page;
	        $paging['numDisplay'] = 5;
	        $paging['pageSize'] = $this->view->count;
	        $paging['action'] = APP_DOMAIN . '/admin/thisinh';
	
	        $this->view->paging = json_encode($paging);
	        
			$layoutPath = APPLICATION_PATH . '/templates/giaodien_admin';
	        $option = array('layout' => 'install', 'layoutPath' => $layoutPath);
	        Zend_Layout::startMvc($option);
		}
		else 
		{
			$PagesList = App_Models_PagesModel::getInstance()->getList('','','',$this->view->fbuserid);
			$this->view->page_name =$PagesList[0]['page_name'];
			$this->view->pageid = $PagesList[0]['id_fb_page'];
			$this->view->list_pages = App_Models_PagesModel::getInstance()->listSelectPages($this->view->fbuserid);
			
	        $result = App_Models_ImageInfoModel::getInstance()->getListByFbPage_admin($this->view->pageid, $this->view->curr_page, $this->view->count);
	    	$this->view->total = $result['total'];
	        $this->view->listThisinh = $result['data'];
	        $paging = array();
	        $paging['totalRecord'] = $result['total'];
	        $paging['currentPage'] = $this->view->curr_page;
	        $paging['numDisplay'] = 5;
	        $paging['pageSize'] = $this->view->count;
	        $paging['action'] = APP_DOMAIN . '/admin/thisinh';
	
	        $this->view->paging = json_encode($paging);
		
		}
		
			
			
	}
	
    public function addAction() {
    	if(isset($_GET['thisinhid']) && $_GET['thisinhid'] > 0)
    	{
    		$id = $_GET['thisinhid'];
    		$thisinhdetail = App_Models_ImageInfoModel::getInstance()->getDetail($id);
    		
   			$this->view->id_thi_sinh = $thisinhdetail->id_thi_sinh;
   			$this->view->id_fb_thi_sinh = $thisinhdetail->id_fb_thi_sinh;
   			$this->view->ten_thi_sinh  = $thisinhdetail->ten_thi_sinh;
   			$this->view->ngay_sinh = $thisinhdetail->ngay_sinh;
   			$this->view->gioi_tinh = $thisinhdetail->gioi_tinh;
   			$this->view->cmnd = $thisinhdetail->cmnd;
   			$this->view->gioi_thieu = $thisinhdetail->gioi_thieu;
   			$this->view->hinh_du_thi = $thisinhdetail->hinh_du_thi;
   			$this->view->mo_ta_bai_thi = $thisinhdetail->mo_ta_bai_thi;
   			$this->view->ngay_tham_gia = $thisinhdetail->ngay_tham_gia;
   			$this->view->an_hien = $thisinhdetail->an_hien;
   			$this->view->luot_xem = $thisinhdetail->luot_xem;
   			$this->view->luot_binh_chon = $thisinhdetail->luot_binh_chon;
   			$this->view->id_fb_page = $thisinhdetail->id_fb_page;
   			$this->view->email = $thisinhdetail->email;
   			$this->view->so_dien_thoai = $thisinhdetail->so_dien_thoai;
    	}
    	
    	
    	
//    	$layoutPath = APPLICATION_PATH . '/templates/giaodien_admin';
//	  	$option = array('layout' => 'install', 'layoutPath' => $layoutPath);
//	    Zend_Layout::startMvc($option);
    	
	}

    public function saveAction() {
//	App_Models_ThisinhModel::getInstance()->save();
	
		$this->view->errorCode = -1;
        $request = $this->getRequest();
        $info = new App_Entities_ImageInfo();
        
        if ($request->isPost()) {
            $info->id_fb_thi_sinh =$request->getParam('id_fb_thi_sinh', 1);
            $info->id_fb_page =$request->getParam('id_fb_page', 1);
            $info->ngay_tham_gia = time();

            $info->an_hien = $request->getParam('an_hien', 0);
            $info->cmnd = $request->getParam('cmnd', '');
             $info->so_dien_thoai = $request->getParam('so_dien_thoai', '');
            $info->email = $request->getParam('email', '');            
            $info->gioi_thieu = $request->getParam('gioi_thieu', '');
            $info->gioi_tinh = $request->getParam('gioi_tinh', 0);
            
            $hinh_du_thi = $request->getParam('hinh_du_thi', '');
            $arr = split("[;]", $hinh_du_thi);
            $info->hinh_du_thi = json_encode($arr);            
            
            $info->mo_ta_bai_thi = $request->getParam('mo_ta_bai_thi', '');
            $birthday = $request->getParam('ngay_sinh', '');
            if (!empty($birthday)) {
                $arr = split("[/,-,:, ]", $birthday);
                $info->ngay_sinh = mktime(0, 0, 0, $arr[0], $arr[1], $arr[2]);
            }

            $info->ten_thi_sinh = $request->getParam('ten_thi_sinh', '');

            if (App_Models_ImageInfoModel::getInstance()->put($info) > 0) {
                $this->view->message = 'Lưu thành công';
                $this->view->errorCode = 0;                
            } else {
                $this->view->message = 'Lưu thất bại';
            }
            
//            $this->view->hinh_du_thi = $hinh_du_thi;                    
        }
	
	}
	
    public function deleteAction() {
    	$id = $_GET['thisinhid'];
    	App_Models_ImageInfoModel::getInstance()->remove($id);
	}
	
	   public function exportAction() {
	   		$id_encode = $_REQUEST['ipg'];
	   		$this->view->page_name = $_REQUEST['pagename'];
	   		$id_decode = base64_decode($id_encode);
	   		$this->view->pageid = substr($id_decode, 2,strlen($id_decode));
		 	
	   		$result = App_Models_ImageInfoModel::getInstance()->getListByFbPage_admin($this->view->pageid, 1, 200);
	    	$this->view->total = $result['total'];
	        $this->view->listThisinh = $result['data'];
	        
	       	$layoutPath = APPLICATION_PATH . '/templates/giaodien_admin';
		  	$option = array('layout' => 'install', 'layoutPath' => $layoutPath);
		    Zend_Layout::startMvc($option);
	   }
	   
    public function updatestatusAction() {
//    	$status = $_GET['status'];
//    	$idthisinh = $_GET['idthisinh'];

    	$info = new App_Entities_ImageInfo();
    	$info->an_hien = $_GET['status'];
    	$info->id_thi_sinh = $_GET['idthisinh'];
    	
    	App_Models_ImageInfoModel::getInstance()->update_status($info);
    
     	$layoutPath = APPLICATION_PATH . '/templates/giaodien_admin';
	  	$option = array('layout' => 'install', 'layoutPath' => $layoutPath);
	    Zend_Layout::startMvc($option);
	}
	
	public function detailAction() {

    	if(isset($_GET['thisinhid']) && $_GET['thisinhid'] > 0)
    	{
    		$id = $_GET['thisinhid'];
    		$this->view->page_name = $_GET['page_name'];
    		$thisinhdetail = App_Models_ImageInfoModel::getInstance()->getDetail($id);
   			$this->view->id_thi_sinh = $thisinhdetail->id_thi_sinh;
   			$this->view->id_fb_thi_sinh = $thisinhdetail->id_fb_thi_sinh;
   			$this->view->ten_thi_sinh  = $thisinhdetail->ten_thi_sinh;
   			$this->view->ngay_sinh = $thisinhdetail->ngay_sinh;
   			$this->view->gioi_tinh = $thisinhdetail->gioi_tinh;
   			$this->view->cmnd = $thisinhdetail->cmnd;
   			$this->view->gioi_thieu = $thisinhdetail->gioi_thieu;
   			$this->view->hinh_du_thi = $thisinhdetail->hinh_du_thi;
   			$this->view->mo_ta_bai_thi = $thisinhdetail->mo_ta_bai_thi;
   			$this->view->ngay_tham_gia = $thisinhdetail->ngay_tham_gia;
   			$this->view->an_hien = $thisinhdetail->an_hien;
   			$this->view->luot_xem = $thisinhdetail->luot_xem;
   			$this->view->luot_binh_chon = $thisinhdetail->luot_binh_chon;
   			$this->view->id_fb_page = $thisinhdetail->id_fb_page;
   			$this->view->email = $thisinhdetail->email;
   			$this->view->so_dien_thoai = $thisinhdetail->so_dien_thoai;
    	}
    	
    	
    	
    	$layoutPath = APPLICATION_PATH . '/templates/giaodien_admin';
	  	$option = array('layout' => 'install', 'layoutPath' => $layoutPath);
	    Zend_Layout::startMvc($option);
	}
	
	public function binhchonAction() {
		$request = $this->getRequest();
        $this->view->curr_page = $request->getParam('search_page', 1);
        $this->view->count =20;
    	if(isset($_GET['thisinhid']) && $_GET['thisinhid'] > 0)
    	{
    		$facebook = new Ishali_Facebook();  
	 		$this->view->fbuserid = $facebook->getuserfbid();
    		$this->view->list_pages = App_Models_PagesModel::getInstance()->listSelectPages($this->view->fbuserid);
    		$this->view->pagename =  $request->getParam('pagename');
    		$this->view->pageid = $request->getParam('pageid', 0);
    		$this->view->id = $request->getParam('thisinhid', 0);
//    		$this->view->page_name = $_GET['page_name'];
    		$binhchondetail = App_Models_ImageInfoModel::getInstance()->getBinhchon($this->view->id,  $this->view->curr_page, $this->view->count);
    		
   			$this->view->binhchondetail = $binhchondetail;
	    	$this->view->total = $binhchondetail['total'];
	        $paging = array();
	        $paging['totalRecord'] = $binhchondetail['total'];
	        $paging['currentPage'] = $this->view->curr_page;
	        $paging['numDisplay'] = 2;
	        $paging['pageSize'] = $this->view->count;
	        $paging['action'] = APP_DOMAIN . "/admin/thisinh/binhchon";
	        $this->view->paging = json_encode($paging);
    	}
    	
    	if($request->getParam('isajax'))
    	{
	    	$layoutPath = APPLICATION_PATH . '/templates/giaodien_admin';
		  	$option = array('layout' => 'install', 'layoutPath' => $layoutPath);
		    Zend_Layout::startMvc($option);
    	}
	}
	
  	public function exportbinhchonAction() {
	   		$id_encode = $_REQUEST['ipg'];
	   		$this->view->page_name = $_REQUEST['pagename'];
	   		$this->view->tts = $_REQUEST['tts'];
	   		$id_decode = base64_decode($id_encode);
	   		$this->view->id = substr($id_decode, 2,strlen($id_decode));
		 	
	   		$result = App_Models_ImageInfoModel::getInstance()->getBinhchon($this->view->id, 1, 200);
	    	$this->view->total = $result['total'];
	        $this->view->listbinhchon = $result['data'];
	        
	       	$layoutPath = APPLICATION_PATH . '/templates/giaodien_admin';
		  	$option = array('layout' => 'install', 'layoutPath' => $layoutPath);
		    Zend_Layout::startMvc($option);
	   }

}

